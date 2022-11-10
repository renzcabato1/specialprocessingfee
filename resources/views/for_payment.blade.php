@extends('layouts.header')

@section('content')
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-sm-4">
			<h2>For Payment List</h2>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
					<li class="breadcrumb-item active font-weight-bold" aria-current="page">For Payment</li>
				</ol>
			</nav>
		</div>
	</div>
	<div class="wrapper wrapper-content">
		@if (session()->has('status'))
			<div class="alert alert-success alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				{{ session()->get('status') }}
			</div>
		@endif
		@include('error')
		<div class="row">
			<div class="col-lg-8">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Requests
						</h5>
						<div ibox-tools></div>
					</div>
					<div class="ibox-content">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover reqTbl">
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
										<tr>
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
											<td>
												@if ($form->status == 'Approved')
													<span id="status{{ $form->id }}" class="badge badge-primary">
														{{ $form->status }}
													</span>
												@endif
											</td>
											<td data-id='{{ $form->id }}'>
												<button class="btn btn-sm btn-info " title='Add Payment' data-target="#addPayment{{ $form->id }}"
													data-toggle="modal"><i class="fa fa-money"></i></button>
												@include('add_payment')
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
			<div class="col-lg-4">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Payments
						</h5>
						<div ibox-tools></div>
					</div>
					<div class="ibox-content">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover paymentsTbl">
								<thead>
									<tr>
										{{-- <th>Logo</th> --}}
										<th>Voucher #</th>
										<th>Voucher Amount</th>
										<th>Date Created</th>
										<th>Created By</th>
										{{-- <th>Action</th> --}}
									</tr>
								</thead>
								<tbody>
									@foreach ($payments as $payment)
										<tr>
											<td>{{ $payment->voucher_number }}</td>
											<td>{{ number_format($payment->voucher_amount, 2) }}</td>
											<td>{{ date('F d, Y', strtotime($payment->created_at)) }}</td>
											<td>{{ $payment->user }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('payment_script')
	<script>
		$(document).ready(function() {
			$('.reqTbl').DataTable({
				pageLength: 25,
				responsive: true,
				// paging: false,
				// searching: false
				dom: '<"html5buttons"B>lTfgitp',
				buttons: [{
						extend: 'copy'
					},
					{
						extend: 'csv'
					},
					{
						extend: 'excel',
						title: 'ExampleFile'
					},
					{
						extend: 'pdf',
						title: 'ExampleFile'
					},

					{
						extend: 'print',
						customize: function(win) {
							$(win.document.body).addClass('white-bg');
							$(win.document.body).css('font-size', '10px');

							$(win.document.body).find('table').addClass('compact').css('font-size',
								'inherit');
						},
					},
				],
			});
			$('.paymentsTbl').DataTable({
				pageLength: 10,
				responsive: true,
				// paging: false,
				// searching: false
			});
		});
	</script>
@endsection
