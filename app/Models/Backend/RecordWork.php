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
