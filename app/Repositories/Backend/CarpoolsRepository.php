<?php

namespace App\Repositories\Backend;

use App\Models\Backend\Users;
use Illuminate\Http\Request;
use App\Models\Backend\Carpools;
use InfyOm\Generator\Common\BaseRepository;

class CarpoolsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'uid',
        'name',
        'sex',
        'phone',
        'type',
        'origin',
        'by_way',
        'terminal',
        'time',
        'number',
        'price',
        'frequency',
        'relief',
        'watch',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Carpools::class;
    }

    //过滤carpool数据
    public function filterCarpool(Request $request)
    {
        $token  = $request->input('token', '');
        $o_date = $request->input('origin_date', '');
        $o_time = $request->input('origin_time', '');
        $time   = strtotime(($o_date && $o_time) ? $o_date . ' ' . $o_time : date('Y-m-d H:i:s'));
        $uid    = Users::getUidByToken($token);
        $c_data = array();

        if ($uid) {
            $c_data['uid']            = $uid;
            $c_data['name']           = (string)$request->input('name', '');
            $c_data['sex']            = (int)$request->input('sex_index', 0);
            $c_data['phone']          = (string)$request->input('phone', '');
            $c_data['type']           = (int)$request->input('type', 0);
            $c_data['origin']         = (string)$request->input('origin_address', '');
            $c_data['origin_cross']   = (string)$request->input('origin_cross', '');
            $c_data['by_way']         = (string)$request->input('by_way', '');
            $c_data['terminal']       = (string)$request->input('terminal_address', '');
            $c_data['terminal_cross'] = (string)$request->input('terminal_cross', '');
            $c_data['time']           = $time;
            $c_data['number']         = (int)$request->input('number', 0);
            $c_data['price']          = (int)$request->input('price', 0);
            $c_data['license']        = (string)$request->input('license', '');
            $c_data['car_type']       = (string)$request->input('car_type', '');
            $c_data['volume']         = (string)$request->input('volume', '');
            $c_data['weight']         = (int)$request->input('weight', 0);
            $c_data['frequency']      = (int)$request->input('share_type_index', 0);
            $c_data['remark']         = (string)$request->input('remark', '');
            $c_data['relief']         = (int)$request->input('protocol', 0);
            $c_data['watch']          = (int)0;
            $c_data['status']         = (int)Users::STATUS_NORMAL;
        }

        return $c_data;
    }

    //获取carpool列表
    public function getCarpoolList()
    {
        $c_data = Carpools::where('status',Carpools::STATUS_NORMAL)->orderBy('time','desc')->get()->toArray();

        if ($c_data) {
            foreach ($c_data as $c_key=>$c_value) {

                $tmp_data = array();
                $tmp_data['user']['avatar'] = '';
            }
        }

        return $c_data;
    }

    //通过id获取carpool详情
    public function getCarPoolDetailById($id)
    {
        $c_res = Carpools::find($id);
        $detail_arr = $c_res ? $c_res->toArray() : [];

        return $detail_arr;
    }

    //通过uid获取用户发布信息条数
    public function getCarpoolCountByUid($uid)
    {
        $count = Carpools::where('uid',$uid)->count();

        return $count;
    }

    //通过uid获取用户发布信息列表
    public function myPublishList($uid)
    {
        $p_list = Carpools::leftJoin('users','users.id','=','carpools.uid')->where('carpools.uid',$uid)->select('carpools.*','users.avatar','users.name')->orderBy('carpools.created_at','desc')->get();

        return $p_list;
    }
}
