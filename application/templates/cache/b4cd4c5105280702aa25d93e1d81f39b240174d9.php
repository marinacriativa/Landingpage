 <!-- START APPLY MODAL -->
 <div class="modal fade" id="applyNow" tabindex="-1" aria-labelledby="applyNow" aria-hidden="true">
	<form class="form-booking">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body p-5">
					<div class="text-center mb-4">
						<h5 class="modal-title" id="staticBackdropLabel">Apply For This Job</h5>
					</div>
					<div class="position-absolute end-0 top-0 p-3">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<input type="hidden" name="job_name">
					<input type="hidden" name="type" value="0">
					<div class="mb-3">
						<label for="nameControlInput" class="form-label">Name</label>
						<input type="text" name="name" class="form-control" id="nameControlInput" placeholder="Enter your name">
					</div>
					<div class="mb-3">
						<label for="emailControlInput2" class="form-label">Email Address</label>
						<input type="email" name="email" class="form-control" id="emailControlInput2" placeholder="Enter your email">
					</div>
					<div class="mb-3">
						<label for="messageControlTextarea" class="form-label">Message</label>
						<textarea class="form-control" name="description" id="messageControlTextarea" rows="4" placeholder="Enter your message"></textarea>
					</div>
					<div class="mb-4">
						<label class="form-label" for="inputGroupFile01">Resume Upload</label>
						<input type="file" name="file" class="form-control" id="inputGroupFile01">
					</div>
					<button type="submit" class="btn btn-primary w-100">Send Application</button>
				</div>
			</div>
		</div>
		<div class="recaptcha" style="visibility:hidden;"></div>
	</form>
</div><!-- END APPLY MODAL --><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/modals/apply-now.blade.php ENDPATH**/ ?>