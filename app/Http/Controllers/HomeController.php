<?php

namespace App\Http\Controllers;

use App\User;
use App\Project;
use App\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

        $projects = Project::get();

        $allRequests = FormRequest::with('project')->orderBy('created_at', 'DESC')->get();
        $requestsPerYear = FormRequest::whereYear('created_at', date('Y'))->get();
        $requestsLastMonth = FormRequest::whereMonth('created_at', Carbon::now()->subMonth()->month)->get();

        // $x = $requests->;
        // dd($requestsLastMonth);

        return view('home', array(
            'header' => $header,
            'subheader' => $subheader,
            'user' => $user,
            'projects' => $projects,
            'allRequests' => $allRequests,
            'requestsPerYear' => $requestsPerYear,
            'requestsLastMonth' => $requestsLastMonth,
        ));
    }
}
