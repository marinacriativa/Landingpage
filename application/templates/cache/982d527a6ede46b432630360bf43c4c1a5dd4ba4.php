
<?php $__env->startSection('title', 'produtos'); ?>
<?php $__env->startSection('content'); ?>
<style>
	.align-items-center {padding: 30px;}
	.promo-slider__button {font-size: 12px;padding: 10px 19px 10px 19px;}
</style>
<main class="main">
	<section class="promo-primary promo-primary--shop">
		<picture>
			<source srcset="/public/static/images/banner/dog.jpg" media="(min-width: 992px)"/><img class="img--bg" src="/public/static/images/shop.jpg" alt="img"/>
		</picture>
		<div class="promo-primary__description"> <span><?php echo e(ucfirst($translations["frontoffice"]["service_detail_banner_description"])); ?></span></div>
		<div class="container">
			<div class="row">
				<div class="col-auto">
					<div class="align-container">
						<div class="align-container__item"><span class="promo-primary__pre-title">Coliworld</span>
							<h1 class="promo-primary__title"><span>SADO - Learning from its species</span></h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- shop start-->
	<section class="section">
		<div class="container">
			<div class="upcoming-item__body">
				<div class="row">
					<div class="col-lg-5 col-xl-4">
						<div class="upcoming-item__img"><img class="img--bg" src="/public/static/images/banner/dog.jpg" alt="img"/></div>
					</div>
					<div class="col-lg-7 col-xl-8">
						<div class="upcoming-item__description">
							<h6 class="upcoming-item__title"><a href="/<?php echo e($selected_language->code); ?>/service_detail_html">SADO - Learning from its species</a></h6>
							<p>Inauguration of the first Scientific Illustration Exhibition and participate in a special mission related to nature protection. Inauguration of the first Scientific Illustration Exhibition and participate in a special mission related to nature protection. Inauguration of the first Scientific Illustration Exhibition and participate in a special mission related to nature protection.<br>Inauguration of the first Scientific Illustration Exhibition and participate in a special mission related to nature protection.</p>
							<div class="upcoming-item__details">
								<p>
									<svg class="icon">
										<use xlink:href="#clock"></use>
									</svg> <strong>July 16,</strong> 15:30 PM - <strong>August 20,</strong> 18:00 PM
								</p>
								<p>
									<svg class="icon">
										<use xlink:href="#placeholder"></use>
									</svg> <strong>Oceanographic Museum of Portinho da Arrábida,</strong> Portugal
								</p>
								<a class="button promo-slider__button button--primary" href="#" tabindex="0" style="float:right">Inscribe</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/service_detail_html.blade.php ENDPATH**/ ?>