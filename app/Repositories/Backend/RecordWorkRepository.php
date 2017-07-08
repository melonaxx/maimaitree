<?php

namespace App\Repositories\Backend;

use App\Models\Backend\RecordWork;
use InfyOm\Generator\Common\BaseRepository;

class RecordWorkRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'uid',
        'type',
        'classify',
        'salary',
        'work_time'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RecordWork::class;
    }
}
