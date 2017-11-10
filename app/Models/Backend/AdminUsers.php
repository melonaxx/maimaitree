<?php

namespace App\Models\Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AdminUsers
 * @package App\Models\Backend
 * @version November 10, 2017, 10:59 am CST
 */
class AdminUsers extends Model
{
    use SoftDeletes;

    public $table = 'admin_users';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'sex',
        'email',
        'mobile',
        'password',
        'creator',
        'channel',
        'status',
        'remember_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'mobile' => 'string',
        'password' => 'string',
        'creator' => 'integer',
        'channel' => 'integer',
        'remember_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
