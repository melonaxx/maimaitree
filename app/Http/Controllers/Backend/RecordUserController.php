<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateRecordUserRequest;
use App\Http\Requests\Backend\UpdateRecordUserRequest;
use App\Repositories\Backend\RecordUserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class RecordUserController extends AppBaseController
{
    /** @var  RecordUserRepository */
    private $recordUserRepository;

    public function __construct(RecordUserRepository $recordUserRepo)
    {
        $this->recordUserRepository = $recordUserRepo;
    }

    /**
     * Display a listing of the RecordUser.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->recordUserRepository->pushCriteria(new RequestCriteria($request));
        $recordUsers = $this->recordUserRepository->all();

        return view('backend.record_users.index')
            ->with('recordUsers', $recordUsers);
    }

    /**
     * Show the form for creating a new RecordUser.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.record_users.create');
    }

    /**
     * Store a newly created RecordUser in storage.
     *
     * @param CreateRecordUserRequest $request
     *
     * @return Response
     */
    public function store(CreateRecordUserRequest $request)
    {
        $input = $request->all();

        $recordUser = $this->recordUserRepository->create($input);

        Flash::success('Record User saved successfully.');

        return redirect(route('backend.recordUsers.index'));
    }

    /**
     * Display the specified RecordUser.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $recordUser = $this->recordUserRepository->findWithoutFail($id);

        if (empty($recordUser)) {
            Flash::error('Record User not found');

            return redirect(route('backend.recordUsers.index'));
        }

        return view('backend.record_users.show')->with('recordUser', $recordUser);
    }

    /**
     * Show the form for editing the specified RecordUser.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $recordUser = $this->recordUserRepository->findWithoutFail($id);

        if (empty($recordUser)) {
            Flash::error('Record User not found');

            return redirect(route('backend.recordUsers.index'));
        }

        return view('backend.record_users.edit')->with('recordUser', $recordUser);
    }

    /**
     * Update the specified RecordUser in storage.
     *
     * @param  int              $id
     * @param UpdateRecordUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRecordUserRequest $request)
    {
        $recordUser = $this->recordUserRepository->findWithoutFail($id);

        if (empty($recordUser)) {
            Flash::error('Record User not found');

            return redirect(route('backend.recordUsers.index'));
        }

        $recordUser = $this->recordUserRepository->update($request->all(), $id);

        Flash::success('Record User updated successfully.');

        return redirect(route('backend.recordUsers.index'));
    }

    /**
     * Remove the specified RecordUser from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $recordUser = $this->recordUserRepository->findWithoutFail($id);

        if (empty($recordUser)) {
            Flash::error('Record User not found');

            return redirect(route('backend.recordUsers.index'));
        }

        $this->recordUserRepository->delete($id);

        Flash::success('Record User deleted successfully.');

        return redirect(route('backend.recordUsers.index'));
    }
}
