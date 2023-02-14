<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class authentication extends Controller
{
    //direct login
    public function loginPage()
    {
        return view('admin.login');
    }

    //direct register
    public function registerPage()
    {
        return view('admin.register');
    }

    //dashboard(user or admin)
    public function dashboard()
    {
        if(auth()->user()->role == 'admin')
        {
            return redirect()->route('admin#chartList');
        }elseif(auth()->user()->role == 'user')
        {
            return redirect()->route('user#home');
        }
    }
}
