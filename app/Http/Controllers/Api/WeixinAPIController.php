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
use App\Repositories\Backend\RecordUserRepository;
use App\Repositories\Backend\RecordWorkRepository;

/**
 * Class WeixinController
 * @package App\Http\Controllers\API
 */
class WeixinAPIController extends AppBaseController
{
    const TOKEN     = 'yLqTwVhCnZbUBchmM7dKCwzau278GWT9';
    const WX_APPID  = 'wx6dc1d972e14ac50a';
    const WX_SECRET = 'e3845ad66fb5ada5186220e0b236c1c9';
    private $recordUserRepository;
    private $recordWorkRepository;

    public function __construct(RecordUserRepository $recordUserRepo, RecordWorkRepository $recordWorkRepo)
    {
        $this->recordUserRepository = $recordUserRepo;
        $this->recordWorkRepository = $recordWorkRepo;
    }

    /**
     * Display a listing of the Weixin.
     * GET|HEAD /weixins
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $signature = $request->input('signature', '');
        $timestamp = $request->input('timestamp', '');
        $nonce     = $request->input('nonce', '');

        $token  = self::TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            echo $request->input('echostr', '');
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
        $code            = $request->input('code', '');
        $user_res        = $request->input('userInfo', '');
        $get_open_id_url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . self::WX_APPID . '&secret=' . self::WX_SECRET . '&js_code=' . $code . '&grant_type=authorization_code';
        $open_res        = Utils::simpleRequest($get_open_id_url);

        $data = json_decode($open_res, true);

        if (is_array($data) && !isset($data['errcode'])) {
            $open_id     = $data['openid'];
            $session_key = $data['session_key'];
            $token       = self::TOKEN;
            $user_param  = array();

            $users = $this->recordUserRepository->findByField('openid', $open_id)->toArray();

            //添加用户信息
            if ($user_res && !$users) {
                $userInfo                   = json_decode($user_res, true);
                $user_param['openid']       = $open_id;
                $user_param['nick_name']    = $userInfo['nickName'];
                $user_param['gender']       = $userInfo['gender'];
                $user_param['daily_salary'] = 0;
                $user_param['tel']          = '';
                $user_param['country']      = $userInfo['country'];
                $user_param['province']     = $userInfo['province'];
                $user_param['city']         = $userInfo['city'];

                $aa = $this->recordUserRepository->create($user_param);
            }

            $record_key = 'record_books_keys';
            $user_id    = $open_id . ';' . $session_key . ';' . $token;
            $rd3_key    = md5(md5($user_id) . $token);
            Redis::command('HSET', [$record_key, $rd3_key, $user_id]);
            $wx_data = array('rd3_session' => $rd3_key);
        } else {
            return $this->sendError([], '404', '参数不正确！');
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
        $date         = $request->input('date', '');
        $rd3_session  = $request->input('rd3_session', '');
        $date         = Utils::checkDateIsValid($date) ? $date : date('Y-m');
        $uid          = $this->recordUserRepository->getUid($rd3_session);
        $user         = $this->recordUserRepository->getUserInfoByOpenId($rd3_session);
        $month_record = array();
        $work_day  = '0';

        if ($uid && $date) {
            $user_record = $this->recordWorkRepository->getRecordListByUidTime($uid, $date);
            $work_day = count($user_record);

            foreach ($user_record as $u_key => $u_value) {
                $one_record = array(
                    'id'      => (string)$u_value['id'],
                    'current' => (string)date('d', strtotime($u_value['date'])),
                    'title'   => RecordWork::$TYPELIST[$u_value['type']]['title'],
                    'remark'  => $u_value['remark'] ?: '',
                    'day'     => $u_value['type'] == RecordWork::TYPE_WORK ? '1天' : '',
                    'salary'  => $u_value['salary'] . '元',
                );
                array_push($month_record, $one_record);
            }

        }


        for ($i = 1; $i < 18; $i++) {

            $one_record = array(
                'id'      => (string)$i,
                'current' => (string)$i,
                'title'   => $date ? '加班' : '出勤',
                'remark'  => $date ? '嗯，又加班！' : '好的一天，不错',
                'day'     => $date ? '1小时' : '1天',
                'salary'  => $date ? '80元' : '220元',
            );
            array_push($month_record, $one_record);
        }

        $data = array(
            'title'        => (int)date('m', strtotime($date)) . '月当前工资',
            'curr_salary'  => '4882.94',
            'day_salary'   => $user['daily_salary'],
            'date'         => $date,
            'date_time'    => $date,
            'work_day'     => $work_day,
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
        $day_salary  = $request->input('day_salary', '');
        $rd3_session = $request->input('rd3_session', '');

        $uid = $this->recordUserRepository->getUid($rd3_session);
        //这里修改用户单日工资操作
        if ($day_salary && $uid) {
            $this->recordUserRepository->update(['daily_salary' => $day_salary], $uid);
        }

        $res = array('daySalary' => $day_salary);

        return $this->sendResponse($res);
    }

    /**
     * show添加记工页
     * @param  Request $request
     * @return mixed
     */
    public function recordCreate(Request $request)
    {
        $record_id  = $request->input('id', '');
        $record_res = $record_id ? ($this->recordWorkRepository->findWithoutFail($record_id)->toArray() ?: []) : [];
        $date_time  = date('Y-m-d');
        $type       = '101';
        $salary     = '';
        $remark     = '';
        $inctype    = array('101', '102');
        $dectype    = array('103', '104', '105');


        if ($record_id && $record_res) {
            $date_time = date('Y-m-d', strtotime($record_res['date']));
            $type      = $record_res['type'];
            $salary    = $record_res['salary'];
            $remark    = $record_res['remark'];
        }

        $data = array(
            'type_list' => RecordWork::$TYPELIST,
            'id'        => $record_id,
            'date_time' => $date_time,
            'type'      => $type,
            'salary'    => $salary,
            'remark'    => $remark,
            'inctype'   => $inctype,
            'dectype'   => $dectype,
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
        $id             = $request->input('id', '');
        $rd3_session    = $request->input('rd3_session', '');
        $uid            = $rd3_session ? $this->recordUserRepository->getUid($rd3_session) : '';
        $data['uid']    = $uid;
        $data['type']   = $request->input('typeid', '');
        $data['salary'] = (int)$request->input('salary', '') * 100;
        $data['remark'] = (string)$request->input('remark', '');
        $data['date']   = $request->input('time', '');

        if ($id) {
            //更新
            $res = $this->recordWorkRepository->update($data, $id);
        } else {
            //新增
            $res = $this->recordWorkRepository->create($data);
        }

        if ($res) {
            $result = array('e' => '9999', 'm' => '添加成功！');
        } else {
            $result = array('e' => '404', 'm' => '添加失败！');
        }

        return $this->sendResponse($result);
    }

    /**
     * 记工簿统计数据页
     * @param  Request $request
     * @return mixed
     */
    public function recordStatistics(Request $request)
    {
        $date = $request->input('date', '');

        $series_data   = array(
            array('name' => '出勤', 'data' => '23', 'color' => '#87CECB'),
            array('name' => '加班', 'data' => '3', 'color' => '#90EE90'),
            array('name' => '请假', 'data' => '1', 'color' => '#FFD700'),
            array('name' => '调休', 'data' => '2', 'color' => '#D2B48C'),
            array('name' => '旷工', 'data' => '0', 'color' => '#FA8072'),
        );
        $progress_data = array(
            array('name' => '出勤', 'day' => '23', 'percent' => '60', 'color' => '#87CECB'),
            array('name' => '加班', 'day' => '3', 'percent' => '10', 'color' => '#90EE90'),
            array('name' => '请假', 'day' => '2', 'percent' => '5', 'color' => '#FFD700'),
            array('name' => '调休', 'day' => '1', 'percent' => '2', 'color' => '#D2B48C'),
            array('name' => '旷工', 'day' => '0', 'percent' => '0', 'color' => '#FA8072'),
        );
        $date_data     = array(
            'date_time' => date('Y-m'),
            'month'     => (int)date('m'),
        );

        if ($date && Utils::checkDateIsValid($date)) {
            $date_data = array(
                'date_time' => date('Y-m', strtotime($date)),
                'month'     => (int)date('m', strtotime($date)),
            );
        }

        $data = array(
            'date'     => $date_data,
            'series'   => $series_data,
            'progress' => $progress_data,
        );

        return $this->sendResponse($data);
    }

    public function recordTest()
    {
        $record_key = 'record_books_keys';
        $res        = Redis::command('HGETALL', [$record_key]);
        //$uid = $this->recordUserRepository->getUid('4641b54deb8fda0ffc9150caee8e6950');
        $a = $this->recordUserRepository->update(['daily_salary' => '200'], '1');
        dd($a);
    }
}
