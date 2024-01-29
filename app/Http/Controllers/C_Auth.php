<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class C_Auth extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $dataLogin = $request->all();

        if (Auth::attempt(['username' => strtolower($dataLogin['Username']), 'password' => $dataLogin['Password']])) {
            $user = Auth::guard('web')->user();
        } else {
            return redirect()->to('/login')->with('error', 'Username atau Password Salah')->withInput();
        }

        $ses_data = [
            'id_user' => $user->id_user,
            'username' => $user->username,
            'role' => $user->role,
        ];
        $request->session()->put($ses_data);
        if (session('role') == 'pengurus')
            return redirect()->route('dashboard');
        else
            return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect()->route('login');
    }
}
