<?php

namespace App\Http\Controllers;
use App\Project;
use App\Company;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    //

    public function project()
    {
        $projects = Project::with('company')->get();
        $companies = Company::get();
        return view('projects',
        array(
            'subheader' => '',
            'header' => "Projects",
            'projects' => $projects,
            'companies' => $companies,
        ));
    }
}
