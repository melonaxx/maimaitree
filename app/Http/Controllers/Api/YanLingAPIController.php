<?php

namespace App\Http\Controllers\API;
session_start();

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Extend\Utils;
use Illuminate\Support\Facades\Redis;

/**
 * Class YanLingController
 * @package App\Http\Controllers\API
 */
class YanLingAPIController extends AppBaseController
{
    public $trafficViolationUrl = 'http://fanren.com/script/jq_illegal_post.asp';//违章查询
    public function __construct() {}

    public function trafficViolation(Request $request)
    {
        $types = $request->input('types','');
        $license = $request->input('license','');
        $search_data = array('types'=>$types,'license'=>$license);
        $v_data = Utils::simpleRequest($this->trafficViolationUrl, $search_data);
        return substr($v_data,0,strrpos($v_data,'<div class="well">'));
    }

}