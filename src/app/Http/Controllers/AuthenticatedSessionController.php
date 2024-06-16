<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\RegisteredUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    public function index(){
         return view('auth.login');
    }
    
    public function store(LoginRequest $request){
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
         $request->session()->regenerate(true);

         Log::info('User logged in: ', ['user' => Auth::user()]);

         return redirect()->intended('/index');
        } else {
         return redirect('/login');
        }
    } 

    public function destroy(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

