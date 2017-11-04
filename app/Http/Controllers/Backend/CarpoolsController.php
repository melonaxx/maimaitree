<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateCarpoolsRequest;
use App\Http\Requests\Backend\UpdateCarpoolsRequest;
use App\Repositories\Backend\CarpoolsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CarpoolsController extends AppBaseController
{
    /** @var  CarpoolsRepository */
    private $carpoolsRepository;

    public function __construct(CarpoolsRepository $carpoolsRepo)
    {
        $this->carpoolsRepository = $carpoolsRepo;
    }

    /**
     * Display a listing of the Carpools.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->carpoolsRepository->pushCriteria(new RequestCriteria($request));
        $carpools = $this->carpoolsRepository->all();

        return view('backend.carpools.index')
            ->with('carpools', $carpools);
    }

    /**
     * Show the form for creating a new Carpools.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.carpools.create');
    }

    /**
     * Store a newly created Carpools in storage.
     *
     * @param CreateCarpoolsRequest $request
     *
     * @return Response
     */
    public function store(CreateCarpoolsRequest $request)
    {
        $input = $request->all();

        $carpools = $this->carpoolsRepository->create($input);

        Flash::success('Carpools saved successfully.');

        return redirect(route('backend.carpools.index'));
    }

    /**
     * Display the specified Carpools.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $carpools = $this->carpoolsRepository->findWithoutFail($id);

        if (empty($carpools)) {
            Flash::error('Carpools not found');

            return redirect(route('backend.carpools.index'));
        }

        return view('backend.carpools.show')->with('carpools', $carpools);
    }

    /**
     * Show the form for editing the specified Carpools.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $carpools = $this->carpoolsRepository->findWithoutFail($id);

        if (empty($carpools)) {
            Flash::error('Carpools not found');

            return redirect(route('backend.carpools.index'));
        }

        return view('backend.carpools.edit')->with('carpools', $carpools);
    }

    /**
     * Update the specified Carpools in storage.
     *
     * @param  int              $id
     * @param UpdateCarpoolsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCarpoolsRequest $request)
    {
        $carpools = $this->carpoolsRepository->findWithoutFail($id);

        if (empty($carpools)) {
            Flash::error('Carpools not found');

            return redirect(route('backend.carpools.index'));
        }

        $carpools = $this->carpoolsRepository->update($request->all(), $id);

        Flash::success('Carpools updated successfully.');

        return redirect(route('backend.carpools.index'));
    }

    /**
     * Remove the specified Carpools from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $carpools = $this->carpoolsRepository->findWithoutFail($id);

        if (empty($carpools)) {
            Flash::error('Carpools not found');

            return redirect(route('backend.carpools.index'));
        }

        $this->carpoolsRepository->delete($id);

        Flash::success('Carpools deleted successfully.');

        return redirect(route('backend.carpools.index'));
    }
}
