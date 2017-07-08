<?php

namespace App\Http\Controllers\API;
session_start();

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Response;
use App\Extend\Utils;
use Illuminate\Support\Facades\Redis;
use App\Models\Backend\RecordWork;

/**
 * Class WeixinController
 * @package App\Http\Controllers\API
 */

class WeixinAPIController extends AppBaseController
{

    const TOKEN = 'yLqTwVhCnZbUBchmM7dKCwzau278GWT9';
    const WX_APPID = 'wx6dc1d972e14ac50a';
    const WX_SECRET = 'e3845ad66fb5ada5186220e0b236c1c9';

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
     * weixin login()
     * @param Request $request
     * @return Response
     */
    public function wxAppRecordLogin(Request $request)
    {
        $code = $request->input('code','');
        $get_open_id_url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.self::WX_APPID.'&secret='.self::WX_SECRET.'&js_code='.$code.'&grant_type=authorization_code';
        $open_res = Utils::simpleRequest($get_open_id_url);

        $data        = json_decode($open_res,true);

        if (is_array($data) && !isset($data['errcode'])) {
            $open_id     = $data['openid'];
            $session_key = $data['session_key'];
            $token  = self::TOKEN;

            $rd3_session        = $open_id.';'.$session_key.';'.$token;
            $rd3_key            = md5($rd3_session);
            $_SESSION['test'] = 'okkkk';
            $_SESSION[$rd3_key] = $rd3_session;
            $wx_data = array('rd3_session'=>$rd3_key,'session'=>$_SESSION);
        } else {
            $wx_data = array();
        }

        return $this->sendResponse($wx_data);

    }

    /**
     * 记工簿首页接口
     * @param  Request $request
     * @return mixed
     */
    public function recordIndex(Request $request)
    {
        dd(Redis::get('okk'));
        $date = $request->input('date','');
        $rd3_session = $request->input('rd3_session','');
        //069ac321a85d4c3d78be6eb1aa75820a
        //4f1302b293b8fbd6c5ee316b9a4a79e1
        $date = Utils::checkDateIsValid($date) ? $date : date('Y-m');
        $month_record = array();
        $wx_oppen_id = 'no';

        //获取user openid
        if ($rd3_session != '' && isset($_SESSION[$rd3_session]) && $_SESSION[$rd3_session] != '') {
            $rd3_str = explode(';', $_SESSION[$rd3_session]);

            if (count($rd3_str) >= 3) {
                $wx_oppen_id = $rd3_str[0];
            }

        }

        for ($i=1; $i < 18; $i++) {

            $one_record = array(
                'id' => (string)$i,
                'current' => (string)$i,
                'title' => $date ? '加班' : '出勤',
                'remark' => $date ? '嗯，又加班！' : '好的一天，不错',
                'day' => $date ? '1小时' : '1天',
                'salary' => $date ? '80元' : '220元',
            );
            array_push($month_record, $one_record);
        }

        $data = array(
            'title' => (int)date('m',strtotime($date)).'月当前工资',
            'curr_salary' => '4882.94',
            'day_salary' => '220',
            'date' => $date,
            'date_time' => $date,
            'work_day' => '23',
            'openid' => $wx_oppen_id,
            'rd3_session' => $rd3_session,
            'session' => $_SESSION,
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

        $res = array('daySalary'=>$day_salary);
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
                    'image' => '/public/images/work.png',
                ),
                array(
                    'id' => '2',
                    'title' => '加班',
                    'image' => '/public/images/overtime.png',
                ),
                array(
                    'id' => '3',
                    'title' => '请假',
                    'image' => '/public/images/leave.png',
                ),
                array(
                    'id' => '4',
                    'title' => '调休',
                    'image' => '/public/images/rest.png',
                ),
                array(
                    'id' => '5',
                    'title' => '旷工',
                    'image' => '/public/images/absenteeism.png',
                ),
            ),
            'id' => $record_id,
            'date_time' => '2017-06-14',
            'type' => '2',
            'salary' => '220',
            'remark' => '加班好辛苦哦！',
            'inctype' => array('1','2'),
            'dectype' => array('3','4','5'),
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
