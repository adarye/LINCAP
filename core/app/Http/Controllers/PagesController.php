<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){

        return view ('spa');
    }

    public function login(){

        return view ('login.login');
    }
}
