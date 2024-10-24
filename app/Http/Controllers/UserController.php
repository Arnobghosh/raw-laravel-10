<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $data = User::get();
        return view('backend.role-permission.user.index', compact('data'));
    }
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('backend.role-permission.user.create', compact('roles'));
    }
    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
        ]);
        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password)
        ]);
        $user->syncRoles($req->roles);
        return redirect(route('user.index'))->with('success', 'User Created Successfully');
    }
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('backend.role-permission.user.edit', compact('user', 'roles', 'userRole'));
    }
    public function update(Request $req, User $user)
    {
        $req->validate([
            'name' => 'required|string',
            'password' => 'nullable',
            'roles' => 'required'
        ]);
        $data = [
            'name' => $req->name,
            'email' => $req->email,
        ];
        if (!empty($req->password)) {
            $data += [
                'password' => Hash::make($req->password),
            ];
        }
        $user->update($data);
        $user->syncRoles($req->roles);
        return redirect(route('user.index'))->with('success', 'User Updated Successfully');
    }
    public function destroy($id)
    {
        $data = User::findOrfail($id);
        $data->delete();
        return redirect()->back()->with('success', 'User Deleted Successfully');
    }
}
