<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateUsersRequest;
use App\Http\Requests\Backend\UpdateUsersRequest;
use App\Repositories\Backend\UsersRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class UsersController extends AppBaseController
{
    /** @var  UsersRepository */
    private $usersRepository;

    public function __construct(UsersRepository $usersRepo)
    {
        $this->usersRepository = $usersRepo;
    }

    /**
     * Display a listing of the Users.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->usersRepository->pushCriteria(new RequestCriteria($request));
        $users = $this->usersRepository->all();

        return view('backend.users.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new Users.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created Users in storage.
     *
     * @param CreateUsersRequest $request
     *
     * @return Response
     */
    public function store(CreateUsersRequest $request)
    {
        $input = $request->all();

        $users = $this->usersRepository->create($input);

        Flash::success('Users saved successfully.');

        return redirect(route('backend.users.index'));
    }

    /**
     * Display the specified Users.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $users = $this->usersRepository->findWithoutFail($id);

        if (empty($users)) {
            Flash::error('Users not found');

            return redirect(route('backend.users.index'));
        }

        return view('backend.users.show')->with('users', $users);
    }

    /**
     * Show the form for editing the specified Users.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $users = $this->usersRepository->findWithoutFail($id);

        if (empty($users)) {
            Flash::error('Users not found');

            return redirect(route('backend.users.index'));
        }

        return view('backend.users.edit')->with('users', $users);
    }

    /**
     * Update the specified Users in storage.
     *
     * @param  int              $id
     * @param UpdateUsersRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUsersRequest $request)
    {
        $users = $this->usersRepository->findWithoutFail($id);

        if (empty($users)) {
            Flash::error('Users not found');

            return redirect(route('backend.users.index'));
        }

        $users = $this->usersRepository->update($request->all(), $id);

        Flash::success('Users updated successfully.');

        return redirect(route('backend.users.index'));
    }

    /**
     * Remove the specified Users from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $users = $this->usersRepository->findWithoutFail($id);

        if (empty($users)) {
            Flash::error('Users not found');

            return redirect(route('backend.users.index'));
        }

        $this->usersRepository->delete($id);

        Flash::success('Users deleted successfully.');

        return redirect(route('backend.users.index'));
    }
}
