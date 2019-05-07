<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index_page(){
        return view('index');
    }
    public function home_page(){
        return view('Home');
    }
}
