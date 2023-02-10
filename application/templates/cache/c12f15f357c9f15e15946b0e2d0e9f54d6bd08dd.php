 
<?php $__env->startSection('title', 'registrar'); ?> 
<?php $__env->startSection('content'); ?>
<main class="main">
	<div class="page-header text-center" style="background-image: url('/public/static/images/newsletter-bg.jpg')">
		<div class="container">
			<h1 class="page-title"><?php echo e(ucfirst($translations["frontoffice"]["title_register"])); ?>

			<span><?php echo e(ucfirst($translations["frontoffice"]["register_description"])); ?></<span></h1>
		</div>
	</div>
	</div>
	<nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.html"><?php echo e(ucfirst($translations["frontoffice"]["home"])); ?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php echo e(ucfirst($translations["frontoffice"]["title_register"])); ?></li>
			</ol>
		</div>
    </nav>
	<div class="page-content pb-0">
	<div class="container">
		<div class="row">
			<!--<div class="col-lg-12">
				<h2 class="title"><?php echo e(ucfirst($translations["frontoffice"]["title_register"])); ?></h2>
				<p><?php echo e(ucfirst($translations["frontoffice"]["register_description"])); ?></p>
				<hr>
			</div>-->
			<div class="col-lg-6 mb-2 mb-lg-0">
                <?php if(isset($_GET["message"])): ?>
                    <div class="col-xs-6 mt-3">
                        <div class="alert <?php if(isset($_GET["success"])): ?> alert-success <?php else: ?> alert-danger <?php endif; ?> alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong><?php if(isset($_GET["success"])): ?> Sucesso! <?php else: ?> Erro! <?php endif; ?></strong> <?php echo e($_GET["message"]); ?>

                        </div>
                    </div>
                <?php endif; ?>
				<form id="contactform" class="contact-form mb-3" action="/register" method="POST">
					<div class="form-group"> 
                        <label for="register-name"><?php echo e(ucfirst($translations["frontoffice"]["register_fill_name"])); ?> *</label> 
                        <input type="text" class="form-control" id="register-name" name="name" placeholder="<?php echo e(ucfirst($translations["frontoffice"]["register_placeholder_name"])); ?>" required> 
                    </div>
					<div class="form-row">
						<div class="col-md-6 col-xs-12">
							<div class="form-input"> 
                                <label for="register-email"><?php echo e(ucfirst($translations["frontoffice"]["register_fill_email"])); ?> *</label> 
                                <input type="email" class="form-control" id="register-email" name="email" placeholder="<?php echo e(ucfirst($translations["frontoffice"]["register_placeholder_email"])); ?>" required> 
                            </div>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class="form-input"> 
                                <label for="register-phone"><?php echo e(ucfirst($translations["frontoffice"]["register_fill_phone"])); ?> *</label> 
                                <input type="text" class="form-control" id="register-phone" name="phone" placeholder="<?php echo e(ucfirst($translations["frontoffice"]["register_placeholder_phone"])); ?>" required> 
                            </div>
						</div>
					</div>
					<div class="form-input"> 
                        <label for="register-address"><?php echo e(ucfirst($translations["frontoffice"]["register_fill_address"])); ?> *</label> 
                        <input type="text" class="form-control" id="register-address" name="address" placeholder="<?php echo e(ucfirst($translations["frontoffice"]["register_placeholder_address"])); ?>" required> 
                    </div>
					<div class="form-row">
						<div class="col-md-6 col-xs-12">
							<div class="form-input">
                <label for="register-country"><?php echo e(ucfirst($translations["frontoffice"]["register_fill_country"])); ?> *</label> 
								<select id="register-country" class="form-control" name="country" required>
									<option value=""><?php echo e(ucfirst($translations["frontoffice"]["register_option_country"])); ?></option>
                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($country->country_code); ?>"><?php echo e($country->country_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class="form-input"> 
                                <label for="register-city"><?php echo e(ucfirst($translations["frontoffice"]["register_fill_city"])); ?> *</label> 
                                <input type="text" class="form-control" id="register-city" name="city" placeholder="<?php echo e(ucfirst($translations["frontoffice"]["register_placeholder_city"])); ?>" required> 
                            </div>
						</div>
					</div>
					<div class="form-row">
                        <div class="col-md-6 col-xs-12">
							<div class="form-input"> 
                                <label for="register-zip"><?php echo e(ucfirst($translations["frontoffice"]["register_fill_zipCode"])); ?> *</label> 
                                <input type="text" class="form-control" id="register-zip" name="zipCode" placeholder="<?php echo e(ucfirst($translations["frontoffice"]["register_placeholder_zipCode"])); ?>" required> 
                            </div>
						</div>
						<div class="col-md-6 col-xs-12">
                            <label for="register-nif"><?php echo e(ucfirst($translations["frontoffice"]["register_fill_nif"])); ?> </label>
                            <input id="register-nif" class="form-control" type="text" name="nif" placeholder="<?php echo e(ucfirst($translations["frontoffice"]["register_placeholder_nif"])); ?>">
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-row">
						<div class="col-md-6 col-xs-12">
							<div class="form-input"> 
                                <label for="register-password"><?php echo e(ucfirst($translations["frontoffice"]["register_fill_password"])); ?> *</label>
                                <input id="register-password" class="form-control" type="password" autocomplete="katrina" name="password" placeholder="<?php echo e(ucfirst($translations["frontoffice"]["register_placeholder_password"])); ?>" required="">
                            </div>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class="form-input">
                                <label for="register-repeat"><?php echo e(ucfirst($translations["frontoffice"]["register_fill_repeat_password"])); ?> *</label>
                                <input id="register-repeat" class="form-control" type="password" name="repeat-password" placeholder="<?php echo e(ucfirst($translations["frontoffice"]["register_placeholder_repeat_password"])); ?>" required="">
                            </div>
						</div>
					</div>
					
					<div class="form-footer">
						<div class="col-md-12">
							<div class="custom-control custom-checkbox"> 
                                <input type="checkbox" class="custom-control-input" id="register-policy" required> 
                                <label class="custom-control-label" for="register-policy">
                                    Eu concordo com a <a href="/<?php echo e($selected_language->code); ?>/terms">Política de Privacidade</a> *
                                </label> 
                            </div>
						</div>
						<br><br> 
						<div class="col-md-12 mt-3"> 
                            <button type="submit" class="btn btn-outline-primary-2"> 
                                <span><?php echo e(ucfirst($translations["frontoffice"]["register_button"])); ?></span> 
                                <i class="icon-long-arrow-right"></i> 
                            </button> 
                        </div>
					</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/auth/forms.blade.php ENDPATH**/ ?>