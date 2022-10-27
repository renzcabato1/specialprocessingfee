<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     * use App\User;
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $header = "Dashboard";
        $subheader = "";
        $user = User::first();

        return view('home', array(
            'header' => $header,
            'subheader' => $subheader,
            'user' => $user,
        ));
    }
}
