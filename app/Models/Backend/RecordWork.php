<?php

namespace App\Models\Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RecordWork
 * @package App\Models\Backend
 * @version July 8, 2017, 7:03 am UTC
 */
class RecordWork extends Model
{
    use SoftDeletes;
    public $table = 'record_works';
    protected $dates = ['deleted_at'];

    const TYPE_WORK        = '101';
    const TYPE_OVERTIME    = '102';
    const TYPE_LEAVE       = '103';
    const TYPE_REST        = '104';
    const TYPE_ABSENTEEISM = '105';
    public static $TYPELIST = array(
        self::TYPE_WORK => array(
            'id'    => '101',
            'title' => '出勤',
            'image' => '/public/images/work.png',
        ),
        self::TYPE_OVERTIME => array(
            'id'    => '102',
            'title' => '加班',
            'image' => '/public/images/overtime.png',
        ),
        self::TYPE_LEAVE => array(
            'id'    => '103',
            'title' => '请假',
            'image' => '/public/images/leave.png',
        ),
        self::TYPE_REST => array(
            'id'    => '104',
            'title' => '调休',
            'image' => '/public/images/rest.png',
        ),
        self::TYPE_ABSENTEEISM => array(
            'id'    => '105',
            'title' => '旷工',
            'image' => '/public/images/absenteeism.png',
        ),
    );

    public $fillable = [
        'uid',
        'type',
        'classify',
        'salary',
        'remark',
        'date',
        'work_time',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'uid'       => 'integer',
        'salary'    => 'integer',
        'remark'    => 'string',
        'work_time' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
}
