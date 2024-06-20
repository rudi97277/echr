<?php

namespace App\Http\Controllers\Web;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function page()
    {
        if (Auth::check())
            return redirect()->back();
        return view('layouts.worker.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required|string"
        ]);

        if (Auth::attempt($request->only("email", "password"))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === RoleEnum::ADMINISTRATOR) {
                return redirect()->route('admin.master-karyawan');
            } else
                return redirect()->intended('/');
        }
        return back()->withErrors([
            'account' => 'Email atau kata sandi yang anda masukkan salah!',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
