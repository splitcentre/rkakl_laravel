<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(){
        return view('login');
    }

    public function loginpost(Request $request){
        $credential=[
            'email'=>$request->email,
            'password'=>$request->password,
        ];

        if (LoginController::attempt($credential)){
            return redirect('/home')->with('success','login Success');
        }
        return back()->with('error','error Email or Password');
    }
}
