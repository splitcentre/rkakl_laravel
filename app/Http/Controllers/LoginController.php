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
}