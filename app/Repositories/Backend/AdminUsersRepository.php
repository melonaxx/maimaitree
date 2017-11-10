<?php

namespace App\Repositories\Backend;

use App\Models\Backend\AdminUsers;
use InfyOm\Generator\Common\BaseRepository;

class AdminUsersRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AdminUsers::class;
    }
}
