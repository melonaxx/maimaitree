<?php

namespace App\Repositories\Backend;

use App\Models\Backend\RecordUser;
use InfyOm\Generator\Common\BaseRepository;

class RecordUserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'openid',
        'uname',
        'nick_name',
        'gender',
        'daily_salary'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RecordUser::class;
    }
}
