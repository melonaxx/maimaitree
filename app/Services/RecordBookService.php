<?php

namespace App\Services;


use App\Repositories\Backend\RecordUserRepository;
use App\Repositories\Backend\RecordWorkRepository;

class RecordBookService
{

    private $recordUserRepository;
    private $recordWorkRepository;

    public function __construct(RecordUserRepository $recordUserRepo, RecordWorkRepository $recordWorkRepo)
    {
        $this->recordUserRepository = $recordUserRepo;
        $this->recordWorkRepository = $recordWorkRepo;
    }

    public function getUid($openid)
    {
        $this->recordUserRepository->getUid($openid);
    }

}