<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // ... other methods ...
    public function login(){
        return view('login');
    }

    public function loginpost(Request $request){
        $credentials = $request->validate([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if (Auth::attempt($credentials)) {
            // Authentication was successful
            return redirect('/home')->with('success', 'Login Success');
        }

        // Authentication failed
        return back()->withErrors('error', 'Incorrect Email or Password');
    }
    public function dashboard(){
        
        if (Auth::check()) {
            return view('auth.dashboard');
        }
        return redirect()->route('login')
        ->withErrors(['You are not allowed to access',])->onlyInput('email');

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
        ->withSuccess("You have logged out");
    }
}