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

    /**
     * 通过uid，时间获取用户工作记录
     * @param $uid
     * @return mixed
     */
    public function getRecordListByUidTime($uid, $date)
    {
        $record_list = RecordWork::where('uid', $uid)->where('date', $date)->get()->toArray();

        return $record_list;
    }
}
