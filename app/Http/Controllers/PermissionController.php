<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    // public function __construct(){
    //     $this->middleware('permission:delete permission',['only' => ['destroy']]);
    //     $this->middleware('permission:edit permission',['only' => ['edit','update']]);
    // }
    public function index()
    {
        $data = Permission::all();
        return view('backend.role-permission.permission.index', compact('data'));
    }
    public function create()
    {
        return view('backend.role-permission.permission.create');
    }
    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required|unique:permissions,name',
        ]);
        Permission::create([
            'name' => $req->name,
        ]);
        return redirect()->back()->with('success', 'Permission Create Success');
    }
    public function edit($id)
    {
        $data = Permission::findOrFail($id);
        return view('backend.role-permission.permission.edit', compact('data'));
    }
    public function update(Request $req, Permission $permission)
    {
        $req->validate([
            'name' => 'required|unique:permissions,name',
        ]);
        $permission->update([
            'name' => $req->name,
        ]);
        return redirect(route('permission.index'))->with('success', 'Permission Update Success');
    }
    public function destroy($id)
    {
        $data = Permission::findOrfail($id);
        $data->delete();
        return redirect()->back()->with('error', 'Permission Delete Success');
    }
    public function show($id){
        
    }
}
