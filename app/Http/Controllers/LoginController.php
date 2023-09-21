<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // ... other methods ...

    public function login(Request $request){
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            // Authentication was successful
            return redirect('/home')->with('success', 'Login Success');
        }

        // Authentication failed
        return back()->with('error', 'Incorrect Email or Password');
    }
}