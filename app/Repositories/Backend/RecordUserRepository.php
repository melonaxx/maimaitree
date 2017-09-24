<?php

namespace App\Repositories\Backend;

use App\Models\Backend\RecordUser;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Support\Facades\Redis;

class RecordUserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'openid',
        'uname',
        'nick_name',
        'gender',
        'daily_salary'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RecordUser::class;
    }

    /**
     * 通过session获取用户ID
     * @param $rd3_session
     * @return string
     */
    public function getUid($rd3_session)
    {
        $record_key = 'record_books_keys';
        $user_id = Redis::command('HGET', [$record_key, $rd3_session]);
        $user_arr = explode(';', $user_id);
        $open_id = '';
        $user_info = '';
        $uid = '';

        if (count($user_arr) > 0) {
            $open_id = $user_arr[0];
        }

        if ($open_id) {
            $user_info = RecordUser::where('openid', $open_id)->first()->toArray();
        }

        if ($user_info) {
            $uid = $user_info['id'];
        }

        return $uid;

    }

    /**
     * 通过session获取用户信息
     * @param $rd3_session
     * @return string
     */
    public function getUserInfoByOpenId($rd3_session)
    {
        $record_key = 'record_books_keys';
        $user_id = Redis::command('HGET', [$record_key, $rd3_session]);
        $user_arr = explode(';', $user_id);
        $open_id = '';
        $user_info = '';
        $uid = '';

        if (count($user_arr) > 0) {
            $open_id = $user_arr[0];
        }

        if ($open_id) {
            $user_info = RecordUser::where('openid', $open_id)->first()->toArray();
        }

        return $user_info;
    }

}
