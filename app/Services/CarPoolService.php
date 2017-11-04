<?php

namespace App\Services;

use App\Models\Backend\Carpools;
use App\User;
use Illuminate\Http\Request;
use App\Extend\Utils;
use App\Extend\CacheDriver;
use App\Models\Backend\Users;
use App\Criteria\CarpoolCriteria;
use App\Repositories\Backend\UsersRepository;
use App\Repositories\Backend\CarpoolsRepository;

class CarPoolService
{
    const TOKEN     = 'yLqTwVhCnZbUBchmM7dKCwzau278GWT9';
    const WX_APPID  = 'wxd16025339994a3ec';
    const WX_SECRET = 'c9fa31b245925e305a19b09d778663de';
    private $userRepository;
    private $carpoolRepository;

    public function __construct(UsersRepository $usersRepo, CarpoolsRepository $carpoolsRepo)
    {
        $this->userRepository    = $usersRepo;
        $this->carpoolRepository = $carpoolsRepo;
    }

    public function carpoolLogin(Request $request)
    {
        $code            = $request->input('code', '');
        $user_res        = $request->input('userInfo', '');
        $get_open_id_url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . self::WX_APPID . '&secret=' . self::WX_SECRET . '&js_code=' . $code . '&grant_type=authorization_code';
        $open_res        = Utils::simpleRequest($get_open_id_url);
        $wx_data         = array();

        $data = json_decode($open_res, true);

        if (is_array($data) && !isset($data['errcode'])) {
            $open_id     = $data['openid'];
            $session_key = $data['session_key'];
            $token       = self::TOKEN;
            $user_param  = array();
            $u_res       = array();
            $wx_data     = array();

            $users = $this->userRepository->findByField('openid', $open_id)->toArray();

            //添加用户信息
            if ($user_res && !$users) {
                $userInfo               = json_decode($user_res, true);
                $user_param['openid']   = $open_id;
                $user_param['name']     = '';
                $user_param['nickname'] = $userInfo['nickName'];
                $user_param['sex']      = $userInfo['gender'];
                $user_param['age']      = 0;
                $user_param['phone']    = '';
                $user_param['country']  = $userInfo['country'];
                $user_param['province'] = $userInfo['province'];
                $user_param['city']     = $userInfo['city'];
                $user_param['avatar']   = $userInfo['avatarUrl'];
                $user_param['source']   = Users::SOURCE_CARPOOL;
                $user_param['status']   = Users::STATUS_NORMAL;

                $u_res = $this->userRepository->create($user_param);
            }
            if ($u_res) {
                $map     = Users::REDIS_KEY;
                $user_id = $open_id . ';' . $u_res['id'];
                $rd3_key = md5(md5($user_id) . $session_key . $token);
                CacheDriver::HSET($map, $rd3_key, $user_id);
                $wx_data = array('rd3_token' => $rd3_key);
            }

        }

        return $wx_data;
    }

    public function getCarpoolAdd(Request $request)
    {
        $c_data = $this->carpoolRepository->filterCarpool($request);
        $c_res = $this->carpoolRepository->create($c_data);

        return $c_res;
    }

    public function getCarpoolList($request)
    {
        $this->carpoolRepository->pushCriteria(new CarpoolCriteria($request));
        $carpools = $this->carpoolRepository->all();
        //$c_data = $this->carpoolRepository->getCarpoolList();
        $c_data = $carpools ? $carpools->toArray() : [];
        $c_list = array();

        if (count($c_data) > 0) {
            foreach ($c_data as $c_key=>$c_value) {
                if ($c_value['status'] != Carpools::STATUS_NORMAL) {
                    continue;
                }
                $uid = $c_value['uid'];
                $u_res = $this->userRepository->getInfoByUid($uid);
                $c_count = $this->carpoolRepository->getCarpoolCountByUid($uid);
                $u_info = $u_res ? $u_res->toArray() : [];
                $status_text = $c_value['status'] == Carpools::STATUS_CANCEL ? '已取消' : ($c_value['time'] < time() ? '已过期' : '进行中');
                $tmp_data = array();
                $tmp_data['id'] = $c_value['id'];
                $tmp_data['user']['avatar'] = $u_info['avatar'];
                $tmp_data['user']['name'] = $c_value['name'] ? $c_value['name'] : Users::getNameByUid($u_info['id']);
                $tmp_data['user']['sex'] = $c_value['sex'];
                $tmp_data['user']['phone'] = $c_value['phone'];
                $tmp_data['user']['type'] = $c_value['type'];
                $tmp_data['user']['count'] = $c_count;
                $tmp_data['carpool']['origin'] = $c_value['origin'];
                $tmp_data['carpool']['by_way'] = $c_value['by_way'];
                $tmp_data['carpool']['terminal'] = $c_value['terminal'];
                $tmp_data['carpool']['time'] = date('Y-m-d H:i',$c_value['time']);
                $tmp_data['carpool']['publish_time'] = Utils::formatTime($c_value['created_at']);
                $tmp_data['carpool']['remark'] = $c_value['remark'];
                $tmp_data['carpool']['number'] = $c_value['number'];
                $tmp_data['carpool']['price'] = $c_value['price'];
                $tmp_data['carpool']['status'] = $c_value['status'];
                $tmp_data['carpool']['status_text'] = $status_text;

                array_push($c_list, $tmp_data);
            }
        }

        return $c_list;
    }

