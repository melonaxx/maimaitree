<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateAdminUsersRequest;
use App\Http\Requests\Backend\UpdateAdminUsersRequest;
use App\Repositories\Backend\AdminUsersRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AdminUsersController extends AppBaseController
{
    /** @var  AdminUsersRepository */
    private $adminUsersRepository;

    public function __construct(AdminUsersRepository $adminUsersRepo)
    {
        $this->adminUsersRepository = $adminUsersRepo;
    }

    /**
     * Display a listing of the AdminUsers.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->adminUsersRepository->pushCriteria(new RequestCriteria($request));
        $adminUsers = $this->adminUsersRepository->all();

        return view('backend.admin_users.index')
            ->with('adminUsers', $adminUsers);
    }

    /**
     * Show the form for creating a new AdminUsers.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.admin_users.create');
    }

    /**
     * Store a newly created AdminUsers in storage.
     *
     * @param CreateAdminUsersRequest $request
     *
     * @return Response
     */
    public function store(CreateAdminUsersRequest $request)
    {
        $input = $request->all();

        $adminUsers = $this->adminUsersRepository->create($input);

        Flash::success('Admin Users saved successfully.');

        return redirect(route('backend.adminUsers.index'));
    }

    /**
     * Display the specified AdminUsers.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $adminUsers = $this->adminUsersRepository->findWithoutFail($id);

        if (empty($adminUsers)) {
            Flash::error('Admin Users not found');

            return redirect(route('backend.adminUsers.index'));
        }

        return view('backend.admin_users.show')->with('adminUsers', $adminUsers);
    }

    /**
     * Show the form for editing the specified AdminUsers.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $adminUsers = $this->adminUsersRepository->findWithoutFail($id);

        if (empty($adminUsers)) {
            Flash::error('Admin Users not found');

            return redirect(route('backend.adminUsers.index'));
        }

        return view('backend.admin_users.edit')->with('adminUsers', $adminUsers);
    }

    /**
     * Update the specified AdminUsers in storage.
     *
     * @param  int              $id
     * @param UpdateAdminUsersRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAdminUsersRequest $request)
    {
        $adminUsers = $this->adminUsersRepository->findWithoutFail($id);

        if (empty($adminUsers)) {
            Flash::error('Admin Users not found');

            return redirect(route('backend.adminUsers.index'));
        }

        $adminUsers = $this->adminUsersRepository->update($request->all(), $id);

        Flash::success('Admin Users updated successfully.');

        return redirect(route('backend.adminUsers.index'));
    }

    /**
     * Remove the specified AdminUsers from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $adminUsers = $this->adminUsersRepository->findWithoutFail($id);

        if (empty($adminUsers)) {
            Flash::error('Admin Users not found');

            return redirect(route('backend.adminUsers.index'));
        }

        $this->adminUsersRepository->delete($id);

        Flash::success('Admin Users deleted successfully.');

        return redirect(route('backend.adminUsers.index'));
    }
}
