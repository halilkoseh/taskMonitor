<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {

            return back()->withErrors([
                'username' => 'Hay aksi! Giriş bilgileriniz hatalı.',
            ]);
        }

        $user = Auth::user();

        if ($user->is_admin == 1) {
            return redirect()->intended('admin');
        }


        if ($user->is_admin == 0) {

            return redirect()->intended('user');
        }

        if ($user->is_admin == 2) {

            return redirect()->intended('manager');
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }



}
