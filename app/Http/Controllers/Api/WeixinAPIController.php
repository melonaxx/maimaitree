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

                $this->recordUserRepository->create($user_param);
            }

            $record_key = 'record_books_keys';
            $user_id    = $open_id . ';' . $session_key . ';' . $token;
            $rd3_key    = md5(md5($user_id) . $token);
            Redis::command('HSET', [$record_key, $rd3_key, $user_id]);
            $wx_data = array('rd3_session' => $rd3_key);
        } else {
            return $this->sendError([], '404', '参数不正确！');
        }

        return $this->sendMergeResponse($wx_data);

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
        $curr_salary  = $this->recordWorkRepository->getTotalSalaryByUid($uid, $date);
        $month_record = array();
        $work_day     = '0';

        if ($uid && $date) {
            $user_record = $this->recordWorkRepository->getRecordListByUidTime($uid, $date);
            $work_day    = count($user_record);

            foreach ($user_record as $u_key => $u_value) {
                $one_record = array(
                    'id'      => (string)$u_value['id'],
                    'current' => (string)date('d', strtotime($u_value['date'])),
                    'title'   => RecordWork::$TYPELIST[$u_value['type']]['title'],
                    'remark'  => $u_value['remark'] ? '-' . $u_value['remark'] : '',
                    'day'     => $u_value['type'] == RecordWork::TYPE_WORK ? '1天' : '',
                    'salary'  => $u_value['salary'] / 100 . '元',
                );
                array_push($month_record, $one_record);
            }

        }

        $data = array(
            'title'        => (int)date('m', strtotime($date)) . '月当前工资',
            'curr_salary'  => $curr_salary,
            'day_salary'   => $user['daily_salary'],
            'date'         => $date,
            'date_time'    => $date,
            'work_day'     => $work_day,
            'session'      => Redis::command('get', [$rd3_session]),
            'month_record' => $month_record,
        );

        return $this->sendMergeResponse(["record" => $data]);

    }

    /**
     * 修改单日工资
     * @param Request $request
     */
    public function setDaySalary(Request $request)
    {
        $day_salary  = $request->input('day_salary', '');
        $rd3_session = $request->input('rd3_session', '');

        $user = $this->recordUserRepository->getUserInfoByOpenId($rd3_session);
        $id   = $user ? $user['id'] : '';
        //这里修改用户单日工资操作
        if ($day_salary && $id) {
            $this->recordUserRepository->update(['daily_salary' => $day_salary], $id);
        }

        $res = array('daySalary' => $day_salary);

        return $this->sendMergeResponse($res);
    }

    /**
     * show添加记工页
     * @param  Request $request
     * @return mixed
     */
    public function recordCreate(Request $request)
    {
        $record_id   = $request->input('id', '');
        $rd3_session = $request->input('rd3_session', '');
        $user        = $this->recordUserRepository->getUserInfoByOpenId($rd3_session);
        $day_salary  = $user ? $user['daily_salary'] : '';
        $record_res  = $record_id ? ($this->recordWorkRepository->findWithoutFail($record_id)->toArray() ?: []) : [];
        $date_time   = date('Y-m-d');
        $type        = '101';
        $salary      = $day_salary;
        $remark      = '';
        $inctype     = array('101', '102');
        $dectype     = array('103', '104', '105');


        if ($record_id && $record_res) {
            $date_time = date('Y-m-d', strtotime($record_res['date']));
            $type      = $record_res['type'];
            $salary    = $record_res['salary'];
            $remark    = $record_res['remark'];
        }

        $data = array(
            'id'        => $record_id,
            'type_list' => RecordWork::$TYPELIST,
            'date_time' => $date_time,
            'type'      => $type,
            'salary'    => $salary,
            'remark'    => $remark,
            'inctype'   => $inctype,
            'dectype'   => $dectype,
        );

        return $this->sendMergeResponse($data);

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

        return $this->sendMergeResponse($result);
    }

    /**
     * 记工簿统计数据页
     * @param  Request $request
     * @return mixed
     */
    public function recordStatistics(Request $request)
    {
        $date                = $request->input('date', date('Y-m'));
        $rd3_session         = $request->input('rd3_session', '');
        $date                = Utils::checkDateIsValid($date) ? $date : date('Y-m');
        $uid                 = $this->recordUserRepository->getUid($rd3_session);
        $total               = 0;
        $work                = 0;
        $work_percent        = 0;
        $overtime            = 0;
        $overtime_percent    = 0;
        $leave               = 0;
        $leave_percent       = 0;
        $rest                = 0;
        $rest_percent        = 0;
        $absenteeism         = 0;
        $absenteeism_percent = 0;


        if ($uid && $date) {
            $user_record = $this->recordWorkRepository->getRecordListByUidTime($uid, $date);

            foreach ($user_record as $u_key => $u_value) {
                $total++;
                if ($u_value['type'] == RecordWork::TYPE_WORK) {
                    $work++;
                } elseif ($u_value['type'] == RecordWork::TYPE_OVERTIME) {
                    $overtime++;
                } elseif ($u_value['type'] == RecordWork::TYPE_LEAVE) {
                    $leave++;
                } elseif ($u_value['type'] == RecordWork::TYPE_REST) {
                    $rest++;
                } elseif ($u_value['type'] == RecordWork::TYPE_ABSENTEEISM) {
                    $absenteeism++;
                }
            }

        }

        if ($total) {
            $work_percent        = ($work / $total) * 100;
            $overtime_percent    = ($overtime / $total) * 100;
            $leave_percent       = ($leave / $total) * 100;
            $rest_percent        = ($rest / $total) * 100;
            $absenteeism_percent = ($absenteeism / $total) * 100;
        }


        $series_data   = array(
            array('name' => '出勤', 'data' => $work, 'color' => '#87CECB'),
            array('name' => '加班', 'data' => $overtime, 'color' => '#90EE90'),
            array('name' => '请假', 'data' => $leave, 'color' => '#FFD700'),
            array('name' => '调休', 'data' => $rest, 'color' => '#D2B48C'),
            array('name' => '旷工', 'data' => $absenteeism, 'color' => '#FA8072'),
        );
        $progress_data = array(
            array('name' => '出勤', 'day' => $work, 'percent' => $work_percent, 'color' => '#87CECB'),
            array('name' => '加班', 'day' => $overtime, 'percent' => $overtime_percent, 'color' => '#90EE90'),
            array('name' => '请假', 'day' => $leave, 'percent' => $leave_percent, 'color' => '#FFD700'),
            array('name' => '调休', 'day' => $rest, 'percent' => $rest_percent, 'color' => '#D2B48C'),
            array('name' => '旷工', 'day' => $absenteeism, 'percent' => $absenteeism_percent, 'color' => '#FA8072'),
        );
        $date_data     = array(
            'date_time' => date('Y-m', strtotime($date)),
            'month'     => (int)date('m', strtotime($date)),
        );

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
