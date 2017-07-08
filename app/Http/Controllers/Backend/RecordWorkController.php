<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateRecordWorkRequest;
use App\Http\Requests\Backend\UpdateRecordWorkRequest;
use App\Repositories\Backend\RecordWorkRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class RecordWorkController extends AppBaseController
{
    /** @var  RecordWorkRepository */
    private $recordWorkRepository;

    public function __construct(RecordWorkRepository $recordWorkRepo)
    {
        $this->recordWorkRepository = $recordWorkRepo;
    }

    /**
     * Display a listing of the RecordWork.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->recordWorkRepository->pushCriteria(new RequestCriteria($request));
        $recordWorks = $this->recordWorkRepository->all();

        return view('backend.record_works.index')
            ->with('recordWorks', $recordWorks);
    }

    /**
     * Show the form for creating a new RecordWork.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.record_works.create');
    }

    /**
     * Store a newly created RecordWork in storage.
     *
     * @param CreateRecordWorkRequest $request
     *
     * @return Response
     */
    public function store(CreateRecordWorkRequest $request)
    {
        $input = $request->all();

        $recordWork = $this->recordWorkRepository->create($input);

        Flash::success('Record Work saved successfully.');

        return redirect(route('recordWorks.index'));
    }

    /**
     * Display the specified RecordWork.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $recordWork = $this->recordWorkRepository->findWithoutFail($id);

        if (empty($recordWork)) {
            Flash::error('Record Work not found');

            return redirect(route('recordWorks.index'));
        }

        return view('backend.record_works.show')->with('recordWork', $recordWork);
    }

    /**
     * Show the form for editing the specified RecordWork.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $recordWork = $this->recordWorkRepository->findWithoutFail($id);

        if (empty($recordWork)) {
            Flash::error('Record Work not found');

            return redirect(route('recordWorks.index'));
        }

        return view('backend.record_works.edit')->with('recordWork', $recordWork);
    }

    /**
     * Update the specified RecordWork in storage.
     *
     * @param  int              $id
     * @param UpdateRecordWorkRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRecordWorkRequest $request)
    {
        $recordWork = $this->recordWorkRepository->findWithoutFail($id);

        if (empty($recordWork)) {
            Flash::error('Record Work not found');

            return redirect(route('recordWorks.index'));
        }

        $recordWork = $this->recordWorkRepository->update($request->all(), $id);

        Flash::success('Record Work updated successfully.');

        return redirect(route('recordWorks.index'));
    }

    /**
     * Remove the specified RecordWork from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $recordWork = $this->recordWorkRepository->findWithoutFail($id);

        if (empty($recordWork)) {
            Flash::error('Record Work not found');

            return redirect(route('recordWorks.index'));
        }

        $this->recordWorkRepository->delete($id);

        Flash::success('Record Work deleted successfully.');

        return redirect(route('recordWorks.index'));
    }
}
