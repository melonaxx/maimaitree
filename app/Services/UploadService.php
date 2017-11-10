<?php

namespace App\Services;
require_once __DIR__.'/../../vendor/qiniu/php-sdk/autoload.php';
use Illuminate\Http\Request;
use App\Extend\Utils;
use App\Extend\CacheDriver;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use App\Repositories\Backend\SomeupsRepository;

class UploadService
{
    protected static $_auth = null;
    protected static $_uploadmanager = null;
    const IMG_DOMAIN = 'http://img.maimaitree.com/';

    public $someupsRepository;
    public function __construct(SomeupsRepository $someupsRepo)
    {
        $this->someupsRepository = $someupsRepo;

        if (is_null(self::$_auth)) {
            // 构建鉴权对象
            self::$_auth = new Auth(env('QINIU_ACCESSKEY'), env('QINIU_SECRETKEY'));
        }

        if (is_null(self::$_uploadmanager)) {
            // 初始化 UploadManager 对象并进行文件的上传。
            self::$_uploadmanager = new UploadManager();
        }

    }

    /**
     * 上传文件
     * @param string $filePath
     * @param string $originName
     * @return bool|mixed
     */
    public function putFile($filePath='', $originName='')
    {
        if (!$filePath || !is_readable($filePath)) {
            return false;
        }

        // 生成上传 Token
        $token = self::$_auth->uploadToken('carpool');

        // 要上传文件的本地路径
        $file_path = $filePath;

        // 上传到七牛后保存的文件名
        $file_key = mt_rand(1,100000).$originName;

        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = self::$_uploadmanager->putFile($token, $file_key, $file_path);

        $file_size = filesize($file_path);
        $data = array();
        $data['size'] = $file_size;
        $data['source'] = self::IMG_DOMAIN.$file_key;

        if ($err !== null) {
            return false;
        } else {
            $data['ext'] = $ret['hash'];
            $data['title'] = $originName ? :$ret['key'];
            $data['file_name'] = $ret['key'];
        }

        $res = $this->someupsRepository->create($data);
        if (!$res) {
            return false;
        } else {
            $res = $res->toArray();
        }

        return $res;
    }

    /**
     * 上传多个文件
     * @param array $file_arr
     * @return bool
     */
    public function putMultipleFile($file_arr=array())
    {
        if (!$file_arr) {
            return false;
        }

        $r_data = true;
        foreach ($file_arr as $f_key=>$f_value) {
            $realPath = $f_value->getRealPath();
            $originalName = $f_value->getClientOriginalName();
            $res = $this->putFile($realPath,$originalName);
            if (!$res) {
                $r_data = false;
                break;
            }
        }

        return $r_data ? true : false;
    }
}