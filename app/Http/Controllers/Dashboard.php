<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Dashboard extends Controller
{
    public function Dashboard(){
        return view('dashboard.main',[
            'attendances'=> Attendance::latest()->where('user_id',auth()->user()->id)->filter(request(['search']))->simplePaginate(25)->withQueryString()
        ]);
    }

    public function profile(){
        return view('dashboard.userAccount',[
            'users' =>User::where('id',auth()->user()->id)->first()
        ]);
    }
    public function edit(User $user){
        return view('dashboard.edit',[
            'user' =>User::where('id',$user->id)->first()
        ]);
    }

    public function update(User $user,Request $request){
        $validateData=$request->validate([
            'password' =>'required'
        ]);
        if(isset($request->password)){
            $validateData['password']=Hash::make($request->password);
        }

        User::where('id',$user->id)
        ->update($validateData);
        return redirect('/dashboard')->with('update','Password Has Been Changed Successfully');
    }
}
