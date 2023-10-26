<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // ... other methods ...

    public  function __construct()
    {
        $this->middleware('guest')->except(['logout', 'dashboard']);
    }

    public function Store (Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password'=> hash::make($request->password)
        ]);

        $credentials = $request->only('email','password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('dashboard')
        ->withSuccess("Welcome! You have Successfully loggedin");
    }

   public function login(){
         return view('login');
   } 

   public function authenticate(Request $request){
         $credentials = $request->validate([
                'email' => 'required', 'email',
                'password' => 'required',
         ]);

         if(Auth::attempt($credentials)){
              $request->session()->regenerate();
              return redirect()->route('dashboard')
              ->withSuccess("Welcome! You have Successfully loggedin");
         }
         return back()->withErrors([
              'email' => 'The provided credentials do not match our records',
         ])->onlyInput('email');
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