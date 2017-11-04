<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CarpoolCriteria
 * @package namespace App\Criteria;
 */
class CarpoolCriteria implements CriteriaInterface
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $origin   = trim($this->request->get('origin', ''));
        $terminal = trim($this->request->get('terminal', ''));
        $type = trim($this->request->get('type_id', ''));
        $time = $this->request->get('origin_date', '');
        $b_time = '';
        $e_time = '';
        if ($time) {
            $b_time   = strtotime($this->request->get('origin_date', '') . ' 00:00:00');
            $e_time   = strtotime($this->request->get('origin_date', '') . ' 23:59:59');

        }
        if ($origin) {
            $model = $model->where('origin', 'like', "%$origin%");
        }
        if ($terminal) {
            $model = $model->where('terminal', 'like', "%$terminal%");
        }
        if ($type) {
            $model = $model->where('type', '=', $type);
        }
        if ($b_time && $e_time) {
            $model = $model->where('time', '>=', $b_time)->where('time', '<=', $e_time);
        }

        $model = $model->orderBy('time', 'desc');

        return $model;
    }
}
