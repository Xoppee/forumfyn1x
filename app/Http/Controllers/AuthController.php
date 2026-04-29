<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;

class AuthController extends Controller
{
    
    public function index()
    {
        return view('auth.index');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            return redirect()->route('home')->with('success', 'Login successful.');
        }
        
        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login')->with('success', 'Logout successful.');
    }
}
