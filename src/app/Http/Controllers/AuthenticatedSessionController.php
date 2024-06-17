<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\RegisteredUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function login(LoginRequest $request){
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            Log::info('ログイン成功: User logged in: ' . Auth::user()->email);
            
            return redirect()->intended('/dashboard');
        } else {
            Log::warning('ログイン失敗: Login attempt failed for email: ' . $request->email);
            
            return back()->withErrors([
                'email' => 'メールアドレスまたはパスワードが正しくありません。',
            ]);
        }    
    }

    public function destroy(Request $request) {
        Auth::logout();
        return redirect('/login');
    }
}

