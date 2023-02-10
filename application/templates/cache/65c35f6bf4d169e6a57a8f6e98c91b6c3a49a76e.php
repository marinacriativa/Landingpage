<div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true"><i class="icon-close"></i></span>
				</button>
				<div class="form-box">
					<div class="form-tab">
						<ul class="nav nav-pills nav-fill" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true"><?php echo e(ucfirst($translations["frontoffice"]["login_button"])); ?></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/<?php echo e($selected_language->code); ?>/register" aria-selected="false"><?php echo e(ucfirst($translations["frontoffice"]["title_register"])); ?></a>
							</li>
						</ul>
						<div class="tab-content" id="tab-content-5">
							<div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
								<br>
								<?php if(isset($_GET["loginMessage"])): ?>
									<div class="col-xs-12 mb-3">
										<div class="alert alert-warning alert-dismissible" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<strong>Atenção!</strong> <?php echo e($_GET["loginMessage"]); ?>

										</div>
									</div>
								<?php endif; ?>
								<form action="/login" method="POST">
									<input class="mauthdata" type="hidden" value="<?php echo e($langg->lang177); ?>">
									<div class="form-group">
										<label for="login-email"><?php echo e(ucfirst($translations["frontoffice"]["login_fill_email"])); ?> *</label>
                                    	<input id="login-email" class="form-control" type="email" name="email" placeholder="<?php echo e(ucfirst($translations["frontoffice"]["login_placeholder_email"])); ?>" required>
									</div>
									<div class="form-group">
										<label for="login-password"><?php echo e(ucfirst($translations["frontoffice"]["login_fill_password"])); ?> *</label>
                                    	<input id="login-password" class="form-control" type="password" autocomplete="katrina" name="password" placeholder="<?php echo e(ucfirst($translations["frontoffice"]["login_placeholder_password"])); ?>" required>
									</div>
									<div class="form-footer">
										<button type="submit" class="btn btn-outline-primary-2">
										<span><?php echo e(ucfirst($translations["frontoffice"]["login_button"])); ?></span>
										<i class="icon-long-arrow-right"></i>
										</button>
										<div class="col-md-12 mt-3">
											<a href="javascript;" id="fgt_pass" data-toggle="modal" data-target="#forgot-password-modal" class="forgot-link">
												<?php echo e(ucfirst($translations["frontoffice"]["login_forgot_password"])); ?>

											</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	window.addEventListener("load", function () {
		$('#fgt_pass').click(() => {
			$("#signin-modal").modal("hide");
		})
	}); 
</script>
<?php if(isset($_GET["loginMessage"])): ?> 
<script>
	window.addEventListener("load", function () {
		$("#signin-modal").modal("show");	
	}); 
</script>
<?php endif; ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/modals/login-register.blade.php ENDPATH**/ ?>