<?php

namespace App\Repositories\Backend;

use App\Models\Backend\Someups;
use InfyOm\Generator\Common\BaseRepository;

class SomeupsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'file_name',
        'source',
        'size',
        'ext',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Someups::class;
    }
}
