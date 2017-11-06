<?php

namespace App\Models\Backend;

use Eloquent as Model;
use App\Extend\CacheDriver;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Users
 * @package App\Models\Backend
 * @version October 31, 2017, 1:49 pm UTC
 */
class Users extends Model
{
    use SoftDeletes;

    public $table = 'users';

    protected $dates = ['deleted_at'];

    const REDIS_KEY = 'CARPOOL_MAP';

    const SOURCE_RECORD_BOOK = 1;//记工簿
    const SOURCE_CARPOOL = 2;//拼车

    const SEX_SECURITY = 1;
    const SEX_BOY = 2;
    const SEX_GIRL = 3;
    public static $SEX = array(
        self::SEX_SECURITY=>array('name'=>'保密'),
        self::SEX_BOY=>array('name'=>'男'),
        self::SEX_GIRL=>array('name'=>'女'),
    );

    const STATUS_NORMAL = 1;
    const STATUS_STOP = 2;
    public $STATUS = array(
        self::STATUS_NORMAL=>array('name'=>'正常'),
        self::STATUS_STOP=>array('name'=>'停用'),
    );

    public $fillable = [
        'openid',
        'name',
        'nickname',
        'sex',
        'age',
        'phone',
        'country',
        'province',
        'city',
        'avatar',
        'source',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'openid' => 'string',
        'name' => 'string',
        'nickname' => 'string',
        'phone' => 'string',
        'country' => 'string',
        'province' => 'string',
        'avatar' => 'string',
        'city' => 'string',
        'source' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * 获取常量
     * @param  array  $static
     * @param  boolean $isSelect 是否是select
     * @return
     */
    public static function getStaticData($static, $isSelect=false)
    {
        $data = array();

        foreach ($static as $key => $value) {
            $data[$key] = $value['name'];
        }

        if ($isSelect) {
            $data = array('0'=>'--请选择--')+$data;
        }

        return $data;
    }

    public static function getUidByToken($token)
    {
        $uid = '';
        if ($token) {
            $cache = CacheDriver::HGET(self::REDIS_KEY, $token);
            $cache_arr = $cache ? explode(';',$cache) : [];
            $uid = $cache_arr ? $cache_arr[1] : '';
        }

        return $uid;
    }

    public static function getInfoByToken($token)
    {
        $uid = '';
        $info = array();
        if ($token) {
            $cache = CacheDriver::HGET(self::REDIS_KEY, $token);
            $cache_arr = $cache ? explode(';',$cache) : [];
            $uid = $cache_arr ? $cache_arr[1] : '';
        }

        if ($uid) {
            $u_res = self::find($uid);
            $info = $u_res ? $u_res->toArray() : [];
        }

        return $info;
    }

    public static function getNameByUid($uid)
    {
        $name = '';
        if ($uid) {
            $u_res = self::find($uid);
            $name = $u_res ? ($u_res->name ? $u_res->name : $u_res->nickname) : '';
        }

        return $name;
    }

    public static function getInfoByUid($uid)
    {
        $info = array();
        if ($uid) {
            $u_res = self::find($uid);
            $info = $u_res ? $u_res->toArray(): array();
        }

        return $info;
    }
    
}
