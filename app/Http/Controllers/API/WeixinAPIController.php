<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Response;

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
    public function recordindex(Request $request)
    {
        $date = $request->input('date','');

        $data = array(
            'title' => '6月当前工资',
            'curr_salary' => '4882.94',
            'day_salary' => '单日工资220元',
            'date' => '2017-06',
            'date_time' => '2017-06-14',
            'work_day' => '23',
            'month_record' => array(
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
                array(
                    'id' => '1',
                    'title' => '出勤',
                    'remark' => '好的一天，不错_1',
                    'day' => '1天',
                    'salary' => '220元',
                ),
            ),
        );

        return $this->sendResponse($data);

    }

    /**
     * show添加记工页
     * @param  Request $request
     * @return mixed
     */
    public function recordcreate(Request $request)
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
            'id' => '',
            'date_time' => '2017-06-14',
            'type' => '1',
            'salary' => '220',
            'remark' => '',
        );

        return $this->sendResponse($data);

    }

}
