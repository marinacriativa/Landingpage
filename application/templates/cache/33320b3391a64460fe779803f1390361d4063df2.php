<div id="forgot-password-modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<div class="form-box">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<div class="form-tab">
						<ul class="nav nav-pills nav-fill" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="forgot-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">Recuperar Password</a>
							</li>
						</ul>
					</div>
					<br>
					<form id="forgot-password">
						<div class="form-group">
							<label for="forgot-email">Email *</label>
							<input type="email" name="email" class="form-control" id="forgot-email" placeholder="<?php echo e($langg->lang193); ?>" required="">
							<input type="hidden" name="frontoffice" value="true">
						</div>
						<input class="fauthdata" type="hidden" value="<?php echo e($langg->lang195); ?>">
						<div class="form-footer">
							<div class="col-md-12"><br><a href="javascript:;" id="show-login" data-toggle="modal" data-target="#signin-modal" class="forgot-link"><?php echo e($langg->lang194); ?></a></div>
							<button type="submit" class="btn btn-outline-primary-2">
								<span><?php echo e($langg->lang196); ?></span>
								<i class="icon-long-arrow-right"></i>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	window.addEventListener("load", function () {
		$('#forgot-password').submit((e) => {
			e.preventDefault();
			var formData = new FormData(document.querySelector('#forgot-password'))		

			$.ajax({
				url: "/forgot",
				type: "POST",
				data: formData,
				processData: false,
				contentType: false,
				success: function (response) {			
					console.log(response);
					let obj = JSON.parse(response)
					window.location.href = '/<?php echo e($selected_language->code); ?>/?msg=' + obj.message;
				},
				error: function (jqXHR, textStatus, errorThrown) {

					window.location.href = '/<?php echo e($selected_language->code); ?>/?msg=' + obj.message;
				}
			});
		});

	
		$('#show-login').click(() => {
			$("#forgot-password-modal").modal("hide");
		})
		
	}); 
</script><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/modals/forgot-password.blade.php ENDPATH**/ ?>