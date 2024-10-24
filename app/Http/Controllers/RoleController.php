<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:delete role', ['only' => ['destroy']]);
    // }
     public function index()
    {
        $data = Role::all();
        return view('backend.role-permission.role.index', compact('data'));
    }
    public function create()
    {
        return view('backend.role-permission.role.create');
    }
    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required|unique:roles,name',
        ]);
        Role::create([
            'name' => $req->name,
        ]);
        return redirect()->back()->with('success', 'Role Create Success');
    }
    public function edit($id)
    {
        $data = Role::findOrFail($id);
        return view('backend.role-permission.role.edit', compact('data'));
    }
    public function update(Request $req, Role $role)
    {
        $req->validate([
            'name' => 'required|unique:roles,name',
        ]);
        $role->update([
            'name' => $req->name,
        ]);
        return redirect(route('role.index'))->with('success', 'Role Update Success');;
    }
    public function destroy($id)
    {
        $data = Role::findOrfail($id);
        $data->delete();
        return redirect()->back();
    }

    // ----- give permission ---
    public function AddPermission($id){
        $role = Role::findOrFail($id);
        $permission = Permission::get();
        $rolePermission = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id',$role->id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return view('backend.role-permission.role.give-permission', compact('role', 'permission','rolePermission'));
    }
    public function GivePermission(Request $req , $id){
        $req->validate([
            'permission' => 'required'
        ]);
        $role = Role::findOrFail($id);
        $role->syncPermissions($req->permission);
        return redirect()->back()->with('success', 'Permission Assign Success')  ;
    }
}
