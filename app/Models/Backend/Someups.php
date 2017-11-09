<?php

namespace App\Models\Backend;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Someups
 * @package App\Models\Backend
 * @version November 9, 2017, 9:03 pm CST
 */
class Someups extends Model
{
    use SoftDeletes;

    public $table = 'someups';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'file_name',
        'source',
        'size',
        'ext',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'file_name' => 'string',
        'source' => 'string',
        'size' => 'integer',
        'ext' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
