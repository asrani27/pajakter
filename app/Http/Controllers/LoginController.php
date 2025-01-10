<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $role = Auth::user()->roles;
            $routes = [
                'superadmin' => '/superadmin',
                'dpw' => '/dpw',
                'dpd' => '/dpd',
                'dpk' => '/dpk',
            ];

            if (array_key_exists($role, $routes)) {
                Session::flash('success', 'Selamat Datang');
                return redirect($routes[$role]);
            }

            // Jika role tidak ada di routes, logout dan kembali ke login
            Auth::logout();
            Session::flash('error', 'Role tidak valid. Silakan login ulang.');
            return redirect('login');
        }

        return view('login2');
    }
    public function login(Request $req)
    {
        // if ($req->get('cf-turnstile-response') == null) {
        //     Session::flash('warning', 'Checklist Captcha');
        //     return back();
        // } else {
        //     $turnstile = new TurnstileLaravel;
        //     $response = $turnstile->validate($req->get('cf-turnstile-response'));

        //     if ($response['status'] == true) {

        $remember = $req->remember ? true : false;
        $credential = $req->only('username', 'password');

        if (Auth::attempt($credential, $remember)) {
            $role = Auth::user()->roles;
            $routes = [
                'superadmin' => '/superadmin',
                'dpw' => '/dpw',
                'dpd' => '/dpd',
                'dpk' => '/dpk',
            ];

            if (array_key_exists($role, $routes)) {
                Session::flash('success', 'Selamat Datang');
                return redirect($routes[$role]);
            }

            // Jika role tidak ada di routes, logout dan kembali ke login
            Auth::logout();
            Session::flash('error', 'Role tidak valid. Silakan login ulang.');
            return redirect('login');
        } else {

            Session::flash('error', 'username/password salah');
            $req->flash();
            return back();
        }
        //         }
        //     }
    }
}
