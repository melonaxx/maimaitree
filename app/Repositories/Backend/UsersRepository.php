<?php

namespace App\Repositories\Backend;

use App\Models\Backend\Users;
use App\User;
use InfyOm\Generator\Common\BaseRepository;

class UsersRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'openid',
        'name',
        'nickname',
        'sex',
        'age',
        'phone',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Users::class;
    }

    public function getInfoByUid($uid)
    {
        $user = false;
        if ($uid) {
            $user = Users::find($uid);
            if (!$user) {
                $user = false;
            }
        }
        return $user;
    }
}
