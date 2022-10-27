@extends('layouts.header')

@section('content')
	<div class="wrapper wrapper-content">
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
					<div class="ibox-title">
						<h5>Projects
							<button class="btn btn-primary btn-sm" data-target="#new_project" data-toggle="modal" type="button"><i
									class="fa fa-plus-circle"></i> Add Project</button>
						</h5>
						<div ibox-tools></div>
					</div>
					<div class="ibox-content">

						<table datatable="" dt-options="dtOptions"
							class="table table-striped table-bordered table-hover dataTables-example">
							<thead>
								<tr>
									<th>Project ID</th>
									<th>Company</th>
									<th>Agency</th>
									<th>Project Description</th>
									<th>Contract Amount </th>
									<th>Actual Budget Contract</th>
									<th> Budget for SPF</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($projects as $project)
									<tr>
										<td>{{ $project->project_id }}</td>
										<td>{{ $project->company->company_code }}</td>
										<td>{{ $project->agency }}</td>
										<td>{!! nl2br(e($project->project_description)) !!}</td>
										<td>{{ number_format($project->abc, 2) }}</td>
										<td>{{ number_format($project->awarded_amount, 2) }}</td>
										<td>{{ number_format($project->spf_budget, 2) }}</td>
										<td id='statustd{{ $project->id }}'>
											@if ($project->status == 'Inactive')
												<small id="status{{ $project->id }}" class="label label-danger">Inactive</small>
											@else
												<small id="status{{ $project->id }}" class="label label-primary">Active</small>
											@endif
										</td>


										<td id='actiontd{{ $project->id }}' data-id='{{ $project->id }}'>

											@if ($project->status == 'Inactive')
												<button class="btn btn-sm btn-primary activate-project" title="Activate Project" id="{{ $project->id }}"
													onclick="activateProj(this.id)" onsubmit="show();"><i class="fa fa-check"></i></button>
											@else
												{{-- <button class="btn btn-sm btn-info"  title='Edit' data-target="#editProject{{$project->id}}" data-toggle="modal"><i class="fa fa-edit"></i></button> --}}
												<button class="btn btn-sm btn-danger deactivate-project" title='Deactivate Project' id="{{ $project->id }}"
													onclick="deactivateProj(this.id)" onsubmit="show();"><i class="fa fa-ban"></i></button>
											@endif
											{{-- <button class="btn btn-sm btn-info" data-target="#change_pass{{$company->id}}" data-toggle="modal">Change Password</button> --}}
											{{-- <button class="btn btn-sm btn-danger delete-comp" data-target="#deletecomp{{$company->id}}" data-toggle="modal">Delete</button> --}}
										</td>
									</tr>
									{{-- @include('edit_project')  --}}
								@endforeach
							</tbody>
						</table>

					</div>
				</div>
			</div>
		</div>
	</div>
	@include('new_project')
@endsection
<script>
	function deactivateProj(id) {
		var element = document.getElementById('actiontd' + id);
		var dataID = element.getAttribute('data-id');
		Swal.fire({
			title: 'Deactivate this project',
			text: "Are you sure about this?",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				document.getElementById("myDiv").style.display = "block";
				$.ajax({
					url: "deactivate-project/" + id,
					method: "POST",
					data: {
						id: id
					},
					headers: {
						'X-CSRF-TOKEN': '{{ csrf_token() }}'
					},
					success: function(data) {
						document.getElementById("myDiv").style.display = "none";
						swal.fire(
							'Deactivated!',
							'Project has been deactivated',
							'success'
						).then(function() {
							document.getElementById("statustd" + id).innerHTML =
								"<small class='label label-danger'>Inactive</small>";

							document.getElementById("actiontd" + dataID).innerHTML =
								"<button type='button' id='action" +
								id + "' onclick='activateProj(" + id +
								")' onsubmit='show()' class='btn btn-sm btn-primary activate-project' title='Activate Project'><i class='fa fa-check'></i></button>";


						});
					}
				})
			} else if (
				result.dismiss === Swal.DismissReason.cancel
			) {
				swal.fire(
					'Cancelled',
					'Project is safe',
					'error'
				)
			}
		})
	}

	function activateProj(id) {
		var element = document.getElementById('actiontd' + id);
		var dataID = element.getAttribute('data-id');
		Swal.fire({
			title: 'Activate this project',
			text: "Are you sure about this?",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				document.getElementById("myDiv").style.display = "block";
				$.ajax({
					url: "activate-project/" + id,
					method: "POST",
					data: {
						id: id
					},
					headers: {
						'X-CSRF-TOKEN': '{{ csrf_token() }}'
					},
					success: function(data) {
						document.getElementById("myDiv").style.display = "none";
						swal.fire(
							'Activated!',
							'Project has been activated',
							'success'
						).then(function() {
							document.getElementById("statustd" + id).innerHTML =
								"<small class='label label-primary'>active</small>";

							var action = document.getElementById("actiontd" + dataID)
								.innerHTML =
								"<button type='button' id='action" +
								id + "' onclick='deactivateProj(" + id +
								")' onsubmit='show()' class='btn btn-sm btn-danger activate-project' title='Deactivate Project'><i class='fa fa-ban'></i></button>";

						});
					}
				})
			} else if (
				result.dismiss === Swal.DismissReason.cancel
			) {
				swal.fire(
					'Cancelled',
					'Project is safe',
					'error'
				)
			}
		})
	}
</script>
