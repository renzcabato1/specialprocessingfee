@extends('layouts.header')
@section('content')
	<div class="wrapper wrapper-content">
		<div class="row">
			<div class="col-lg-3">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<span class="label label-success pull-right">As of this Month</span>
						<h5>Project</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins">{{ count($projects) }}</h1>
						{{-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> --}}
						<small>Total projects</small>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<span class="label label-info pull-right">As of this Month</span>
						<h5>Request</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins">{{ count($allRequests) }}</h1>
						{{-- <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div> --}}
						<small>Total Requests</small>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<span class="label label-primary pull-right">As of this Month</span>
						<h5>Approved Request</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins">{{ count($allRequests->where('status', 'Approved')) }}</h1>
						{{-- <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> --}}
						<small>Total Approved Requests</small>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<span class="label label-danger pull-right">As of this Month</span>
						<h5>For Approval</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins">{{ count($allRequests->where('status', 'Pending')) }}</h1>
						{{-- <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div> --}}
						<small>Total of Pending Requests</small>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Requests</h5>
						{{-- <div class="pull-right">
							<div class="btn-group">
								<button type="button" class="btn btn-xs btn-white active">Today</button>
								<button type="button" class="btn btn-xs btn-white">Monthly</button>
								<button type="button" class="btn btn-xs btn-white">Annual</button>
							</div>
						</div> --}}
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-6">
								<div class="ibox float-e-margins">
									{{-- <div class="ibox-title">
										<h5>Bar Chart Example</h5>
									</div> --}}
									<div class="ibox-content">
										<div>
											<canvas id="barChart" height="100"></canvas>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<ul class="stat-list">
									<li>
										<h2 class="no-margins">{{ number_format($requestsPerYear->sum('amount')) }}
										</h2>
										<small>Total amount in period</small>
										<div class="stat-percent">48% <i class="fa fa-level-up text-navy"></i></div>
										<div class="progress progress-mini">
											<div style="width: 48%;" class="progress-bar"></div>
										</div>
									</li>
									<li>
										<h2 class="no-margins ">{{ number_format($requestsLastMonth->sum('amount')) }}</h2>
										<small>Tota amount in last month</small>
										<div class="stat-percent">60% <i class="fa fa-level-down text-navy"></i></div>
										<div class="progress progress-mini">
											<div style="width: 20%;" class="progress-bar"></div>
										</div>
									</li>
									{{-- <li>
										<h2 class="no-margins ">9,180</h2>
										<small>Monthly income from orders</small>
										<div class="stat-percent">22% <i class="fa fa-bolt text-navy"></i></div>
										<div class="progress progress-mini">
											<div style="width: 22%;" class="progress-bar"></div>
										</div>
									</li> --}}
								</ul>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Pending Requests</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
							<a class="close-link">
								<i class="fa fa-times"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">
						<table class="table table-hover no-margins" id="pendingReqTbl">
							<thead>
								<tr>
									<th>Status</th>
									<th>Spf Type</th>
									<th>Date Created</th>
									<th>Project Description</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($allRequests->where('status', 'Pending') as $pendingReq)
									<tr>

										<td><span class="label label-warning">{{ $pendingReq->status }}</span></td>
										<td>{{ $pendingReq->spf_type }}</td>
										<td>{{ date('F d, Y', strtotime($pendingReq->created_at)) }}</td>
										<td>{{ $pendingReq->project != null ? $pendingReq->project->project_description : 'No Project Connected' }}
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Approved Requests</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
							<a class="close-link">
								<i class="fa fa-times"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">
						<table class="table table-hover no-margins" id="approvedReqTbl">
							<thead>
								<tr>
									<th>Status</th>
									<th>Spf Type</th>
									<th>Date Created</th>
									<th>Project Description</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($allRequests->where('status', 'Approved')->take(10) as $approvedReq)
									<tr>
										<th><span class="label label-primary ">{{ $approvedReq->status }}</span></th>
										<td>{{ $approvedReq->spf_type }}</td>
										<td>{{ date('F d, Y', strtotime($approvedReq->created_at)) }}</td>
										<td>{{ $approvedReq->project->project_description }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-lg-4"></div>
			<div class="col-lg-4"></div>
		</div>
	</div>
@endsection
@section('dashboard_script')
	<script>
		$(function() {
			var barData = {
				labels: ["January", "February", "March", "April", "May", "June", "July", "Aug", "Sept", "Oct",
					"Nov", "Dec"
				],
				datasets: [{
						label: "Data 1",
						backgroundColor: 'rgba(220, 220, 220, 0.5)',
						pointBorderColor: "#fff",
						data: [65, 59, 80, 81, 56, 55, 40]
					},
					{
						label: "Data 2",
						backgroundColor: 'rgba(26,179,148,0.5)',
						borderColor: "rgba(26,179,148,0.7)",
						pointBackgroundColor: "rgba(26,179,148,1)",
						pointBorderColor: "#fff",
						data: [28, 48, 40, 19, 86, 27, 90]
					}
				]
			};

			var barOptions = {
				responsive: true
			};


			var ctx2 = document.getElementById("barChart").getContext("2d");
			new Chart(ctx2, {
				type: 'bar',
				data: barData,
				options: barOptions
			});
		});
	</script>
@endsection
