@extends('layouts.header')

@section('content')


<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-warning pull-right">as of Today</span>
                    <h5> Pending For Review</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins" id='pending_request'>0</h1>
                    {{-- <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> --}}
                    <small>&nbsp;</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">as of Today</span>
                    <h5>Approved Request</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins" >0</h1>
                    {{-- <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> --}}
                    <small>&nbsp;</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-danger pull-right">as of Today</span>
                    <h5>Declined Requests</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins" id='declined_request'>0</h1>
                    {{-- <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> --}}
                    <small>&nbsp;</small>
                </div>
            </div>
        </div>
    </div>
@if(session()->has('status'))
<div class="alert alert-success alert-dismissable">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    {{session()->get('status')}}
</div>
@endif
@include('error')
    <div class="row">
        <div class="col-lg-12 ">
            <div class="ibox float-e-margins">
                {{-- <div class="ibox-title">
                    <h5>Requests
                        <button class="btn btn-primary" data-target="#new_request" data-toggle="modal" type="button"><i class="fa fa-plus-circle"></i>&nbsp;</button>
                    </h5>
                    <div ibox-tools></div>
                </div> --}}
              
                <div class="ibox-content">
                    <table datatable="" dt-options="dtOptions" class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                            <tr>
                                {{-- <th>Logo</th> --}}
                                <th>SPF Control #</th>
                                <th>Requestor</th>
                                <th>Date Requested</th>
                                <th>Information</th>
                                <th>Purpose</th>
                                <th>Payee Information</th>
                                <th>Amount</th>
                                <th>Attachments</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>   
                        </thead>
                        <tbody>
                            @foreach($form_requests as $form)
                                <tr>
                                    <td>SPF-{{$form->project->company->company_code}}-{{str_pad($form->id, 6, '0', STR_PAD_LEFT)}}</td>
                                    <td>{{$form->user->name}}</td>
                                    <td>{{date('F d, Y',strtotime($form->created_at))}}</td>
                                    <td> @if($form->project != null)
                                        <small>
                                        Project ID : {{$form->project->project_id}}
                                        <br>
                                        Remaining Budget : {{number_format($form->project->spf_budget,2)}}
                                        <br>
                                        @endif
                                        
                                    <td>{!! nl2br(e($form->purpose)) !!}</td>
                                    <td><small>
                                        Code : PAYEE-{{str_pad($form->payee_code, 6, '0', STR_PAD_LEFT)}}
                                        <br>
                                        Bank : {{$form->bank_info->bank_name}}
                                        <br>
                                        Account Number : {{$form->account_number}}
                                        <br>
                                    
                                    </td>
                                    <td>{{number_format($form->amount,2)}} 
                                    </td>
                                    <td>
                                      
                                        @if(count($form->attachments) == 0)
                                            No Data Found
                                        @else
                                            @foreach($form->attachments as $attachment)
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{$form->status}}</td>
                                    <td data-id='{{$form->id}}'>
                                        <button class="btn btn-sm btn-info "  title='Approve Request'  data-target="#approveRequest{{$form->id}}" data-toggle="modal" ><i class="fa fa-check-square-o"></i></button>
                                        <button class="btn btn-sm btn-danger declined-request" title='Decline Request'  data-target="#declinedRequest{{$form->id}}" data-toggle="modal" ><i class="fa fa-window-close-o"></i></button>
                                        @include('approved_request')
                                        @include('decline_request')
                                    </td>
                                </tr>   
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
