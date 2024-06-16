<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\RegisteredUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function postSes(LoginRequest $request) {
        $credentials = $request->only('email', 'password');
        $user = RegisteredUser::where('email', $credentials['email'])->first();
    
        if ($user && Hash::check($credentials['password'], $user->password)) {
          Auth::login($user);
          $request->session()->regenerate(true);
          Log::info('User logged in: ', ['user' => Auth::user()]);
          return redirect('/');
        
        } else {
          return redirect('/login')->withErrors(['login_error' => 'メールアドレスまたはパスワードが正しくありません。']);
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
