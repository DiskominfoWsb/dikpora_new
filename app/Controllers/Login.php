<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        //check authentication
        if(session()->ID) return redirect()->to('dashboard');

        return view('login');
    }
}