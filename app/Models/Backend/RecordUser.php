<?php

namespace App\Models\Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RecordUser
 * @package App\Models\Backend
 * @version July 9, 2017, 2:12 am UTC
 */
class RecordUser extends Model
{
    use SoftDeletes;

    public $table = 'record_users';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'openid',
        'uname',
        'nick_name',
        'gender',
        'daily_salary',
        'tel',
        'country',
        'province',
        'city'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'openid' => 'string',
        'uname' => 'string',
        'nick_name' => 'string',
        'daily_salary' => 'integer',
        'tel' => 'string',
        'country' => 'string',
        'province' => 'string',
        'city' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
