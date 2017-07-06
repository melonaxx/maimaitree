<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Response;
use App\Extend\Utils;

/**
 * Class WeixinController
 * @package App\Http\Controllers\API
 */

class WeixinAPIController extends AppBaseController
{

    const TOKEN = 'yLqTwVhCnZbUBchmM7dKCwzau278GWT9';

    /**
     * Display a listing of the Weixin.
     * GET|HEAD /weixins
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $signature = $request->input('signature','');
        $timestamp = $request->input('timestamp','');
        $nonce = $request->input('nonce','');

        $token = self::TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            echo $request->input('echostr','');
        }
        exit();

    }

    /**
     * 记工簿首页接口
     * @param  Request $request
     * @return mixed
     */
    public function recordIndex(Request $request)
    {
        $date = $request->input('date','');
        $date = Utils::checkDateIsValid($date) ? true : false;
        $month_record = array();

        for ($i=1; $i < 18; $i++) {

            $one_record = array(
                'id' => $i,
                'title' => $date ? '加班' : '出勤',
                'remark' => $date ? '我X，又加班！' : '好的一天，不错_1',
                'day' => $date ? '1小时' : '1天',
                'salary' => $date ? '80元' : '220元',
            );
            array_push($month_record, $one_record);
        }

        $data = array(
            'title' => '6月当前工资',
            'curr_salary' => '4882.94',
            'day_salary' => '单日工资220元',
            'date' => '2017-06',
            'date_time' => '2017-06-14',
            'work_day' => '23',
            'month_record' => $month_record,
        );

        return $this->sendResponse($data);

    }

    /**
     * 修改单日工资
     * @param Request $request
     */
    public function setDaySalary(Request $request)
    {
        $day_salary = $request->input('day_salary','');

        //这里修改用户单日工资操作 待完善...

        $res = array('e'=>'9999','m'=>'修改成功！');
        return $this->sendResponse($res);
    }

    /**
     * show添加记工页
     * @param  Request $request
     * @return mixed
     */
    public function recordCreate(Request $request)
    {
        $record_id = $request->input('id','');

        $data = array(
            'type_list' => array(
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'image' => '',
                ),
                array(
                    'id' => '2',
                    'title' => '加班',
                    'image' => '',
                ),
                array(
                    'id' => '3',
                    'title' => '请假',
                    'image' => '',
                ),
                array(
                    'id' => '4',
                    'title' => '调休',
                    'image' => '',
                ),
                array(
                    'id' => '5',
                    'title' => '旷工',
                    'image' => '',
                ),
            ),
            'id' => $record_id,
            'date_time' => '2017-06-14',
            'type' => '2',
            'salary' => '220',
            'remark' => '我是测试数据！',
        );

        return $this->sendResponse($data);

    }

    /**
     * 存储记工数据
     * @param  Request $request
     * @return mixed
     */
    public function recordStore(Request $request)
    {
        $data = $request->all();

        $res = is_array($data) ? array('e'=>'9999','m'=>'添加成功！') : array('e'=>'404','m'=>'添加失败！');
        return $this->sendResponse($res);
    }

  /**
   * 记工簿统计数据页
   * @param  Request $request
   * @return mixed
   */
    public function recordStatistics(Request $request)
    {
        $date = $request->input('date','');

        $series_data = array(
            array('name'=>'出勤','data'=>'23','color'=>'#87CECB'),
            array('name'=>'加班','data'=>'3','color'=>'#90EE90'),
            array('name'=>'请假','data'=>'1','color'=>'#FFD700'),
            array('name'=>'调休','data'=>'2','color'=>'#D2B48C'),
            array('name'=>'旷工','data'=>'0','color'=>'#FA8072'),
        );
        $progress_data = array(
            array('name'=>'出勤','day'=>'23','percent'=>'60','color'=>'#87CECB'),
            array('name'=>'加班','day'=>'3','percent'=>'10','color'=>'#90EE90'),
            array('name'=>'请假','day'=>'2','percent'=>'5','color'=>'#FFD700'),
            array('name'=>'调休','day'=>'1','percent'=>'2','color'=>'#D2B48C'),
            array('name'=>'旷工','day'=>'0','percent'=>'0','color'=>'#FA8072')
        );
        $date_data = array(
            'date_time'=>date('Y-m'),
            'month'=>(int)date('m'),
        );

        if ($date && Utils::checkDateIsValid($date)) {
            $date_data = array(
                'date_time'=>date('Y-m',strtotime($date)),
                'month'=>(int)date('m',strtotime($date)),
            );
        }

        $data = array(
            'date'=>$date_data,
            'series'=>$series_data,
            'progress'=>$progress_data,
        );

        return $this->sendResponse($data);
    }

}
