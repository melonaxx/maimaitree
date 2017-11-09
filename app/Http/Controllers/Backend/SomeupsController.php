<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateSomeupsRequest;
use App\Http\Requests\Backend\UpdateSomeupsRequest;
use App\Repositories\Backend\SomeupsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Services\UploadService;
use App\Criteria\SomeupsCriteria;

class SomeupsController extends AppBaseController
{
    /** @var  SomeupsRepository */
    private $someupsRepository;
    private $uploadService;

    public function __construct(SomeupsRepository $someupsRepo, UploadService $uploadSer)
    {
        $this->someupsRepository = $someupsRepo;
        $this->uploadService = $uploadSer;
    }

    /**
     * Display a listing of the Someups.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->someupsRepository->pushCriteria(new SomeupsCriteria($request));
        $someups = $this->someupsRepository->all();
        $file_name = $request->input('file_name');
        return view('backend.someups.index')
            ->with('someups', $someups)
            ->with('file_name', $file_name);
    }

    /**
     * Show the form for creating a new Someups.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.someups.create');
    }

    /**
     * Store a newly created Someups in storage.
     *
     * @param CreateSomeupsRequest $request
     *
     * @return Response
     */
    public function store(CreateSomeupsRequest $request)
    {
        $source_arr = $request->file('source','');
        $someups = false;
        if ($source_arr) {
            $someups = $this->uploadService->putMultipleFile($source_arr);
        }

        if (!$someups) {
            Flash::error('上传失败');
        } else {
            Flash::success('上传成功');
        }
        return redirect(url('/backend/someups'));
    }

    /**
     * Display the specified Someups.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $someups = $this->someupsRepository->findWithoutFail($id);

        if (empty($someups)) {
            Flash::error('Someups not found');

            return redirect(route('backend.someups.index'));
        }

        return view('backend.someups.show')->with('someups', $someups);
    }

    /**
     * Show the form for editing the specified Someups.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $someups = $this->someupsRepository->findWithoutFail($id);

        if (empty($someups)) {
            Flash::error('Someups not found');

            return redirect(route('backend.someups.index'));
        }

        return view('backend.someups.edit')->with('someups', $someups);
    }

    /**
     * Update the specified Someups in storage.
     *
     * @param  int              $id
     * @param UpdateSomeupsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSomeupsRequest $request)
    {
        $someups = $this->someupsRepository->findWithoutFail($id);

        if (empty($someups)) {
            Flash::error('Someups not found');

            return redirect(route('backend.someups.index'));
        }

        $someups = $this->someupsRepository->update($request->all(), $id);

        Flash::success('Someups updated successfully.');

        return redirect(route('backend.someups.index'));
    }

    /**
     * Remove the specified Someups from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $someups = $this->someupsRepository->findWithoutFail($id);

        if (empty($someups)) {
            Flash::error('Someups not found');

            return redirect(route('backend.someups.index'));
        }

        $this->someupsRepository->delete($id);

        Flash::success('Someups deleted successfully.');

        return redirect(route('backend.someups.index'));
    }
}
