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
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = self::TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }

    }

}
