<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class Test extends Controller
{
    public function test(){
        //halaman ini digunakan jika ingin test sesuatu
        return redirect('/dashboard');
    }
}
