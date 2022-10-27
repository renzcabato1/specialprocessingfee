<?php

namespace App\Http\Controllers;

use App\Project;
use App\Company;
use App\ProjectAttachment;
use Illuminate\Http\Request;
use Alert;

class ProjectController extends Controller
{
    //

    public function project()
    {
        $projects = Project::with('company')->get();
        $companies = Company::get();
        return view(
            'projects',
            array(
                'subheader' => '',
                'header' => "Projects",
                'projects' => $projects,
                'companies' => $companies,
            )
        );
    }
    public function new_project(Request $request)
    {

        $this->validate($request, [
            'company' => 'required',
            'project_id' => 'unique:projects|required',
            'project_description' => 'required',
            'awarded_amount' => 'required',
            'abc_amount' => 'required',
            'spf_budget' => 'required',
            'agency' => 'required',
            'project_attachment' => 'required',
        ]);

        // dd($request->all());
        $project = new Project;
        $project->company_id = $request->company;
        $project->project_id = $request->project_id;
        $project->project_description = $request->project_description;
        $project->agency = $request->agency;
        $project->awarded_amount = $request->awarded_amount;
        $project->abc = $request->abc_amount;
        $project->spf_budget = $request->spf_budget;
        $project->save();

        //Save Multiple File
        if ($request->hasFile('project_attachment')) {
            foreach ($request->file('project_attachment') as $file) {
                $path = $file->getClientOriginalName();
                $name = time() . '-' . $path;
                //$file->move(public_path().'/project-images/', $name);


                $attachment = new ProjectAttachment();
                $file->move(public_path() . '/project-files/', $name);
                $file_name = '/project-files/' . $name;
                $attachment->attachment_url = $file_name;
                $attachment->attachment_title = $path;
                $attachment->project_id = $project->id;
                $attachment->save();
            }
        }
        Alert::success('Success!', 'New Project Created')->persistent('Dismiss');
        return back();
    }
    public function deactivate_project($id)
    {
        Project::Where('id', $id)->update(['status' => 'Inactive']);
        return back();
    }
    public function activate_project($id)
    {
        Project::Where('id', $id)->update(['status' => 'Active']);
        return back();
    }
}
