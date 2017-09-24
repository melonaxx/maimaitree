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

    public static $TYPELIST = array(
        array(
            'id'    => '101',
            'title' => '出勤',
            'image' => '/public/images/work.png',
        ),
        array(
            'id'    => '102',
            'title' => '加班',
            'image' => '/public/images/overtime.png',
        ),
        array(
            'id'    => '103',
            'title' => '请假',
            'image' => '/public/images/leave.png',
        ),
        array(
            'id'    => '104',
            'title' => '调休',
            'image' => '/public/images/rest.png',
        ),
        array(
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
        'work_time'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'uid' => 'integer',
        'salary' => 'integer',
        'remark' => 'string',
        'work_time' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
