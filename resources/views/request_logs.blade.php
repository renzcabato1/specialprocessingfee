<div class="modal fade" id="requesLogs{{ $cancelled->id }}" tabindex="-1" role="dialog" aria-labelledby="requesLogs"
	aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content ">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Request Logs</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-stripe table-hover" id="request-logs">
					<thead>
						<tr>
							<th>Action</th>
							<th>Remarks</th>
							<th>User</th>
							{{-- <th>Created On</th>
							<th>Last Modified On</th> --}}

						</tr>
					</thead>
					<tbody>
						@foreach ($cancelled->request_history as $logs)
							<tr>
								<td>{{ $logs->action }}</td>
								<td>{{ $logs->remarks }}</td>
								<td>{{ $logs->user->name }}</td>

							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
