
<?php $__env->startSection('title', 'produtos'); ?>
<?php $__env->startSection('content'); ?>
<main class="main">
	<section class="promo-primary promo-primary--shop">
		<picture>
			<source srcset="/public/static/images/shop.jpg" media="(min-width: 992px)"/><img class="img--bg" src="/public/static/images/shop.jpg" alt="img"/>
		</picture>
		<div class="promo-primary__description"> <span>Register</span></div>
		<div class="container">
			<div class="row">
				<div class="col-auto">
					<div class="align-container">
						<div class="align-container__item"><span class="promo-primary__pre-title">Coliworld</span>
							<h1 class="promo-primary__title"><span>Your</span> <span>Account</span></h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- section start-->
	<section class="section background--brown">
		<div class="container">
			<div class="row offset-margin">
				<div class="col-md-8 offset-md-2 col-lg-6 offset-lg-0 col-xl-4 margin-bottom">
					<form class="form account-form sign-in-form" action="javascript:void(0);">
						<div class="form__fieldset">
							<h6 class="form__title">Sign In</h6>
							<div class="row">
								<div class="col-12">
									<input class="form__field" type="text" name="username" placeholder="Username"/>
									<input class="form__field" type="password" name="password" placeholder="Password"/>
								</div>
								<div class="col-12 d-flex align-items-end justify-content-between flex-wrap">
									<label class="form__checkbox-label"><span class="form__label-text">Remember me</span>
										<input class="form__input-checkbox" type="checkbox" name="size-select" value="Size XXL" checked="checked"/><span class="form__checkbox-mask"></span>
									</label><a class="form__link" href="#">I forgot my password</a>
								</div>
								<div class="col-12 text-center">
									<button class="form__submit" type="submit">Sign In</button>
								</div>
								<div class="col-12 text-center"><strong><a class="form__link" href="#">Sign up</a> if you don’t have an account</strong></div>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-8 offset-md-2 col-lg-6 offset-lg-0 col-xl-4 margin-bottom">
					<form class="form account-form sign-up-form" action="javascript:void(0);">
						<div class="form__fieldset">
							<h6 class="form__title">Sign Up</h6>
							<div class="row">
								<div class="col-12">
									<input class="form__field" type="text" name="fullname" placeholder="Full Name"/>
									<input class="form__field" type="email" name="email" placeholder="Email"/>
									<input class="form__field" type="password" name="password" placeholder="Password"/>
									<input class="form__field" type="password" name="confirm-password" placeholder="Confirm Password"/>
								</div>
								<div class="col-12"><strong>I agree with <a class="form__link" href="#">Term of Services</a></strong></div>
								<div class="col-12 text-center">
									<button class="form__submit" type="submit">Sign Up</button>
								</div>
								<div class="col-12 text-center"><strong><a class="form__link" href="#">Sign in</a> if you an account</strong></div>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-8 offset-md-2 col-lg-6 offset-lg-0 col-xl-4 margin-bottom">
					<form class="form account-form password-form" action="javascript:void(0);">
						<div class="form__fieldset">
							<h6 class="form__title">Sign Up</h6>
							<div class="row">
								<div class="col-12">
									<input class="form__field" type="email" name="email" placeholder="Email"/>
								</div>
								<div class="col-12"><a class="form__link" href="#">Didn’t get email?</a></div>
								<div class="col-12 text-center">
									<button class="form__submit" type="submit">Submit</button>
								</div>
								<div class="col-12 text-center"><strong>Back to <a class="form__link" href="#">Sign in</a></strong></div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	<!-- section end-->
	<!-- bottom bg start-->
	<section class="bottom-background background--brown">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bottom-background__img"><img src="/public/static/images/bottom-bg.png" alt="img"/></div>
				</div>
			</div>
		</div>
	</section>
	<!-- bottom bg end-->
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/register_html.blade.php ENDPATH**/ ?>