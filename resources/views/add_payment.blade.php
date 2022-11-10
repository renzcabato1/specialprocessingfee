<div class="modal" id="addPayment{{ $form->id }}" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-md-10">
					<h5 class="modal-title" id="exampleModalLabel">
						Payment Form
					</h5>
				</div>
				<div class="col-md-2">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
			<form method="post" action="save-payment/{{ $form->id }}" onsubmit="show();" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="modal-body">

					<!-- <input type="hidden" value="" id="id_row" required /> -->
					<div class="form-group">
						<label>Voucher #:</label>
						<input type="text" placeholder="Enter voucher number" name="voucher_number" class="form-control" required />
					</div>
					<div class="form-group">
						<label>Voucher Amount:</label>
						<input type="number" placeholder="Enter amount" name="voucher_amount" class="form-control" required />
					</div>

					<div class="form-group">
						<label>Attachment:</label>
						<input type="file" class="form-control " id='attachment' name="attachment" required />
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						Close
					</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
