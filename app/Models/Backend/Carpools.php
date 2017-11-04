<?php

namespace App\Models\Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Carpools
 * @package App\Models\Backend
 * @version October 31, 2017, 2:00 pm UTC
 */
class Carpools extends Model
{
    use SoftDeletes;

    public $table = 'carpools';

    protected $dates = ['deleted_at'];

    const STATUS_NORMAL = 1;
    const STATUS_ABNORMAL = 2;
    const STATUS_CANCEL = 3;
    public static $STATUS = array(
        self::STATUS_NORMAL => array('name'=>'进行中'),
        self::STATUS_ABNORMAL => array('name'=>'已结束'),
        self::STATUS_CANCEL => array('name'=>'已取消'),
    );

    const FREQUENCY_NORMAL = 1;
    const FREQUENCY_ABNORMAL = 2;
    public static $FREQUENCY = array(
        self::FREQUENCY_NORMAL => array('name'=>'临时'),
        self::FREQUENCY_ABNORMAL => array('name'=>'长期'),
    );

    public $fillable = [
        'uid',
        'name',
        'sex',
        'phone',
        'type',
        'origin',
        'origin_cross',
        'by_way',
        'terminal',
        'terminal_cross',
        'time',
        'number',
        'price',
        'license',
        'car_type',
        'volume',
        'weight',
        'frequency',
        'remark',
        'relief',
        'watch',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'uid'            => 'string',
        'name'           => 'string',
        'phone'          => 'string',
        'origin'         => 'string',
        'origin_cross'   => 'string',
        'by_way'         => 'string',
        'terminal'       => 'string',
        'terminal_cross' => 'string',
        'time'           => 'integer',
        'number'         => 'integer',
        'price'          => 'integer',
        'license'        => 'string',
        'car_type'       => 'string',
        'volume'         => 'string',
        'weight'         => 'integer',
        'remark'         => 'string',
        'watch'          => 'integer',
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

    public function getOriginCross($cross)
    {
        $origin_cross_arr = explode('&',$cross);
        $longitude = '';
        $latitude = '';
        if (count($origin_cross_arr) > 0) {
            $longitude = $origin_cross_arr[0];
            $latitude = $origin_cross_arr[1];
        }
        return array('longitude'=>$longitude,'latitude'=>$latitude);
    }
    public function getTerminalCross($cross)
    {
        $terminal_cross_arr = explode('&',$cross);
        $longitude = '';
        $latitude = '';
        if (count($terminal_cross_arr) > 0) {
            $longitude = $terminal_cross_arr[0];
            $latitude = $terminal_cross_arr[1];
        }
        return array('longitude'=>$longitude,'latitude'=>$latitude);
    }
    
}
