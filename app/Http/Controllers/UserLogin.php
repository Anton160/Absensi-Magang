<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLogin extends Controller
{
    public function UserAccount(){
        return view('UserLogin');
    }

    public function Authenticate(Request $request){
        $crd=$request->validate([
            'name'=>'required',
            'employee_id'=>'required',
            'password'=>'required',

        ]);

        if(Auth::attempt($crd)){
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
        return back()->with('loginError','login Failed');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/userLogin');
    }
}
