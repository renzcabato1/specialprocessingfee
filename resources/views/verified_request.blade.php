<div class="modal" id="verifyRequest{{ $form->id }}" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg " role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class='col-md-10'>
					<h5 class="modal-title" id="exampleModalLabel">Approval Remarks</h5>
				</div>
				<div class='col-md-2'>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
			<form method='post' action='approved-request/{{ $form->id }}' onsubmit='show();' enctype="multipart/form-data">
				<div class="modal-body">
					{{ csrf_field() }}
					<input type='hidden' value='' id='id_row' required>
					<div class='col-md-12'>
						Remarks :
						<textarea class='form-control' name='remarks' id='remarks' required></textarea>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type='submit' class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
