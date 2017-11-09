<?php

namespace App\Services;
require_once __DIR__.'/../../vendor/qiniu/php-sdk/autoload.php';
use Illuminate\Http\Request;
use App\Extend\Utils;
use App\Extend\CacheDriver;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class UploadService
{
    protected static $_auth = null;
    protected static $_uploadmanager = null;
    public function __construct()
    {
        if (is_null(self::$_self)) {
            // 构建鉴权对象
            self::$_auth = new Auth(env('QINIU_ACCESSKEY'), env('QINIU_SECRETKEY'));
        }

        if (is_null(self::$_uploadmanager)) {
            // 初始化 UploadManager 对象并进行文件的上传。
            self::$_uploadmanager = new UploadManager();
        }

    }

    public function putFile($filePath='')
    {
        if (!$filePath || !is_readable($filePath)) {
            return false;
        }

        // 生成上传 Token
        $token = self::$_auth->uploadToken('carpool');

        // 要上传文件的本地路径
        $file_path = $filePath;

        // 上传到七牛后保存的文件名
        $file_key = basename($file_path);

        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = self::$_uploadmanager->putFile($token, $file_key, $file_path);

        $data = array();

        if ($err !== null) {
            return false;
        } else {
            $data['hash'] = $ret['hash'];
            $data['key'] = $ret['key'];
        }

        return $data;
    }
}