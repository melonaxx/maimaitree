<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Test
 * @package App\Models
 * @version June 6, 2017, 2:46 pm UTC
 */
class Test extends Model
{
    use SoftDeletes;

    public $table = 'tests';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'post_date',
        'body',
        'password',
        'token',
        'email',
        'author_gender',
        'post_type',
        'post_visits',
        'category',
        'category_short',
        'is_private',
        'ext1',
        'ext2',
        'ext3',
        'ext4'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'body' => 'string',
        'password' => 'string',
        'token' => 'string',
        'email' => 'string',
        'author_gender' => 'integer',
        'post_type' => 'string',
        'post_visits' => 'integer',
        'category' => 'string',
        'category_short' => 'string',
        'is_private' => 'boolean',
        'ext1' => 'string',
        'ext2' => 'string',
        'ext3' => 'string',
        'ext4' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
