<?php

namespace App\Http\Controllers;
use App\Bank;
use App\Project;
use App\FormRequest;
use App\FormRequestHistory;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    //

    public function requests()
    {
        $banks = Bank::get();
        $projects = Project::get();
        $form_requests = FormRequest::with('project.company','user','bank_info','attachments')->where('encode_by',auth()->user()->id)->where('status','Pending')->get();
        $form_requests_pending = FormRequest::with('project.company','user','bank_info','attachments')->where('encode_by',auth()->user()->id)->where('status','Pending')->get();
        $header = "Requests";
        $subheader = "";

        return view('requests', 
        array(
            'header' => $header,
            'subheader' => $subheader,
            'banks' => $banks,
            'projects' => $projects,
            'form_requests' => $form_requests,
            'form_requests_pending' => $form_requests_pending,
        )
        );
    }
    public function new_request (Request $request)
    {
        // dd($request->all());
        $pay_code = FormRequest::orderBy('id','desc')->first();
        if($pay_code == "")
        {
            $code = 1;
        }
        else
        {
            $code = $pay_code->payee_code+1;
        }
        $form = New FormRequest;
        $form->spf_type = $request->project;
        $form->purpose = $request->purpose;
        $form->project_id = $request->project_id;
        $form->name_of_payee = $request->payee;
        $form->bank = $request->bank;
        $form->account_number = $request->account_number;
        $form->amount = $request->amount;
        $form->amount_in_words = $request->amount_in_words;
        $form->payee_code = $code;
        $form->remarks = $request->remarks;
        $form->encode_by = auth()->user()->id;
        $form->status = "Pending";
        $form->save();
        
        $history = new FormRequestHistory;
        $history->form_request_id = $form->id;
        $history->action = "Create Request";
        $history->remarks = $request->remarks;
        $history->action_by = auth()->user()->id;
        $history->save();

        $request->session()->flash('status','Successfully created');
        return back();

    }
    public function for_review()
    { 
        $banks = Bank::get();
        $projects = Project::get();
        $form_requests = FormRequest::with('project.company','user','bank_info','attachments')->where('status','Pending')->get();
        $header = "For Review";
        $subheader = "";

        return view('for_reviews', 
        array(
            'header' => $header,
            'subheader' => $subheader,
            'banks' => $banks,
            'projects' => $projects,
            'form_requests' => $form_requests,
        )
        );
    }
    public function for_verification()
    {
        $projects = Project::get();
        $form_requests = FormRequest::with('project.company','user','bank_info','attachments')->where('status','Approved')->get();
        $header = "For Verification";
        $subheader = "";

        return view('for_verification', 
        array(
            'header' => $header,
            'subheader' => $subheader,
            'projects' => $projects,
            'form_requests' => $form_requests,
        )
        );
    }
    public function approved_request (Request $request,$id)
    {
        $form = FormRequest::where('id',$id)->first();
        $form->status = "Approved";
        $form->save();

        $history = new FormRequestHistory;
        $history->form_request_id = $id;
        $history->action = "Approved Request";
        $history->remarks = $request->remarks;
        $history->action_by = auth()->user()->id;
        $history->save();
        $request->session()->flash('status','Successfully Approved');
        return back();
    }

}
