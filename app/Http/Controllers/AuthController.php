<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // PG08 登録画面
    public function showRegister()
    {
        return view('auth.register');
    }

    // 登録処理
    public function register(RegisterRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login');
    }

    // PG09 ログイン画面
    public function showLogin()
    {
        return view('auth.login');
    }

    // ログイン処理
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('/admin');
        }

        return back()->withErrors([
            'email' => 'ログイン情報が正しくありません',
        ]);
    }

    // PG10 ログアウト
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
