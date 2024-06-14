<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegisteredUser;
use App\Http\Requests\RegisterRequest;

class RegisteredUserController extends Controller
{
    public function index() {
        return view('auth.register');
    }

    public function register(RegisterRequest $request) {
        $validated = $request->validated();
        RegisteredUser::create ([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => $validated['password'], 
    ]);
        return view('auth.login');
  }
}
