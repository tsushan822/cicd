<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Zen\User\Model\Permission;
use App\Zen\User\Model\Role;
use App\Zen\User\Model\RoleRepository as RoleRepo;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * @var RoleRepo
     */
    private $roleRepo;

    /**
     * RoleController constructor.
     * @param RoleRepo $roleRepo
     */
    public function __construct(RoleRepo $roleRepo)
    {
        $this->roleRepo = $roleRepo;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('User.roles.index');
    }

    public function getroles()
    {
        $this->checkAllowAccess('edit_role');
        $roles = Role:: where('name', '<>', 'super')->get();
        $permissions = $this->roleRepo->getPermissionOfAllRoles();
        return  compact('roles', 'permissions');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public
    function create()
    {
        $this->checkAllowAccess('create_role');
        $permissions = Permission::pluck('label', 'id');
        return view('User.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function store(Request $request)
    {
        $this->checkAllowAccess('create_role');
        $this->validate($request, [
            'role' => 'required'
        ]);
        $label = $request->role;
        $name = str_slug($label, '-');
        $result = Role::create(['name' => $name, 'label' => $label]);
        $role = Role::find($result->id);
        if ($result) {
            $role->attachPermission($request->permission);
            flash('New Role has been assigned', 'Success !!')->overlay();
            return redirect(route('roles.index'));
        } else {
            flash('New Role has been assigned', 'Error !!')->overlay()->error();
            return back();
        }
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param $roleId
     * @param $permissionId
     * @return array
     */
    public function update(Request $request, $roleId, $permissionId)
    {
        $value = $request->value;
        $role = Role::findOrFail($roleId);
        if ($value) {
            $role->permissions()->attach($permissionId);

        } else {
            $role->permissions()->detach($permissionId);

        }
        return ['value' => request()->all()];
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }
}
