<?php

namespace App\Services;


use App\Repositories\Backend\RecordUserRepository;

class UserService
{

    private $recordUserRepository;

    public function __construct(RecordUserRepository $recordUserRepository)
    {
        $this->recordUserRepository = $recordUserRepository;
    }

    public function getUid($openid)
    {
        $this->$recordUserRepository->getUid($openid);
    }

    public function getUserInfoByOpenId($openid)
    {
        $this->$recordUserRepository->getUserInfoByOpenId($openid);
    }

    public function addRecordUser($param)
    {
        $res = $this->$recordUserRepository->create($param);

        return $res ? true : false;
    }
}