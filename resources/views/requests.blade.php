@extends('layouts.header')

@section('content')
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-sm-4">
			<h2>Request List</h2>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
					<li class="breadcrumb-item active font-weight-bold" aria-current="page">Request</li>
				</ol>
			</nav>
		</div>
	</div>
	<div class="wrapper wrapper-content">
		<div class="row">
			<div class="col-lg-3">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<span class="label label-success pull-right">as of Today</span>
						<h5>Total Requests</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins">{{ count($form_requests) }}</h1>
						{{-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> --}}
						<small>&nbsp;</small>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<span class="label label-warning pull-right">as of Today</span>
						<h5> Pending Requests</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins" id='pending_request'>{{ count($form_requests->where('status', 'Pending')) }}</h1>
						{{-- <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> --}}
						<small>&nbsp;</small>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<span class="label label-primary pull-right">as of Today</span>
						<h5>Approved Requests</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins">{{ count($form_requests->where('status', 'Approved')) }}</h1>
						{{-- <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> --}}
						<small>&nbsp;</small>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<span class="label label-danger pull-right">as of Today</span>
						<h5>Declined/Cancelled Requests</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins" id='declined_request' data-toggle="modal" data-target="#cancelledList"
							style="cursor:pointer;" title="Cancelled Requests">
							{{ count($form_requests_cancelled) }}
						</h1>
						{{-- <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> --}}
						<small>&nbsp;</small>
					</div>
				</div>
			</div>
		</div>
		@if (session()->has('status'))
			<div class="alert alert-success alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				{{ session()->get('status') }}
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
					<button class="btn btn-primary" data-target="#new_request" data-toggle="modal" type="button"><i
							class="fa fa-plus-circle"></i> Create New Request</button>

					<div class="ibox-content">
						<table datatable="" dt-options="dtOptions"
							class="table table-striped table-bordered table-hover dataTables-example">
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
								@foreach ($form_requests as $form)
									<tr id='request{{ $form->id }}'>
										<td>
											@if ($form->project != null)
												SPF-{{ $form->project->company->company_code }}-{{ str_pad($form->id, 6, '0', STR_PAD_LEFT) }}
											@else
												SPF-{{ $form->user->company->company_code }}-{{ str_pad($form->id, 6, '0', STR_PAD_LEFT) }}
											@endif
										</td>
										<td>{{ $form->user->name }}</td>
										<td>{{ date('F d, Y', strtotime($form->created_at)) }}</td>
										<td>
											@if ($form->project != null)
												<small>
													Project ID : {{ $form->project->project_id }}
													<br>
													Remaining Budget : {{ number_format($form->project->spf_budget, 2) }}
													<br>
												</small>
											@endif
										</td>

										<td>{!! nl2br(e($form->purpose)) !!}</td>
										<td><small>
												@if ($form->status == 'Pending')
													Name : {{ $form->name_of_payee }}
													<br>
												@endif
												Code : PAYEE-{{ str_pad($form->payee_code, 6, '0', STR_PAD_LEFT) }}
												<br>
												Bank : {{ $form->bank_info->bank_name }}
												<br>
												Account Number : {{ $form->account_number }}
												<br>

										</td>
										<td>{{ number_format($form->amount, 2) }}
										</td>
										<td>

											@if (count($form->attachments) == 0)
												No Data Found
											@else
												@foreach ($form->attachments as $attachment)
												@endforeach
											@endif
										</td>
										<td id="tdId{{ $form->id }}">
											@if ($form->status == 'Pending')
												<span id="status{{ $form->id }}" class="label label-warning">
													{{ $form->status }}
												</span>
											@elseif($form->status == 'Reviewed')
												<span id="status{{ $form->id }}" class="label label-info">
													{{ $form->status }}
												</span>
											@elseif($form->status == 'Approved')
												<span id="status{{ $form->id }}" class="label label-primary">
													{{ $form->status }}
												</span>
											@endif
										</td>
										<td data-id='{{ $form->id }}' id='actionRow{{ $form->id }}'>
											@if ($form->status == 'Pending')
												{{-- <button class="btn btn-sm btn-info" title='Edit' data-target="#edit_request{{ $form->id }}"
													data-toggle="modal"><i class="fa fa-edit"></i></button> --}}
												<button type="button" class="btn btn-icon btn-danger btn-sm cancelBtn" id="{{ $form->id }}"
													title="Cancel Request" onclick="cancelReq(this.id)">
													<i class="fa fa-ban"></i>
												</button>
											@endif
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		@include('cancelled_list')

	</div>
	@include('new_request')

	<script>
		function cancelReq(id) {
			Swal.fire({
				title: 'Cancel this request',
				text: "Are you sure about this?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: "cancel-request/" + id,
						method: "POST",
						data: {
							id: id
						},
						headers: {
							'X-CSRF-TOKEN': '{{ csrf_token() }}'
						},
						success: function(data) {
							swal.fire(
								'Cancelled!',
								'Request has been cancelled!',
								'success'
							).then(function() {
								var newSpan = document.createElement("span");
								newSpan.setAttribute("class", "label label-danger");
								newSpan.innerHTML = "Cancelled";
								// Append new label
								document.querySelector('#tdId' + id).appendChild(newSpan);
								// Remove Elements
								document.querySelector('#status' + id).remove();
								document.querySelector('#request' + id).remove();

							});
						}
					})
				} else if (
					result.dismiss === Swal.DismissReason.cancel
				) {
					swal.fire(
						'Cancelled',
						'Request is safe',
						'error'
					)
				}
			})
			$(document).ready(function() {
				$('#cancelled-table').DataTable({
					pageLength: 5,
					lengthMenu: [
						[5, 10, 20],
						[5, 10, 20]
					]
					// paging: false,
				});
			});
		}
	</script>
@endsection
