<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class SomeupsCriteria
 * @package namespace App\Criteria;
 */
class SomeupsCriteria implements CriteriaInterface
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
        $file_name   = trim($this->request->get('file_name', ''));

        if ($file_name) {
            $model = $model->where('file_name', 'like', "%$file_name%");
        }

        $model = $model->orderBy('created_at', 'desc');

        return $model;
    }
}
