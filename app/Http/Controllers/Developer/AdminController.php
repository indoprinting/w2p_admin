<?php

namespace App\Http\Controllers\Developer;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Developer\AdminRequest;

class AdminController extends Controller
{
    public function index()
    {
        $title  = "List Admin";

        if (Auth()->user()->role == 1) {
            $admins = User::get();
            $roles  = DB::table('idp_user_role')->get();
        } else {
            $admins = User::where('role', '!=', 1)->get();
            $roles  = DB::table('idp_user_role')->whereNotIn('id', [1, 2])->get();
        }

        return view('developer.admin.index_admin', compact('title', 'admins', 'roles'));
    }

    public function store(AdminRequest $request)
    {
        User::create([
            'name'      => $request->name,
            'username'  => $request->username,
            'role'      => $request->role,
            'password'  => Hash::make($request->password)
        ]);

        return back()->with('success', 'Berhasil menambah admin');
    }

    public function update($id, AdminRequest $request)
    {
        $data = [
            'name'      => $request->name,
            'username'  => $request->username,
            'role'      => $request->role
        ];

        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        User::where('id', $id)->update($data);

        return back()->with('success', 'Berhasil update admin');
    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();

        return back()->with('warning', 'Admin berhasil dihapus');
    }
}
