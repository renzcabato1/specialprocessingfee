<?php

namespace App\Http\Controllers;
use App\Company;
use App\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    //

    public function companies()
    {
         $companies = Company::get();
         $users = User::where('status','')->get();
         return view('companies',
         array(
             'subheader' => 'Companies',
             'header' => "Settings",
             'companies' => $companies,
             'users' => $users,
         ));
    }
    public function editCompany(Request $request,$id)
    {
        dd($request->all());
    }
}