    public function getCarPoolDetailById(Request $request)
    {
        $id = $request->input('id','');
        $token = $request->input('token','');
        //$token = "31adb99d98561553a8984304cb93f119";
        $u_info = Users::getInfoByToken($token);
        $c_detail = $id ? $this->carpoolRepository->getCarPoolDetailById($id) : array();
        $data = array();
        if ($u_info && $c_detail) {
            $origin_cross = explode('&',$c_detail['origin_cross']);
            $terminal_cross = explode('&',$c_detail['terminal_cross']);
            $origin_longitude = ($origin_cross) > 1 ? $origin_cross[0] : '';
            $origin_latitude = ($origin_cross) > 1 ? $origin_cross[1] : '';
            $terminal_longitude = ($terminal_cross) > 1 ? $terminal_cross[0] : '';
            $terminal_latitude = ($terminal_cross) > 1 ? $terminal_cross[1] : '';

            $data['user']['avatar'] = $u_info['avatar'];
            $data['user']['name'] = $c_detail['name'];
            $data['user']['sex'] = $c_detail['sex'];
            $data['user']['phone'] = $c_detail['phone'];
            $data['carpool']['type'] = $c_detail['type'];
            $data['carpool']['origin'] = $c_detail['origin'];
            $data['carpool']['origin_longitude'] = $origin_longitude;
            $data['carpool']['origin_latitude'] = $origin_latitude;
            $data['carpool']['by_way'] = $c_detail['by_way'];
            $data['carpool']['terminal'] = $c_detail['terminal'];
            $data['carpool']['terminal_longitude'] = $terminal_longitude;
            $data['carpool']['$terminal_latitude'] = $terminal_latitude;
            $data['carpool']['time'] = date('Y-m-d H:i',$c_detail['time']);
            $data['carpool']['number'] = $c_detail['number'];
            $data['carpool']['price'] = $c_detail['price'];
            $data['carpool']['license'] = $c_detail['license'];
            $data['carpool']['car_type'] = $c_detail['car_type'];
            $data['carpool']['volume'] = $c_detail['volume'];
            $data['carpool']['weight'] = $c_detail['weight'];
            $data['carpool']['frequency'] = $c_detail['frequency'];
            $data['carpool']['remark'] = $c_detail['remark'];
            $data['carpool']['publish_time'] = Utils::formatTime($c_detail['created_at']);
        }

        return $data;
    }

    public function myPublishList(Request $request)
    {
        $token = $request->input('token','');
        //$token = "31adb99d98561553a8984304cb93f119";
        $uid = Users::getUidByToken($token);
        $m_data = array();

        if ($token && $uid) {
            $my_publish = $this->carpoolRepository->myPublishList($uid);
            if ($my_publish) {
                foreach ($my_publish->toArray() as $m_key=>$m_value) {
                    $tmp_data = array();
                    $tmp_data['avatar'] = $m_value['avatar'];
                    $tmp_data['origin'] = $m_value['origin'];
                    $tmp_data['terminal'] = $m_value['terminal'];
                    $tmp_data['time'] = date('Y-m-d H:i',$m_value['time']);
                    $tmp_data['publish_time'] = Utils::formatTime($m_value['created_at']);
                    $tmp_data['publish_time'] = Utils::formatTime($m_value['created_at']);
                    $tmp_data['status'] = $m_value['status'] == Carpools::STATUS_CANCEL ? '已取消' : ($m_value['time'] < time() ? '已过期' : '进行中');

                    array_push($m_data,$tmp_data);
                }
            }

        }
        return $m_data;
    }

    public function carpoolCenter(Request $request)
    {
        $token = $request->input('token','');
        //$token = "31adb99d98561553a8984304cb93f119";
        $u_info = $token ? Users::getInfoByToken($token) : [];
        $c_data = array();

        $user = array('avatar'=>$u_info['avatar'],'name'=>Users::getNameByUid($u_info['id']));
        $publish = array('image'=>'','title'=>'我的发布','info'=>'','url'=>'');
        $message = array('image'=>'','title'=>'消息中心','info'=>'','url'=>'');
        $about = array('image'=>'','title'=>'关于我们','info'=>'','url'=>'');
        $c_data['user'] = $user;
        $c_data['menu'][] = $publish;
        $c_data['menu'][] = $message;
        $c_data['menu'][] = $about;

        return $c_data;
    }
}