<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function login()
    {
        return view('auth-login-basic');
    }

    public function signup()
    {
        return view('auth-register-basic');
    }
    public function users()
    {
        return view('auth-user');
    }

    public function form()
    {
        return view('form');
    }
}
