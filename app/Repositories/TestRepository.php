<?php

namespace App\Repositories;

use App\Models\Test;
use InfyOm\Generator\Common\BaseRepository;

class TestRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
     * Configure the Model
     **/
    public function model()
    {
        return Test::class;
    }
}
