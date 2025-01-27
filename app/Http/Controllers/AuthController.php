<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('frontend.login');
    }

    public function login(Request $request)
    {
        // dd('login function');
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }else{
            $this->alert('Login Failed','Invalid Email or Password','danger');
            return redirect()->route('login.view');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.view');
    }
}
