<div class="modal fade" id="change_pass{{ $user->id }}" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class='col-md-10'>
					<h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
				</div>
				<div class='col-md-2'>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
			<form method='post' action='change-password/{{ $user->id }}' onsubmit='show();' enctype="multipart/form-data">
				<div class="modal-body">
					{{ csrf_field() }}
					<div class='col-md-12'>
						New Password :
						<input type="password" class="form-control form-control-sm" name="password" required />
					</div>
					<div class='col-md-12'>
						Confirm Password :
						<input type="password" class="form-control form-control-sm" name="password_confirmation" required />
					</div>
				</div>
				<div class="modal-footer">
					<button type='submit' class="btn btn-primary"><span class="ti-save"></span> Save Changes</button>
				</div>
			</form>
		</div>
	</div>
</div>
