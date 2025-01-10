<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        $data = User::paginate(10);
        return view('superadmin.user.index', compact('data'));
    }
    public function create()
    {

        return view('superadmin.user.create');
    }
    public function store(Request $req)
    {
        $check = User::where('username', $req->username)->first();
        if ($check == null) {
            if ($req->password1 != $req->password2) {
                $req->flash();
                Session::flash('warning', 'password tidak sama');
                return back();
            } else {
                $new = new User();
                $new->name = $req->name;
                $new->username = $req->username;
                $new->password = Hash::make($req->password1);
                $new->roles = $req->roles;
                $new->save();
                Session::flash('success', 'Berhasil');
                return redirect('/superadmin/user');
            }
        } else {
            $req->flash();
            Session::flash('warning', 'username sudah ad');
            return back();
        }
    }
    public function edit($id)
    {
        $data = User::find($id);
        return view('superadmin.user.edit', compact('data'));
    }
    public function update(Request $req, $id)
    {
        if ($req->password1 == null) {
            $data = User::find($id);
            $data->name = $req->name;
            $data->roles = $req->roles;
            $data->save();
            Session::flash('success', 'berhasil diupdate');
            return redirect('/superadmin/user');
        } else {
            if ($req->password1 != $req->password2) {
                Session::flash('warning', 'password tidak sama');
                return back();
            } else {
                $data = User::find($id);
                $data->name = $req->name;
                $data->roles = $req->roles;
                $data->password = Hash::make($req->password1);
                $data->save();
                Session::flash('success', 'berhasil diupdate');
                return redirect('/superadmin/user');
            }
        }
    }
    public function delete($id)
    {
        User::find($id)->delete();
        Session::flash('success', 'berhasil dihapus');
        return redirect('/superadmin/user');
    }
}
