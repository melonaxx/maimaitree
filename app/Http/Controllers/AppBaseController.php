<?php

namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;
use Response;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $code = '9999', $message = '操作成功！')
    {
        return Response::json(ResponseUtil::makeResponse($message, $result, $code));
    }
    public function sendMergeResponse($result, $code = '9999', $message = '操作成功！')
    {
        return json_encode(array_merge($result,['e'=>$code,'m'=>$message]));
    }

    public function sendError(array $data = [], $code = '404', $error = '操作失败！')
    {
        return Response::json(ResponseUtil::makeError($error, $data, $code));
    }
}
