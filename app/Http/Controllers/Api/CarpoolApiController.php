<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Backend\CarpoolsRepository;
use App\Services\CarPoolService;
use App\Services\UploadService;

/**
 * Class WeixinController
 * @package App\Http\Controllers\API
 */
class CarpoolApiController extends AppBaseController
{
    private $carpoolsService;
    private $uploadService;

    public function __construct(CarpoolsRepository $carpoolRepo, CarPoolService $carpoolSer, UploadService $uploadSer)
    {
        $this->carpoolRepository = $carpoolRepo;
        $this->carpoolsService = $carpoolSer;
        $this->uploadService = $uploadSer;
    }

    public function carPoolLogin(Request $request)
    {
        $data = $this->carpoolsService->carpoolLogin($request);

        if ($data) {
            return $this->sendMergeResponse($data);
        } else {
            return $this->sendError([], '404', '参数不正确！');
        }

    }

    public function carPoolAdd(Request $request)
    {
        $data = $this->carpoolsService->getCarpoolAdd($request);

        if (!$data) {
            return $this->sendError([], '404', '添加失败');
        } else {
            return $this->sendMergeResponse(['action'=>$data]);
        }

    }

    public function carPoolList(Request $request)
    {
        $c_data = $this->carpoolsService->getCarpoolList($request);

        if (!$c_data) {
            return $this->sendError([], '404', '没有数据哦');
        } else {
            return $this->sendResponse($c_data);
        }

    }

    public function getCarPoolDetailById(Request $request)
    {
        $c_data = $this->carpoolsService->getCarPoolDetailById($request);

        if (!$c_data) {
            return $this->sendError([], '404', '没有数据哦');
        } else {
            return $this->sendResponse($c_data);
        }

    }

    public function myPublishList(Request $request)
    {
        $m_data = $this->carpoolsService->myPublishList($request);

        if (!$m_data) {
            return $this->sendError([], '404', '没有数据哦');
        } else {
            return $this->sendResponse($m_data);
        }

    }

    public function carpoolCenter(Request $request)
    {
        $m_data = $this->carpoolsService->carpoolCenter($request);

        if (!$m_data) {
            return $this->sendError([], '404', '没有数据哦');
        } else {
            return $this->sendMergeResponse($m_data);
        }

    }

    public function test()
    {
        echo 'this is text!';
    }
}
