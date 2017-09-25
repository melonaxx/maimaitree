<?php

namespace App\Repositories\Backend;

use App\Models\Backend\RecordUser;
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
        $record_list = RecordWork::where('uid', $uid)->where('date','like', "$date%")->get()->toArray();

        return $record_list;
    }

    /**
     * 用户在一个月内的收总和
     * @param $uid
     * @param $date
     * @return float|int
     */
    public function getTotalSalaryByUid($uid, $date)
    {
        $record_list = RecordWork::where('uid', $uid)->where('date','like', "$date%")->get()->toArray();
        var_dump($record_list);
        $salary_total = '0';
        foreach ($record_list as $item) {
var_dump($item);
            if (in_array($item['type'], [101,102])) {
                $salary_total+=$item['salary'];
            } else {
                $salary_total-=$item['salary'];
            }

        }
echo ($salary_total);
        return $salary_total/100;
    }
}
