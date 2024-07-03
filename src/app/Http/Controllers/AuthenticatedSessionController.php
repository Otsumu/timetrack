<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\RegisteredUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function login(LoginRequest $request){
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user ->status = 0;
            $user -> save();
            
            $request->session()->regenerate();
            return redirect()->intended('/');
        } else {
            $user = RegisteredUser::where('email', $request->email)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                return back()->withErrors([
                    'email' => 'ログインに失敗しました',
                ]);
            } else {
                return back()->withErrors([
                    'email' => 'メールアドレスまたはパスワードが正しくありません',
                ]);
            }
        }
    }

    public function destroy(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
