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
        $admins = User::where('role', '!=', 1)->get();
        $roles  = DB::table('idp_user_role')->whereNotIn('id', [1, 2])->get();

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
        User::where('id', $id)->update([
            'name'      => $request->name,
            'username'  => $request->username,
            'role'      => $request->role,
            'password'  => Hash::make($request->password)
        ]);

        return back()->with('success', 'Berhasil update admin');
    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();

        return back()->with('warning', 'Admin berhasil dihapus');
    }
}
