<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        if(session()->user){
            return redirect()->to('/'); 
        }
        return view('login');
    }

    public function logout()
    {
        session()->destroy(); return redirect()->to('/login'); 
    }
    
}
