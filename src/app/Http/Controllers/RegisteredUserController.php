<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegisteredUser;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;

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
        'password' => Hash::make($validated['password']), 
    ]);
        return view('auth.login');
  }
}
