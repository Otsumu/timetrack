<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\RegisterUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
  public function index() {
    return view('auth.login');
}

public function getSes(Request $request) {
    $data = $request->session()->get('txt');
    return view('auth.login', ['data' => $data]);
}

public function postSes(LoginRequest $request)
{
    dd($request);
    
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/');
    } else {
        return redirect('/auth/login')->withInput()->withErrors([
            'password' => 'ログイン情報が正しくありません。',
        ]);
    }
}

}