<?php 
$logged = false;
$total	= 0;
if ($user !== null) {
$logged = true;
}
?>

<?php $__env->startSection('title', 'Checkout'); ?>
<?php $__env->startSection('content'); ?>
<main class="main">
	<section class="promo-primary">
		<picture>
			<source srcset="/public/static/images/cause_details.jpg" media="(min-width: 992px)"/><img class="img--bg" src="/public/static/images/blog_2.png" alt="img"/>
		</picture>
		<div class="promo-primary__description"> <span  style="font-size: 10rem;">Events and Formations</span></div>
		<div class="container">
			<div class="row">
				<div class="col-auto">
					<div class="align-container">
						<div class="align-container__item"><span class="promo-primary__pre-title">Coliworld</span>
							<h1 class="promo-primary__title"><span>Design</span> <span>Illustration</span></h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- donation start-->
	<section class="section donation"><img class="donation__bg" src="/public/static/images/donation_img.png" alt="img"/>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="donation-item">
						<div class="donation-item__body">
							<div class="row">
								<div class="col-6 col-xs-12">
									<img class=" w-100" src="/public/static/images/blog_2.png" alt="img"/>
								</div>
								<div class="col-6 col-xs-12">
									<h5 class="donation-item__title">Ilustration Design</h5>
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. 
									<br>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
									<div class="upcoming-item__details">
										<p>
											<svg class="icon">
												<use xlink:href="#clock"></use>
											</svg> <strong>July 16,</strong> 15:30 PM - <strong>November 20,</strong> 18:00 PM
										</p>
										<p>
											<svg class="icon">
												<use xlink:href="#placeholder"></use>
											</svg> <strong>Oceanographic Museum,</strong> Portugal
										</p>
									</div>
									
								</div>
							
						 
								
							<div class="col-12">
								<form class="form donation-form" action="javascript:void(0);">
									
									<div class="row">
										<div class="col-12">
											<h6 class="form__title">Personal Info</h6>
										</div>
										<div class="col-lg-6 margin-30">
											<input class="form__field" type="text" name="first-name" placeholder="First Name"/>
										</div>
										<div class="col-lg-6 margin-30">
											<input class="form__field" type="text" name="last-name" placeholder="Last Name"/>
										</div>
										<div class="col-lg-8 margin-30">
											<input class="form__field" type="email" name="email" placeholder="Email"/>
										</div>
										<div class="col-lg-4 margin-30">
											<label class="form__label"><span class="form__icon">$</span>
												<input class="form__field form__input-number" type="number" placeholder="10$"/>
											</label>
										</div>
									</div>
									<div class="row margin-bottom">
										<div class="col-12">
											<h6 class="form__title">Payment Method</h6>
										</div>
										<div class="col-12">
											<label class="form__radio-label"><img class="form__label-img" src="/public/static/images/paypal.png" alt="paypal"/>
												<input class="form__input-radio" type="radio" name="method-select" value="paypal" checked="checked"/><span class="form__radio-mask form__radio-mask"></span>
											</label>
											<label class="form__radio-label"><img class="form__label-img" src="/public/static/images/klarna.png" alt="klarna"/>
												<input class="form__input-radio" type="radio" name="method-select" value="klarna"/><span class="form__radio-mask form__radio-mask"></span>
											</label>
											<label class="form__radio-label"><img class="form__label-img" src="/public/static/images/visa.png" alt="visa"/>
												<input class="form__input-radio" type="radio" name="method-select" value="visa"/><span class="form__radio-mask form__radio-mask"></span>
											</label>
										</div>
									</div>
									<div class="row">
										
										<div class="col-lg-4">
											<button class="form__submit" type="submit">+ Donate</button>
										</div>
									</div>
									
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("scripts"); ?>
<script>

	$("#checkout-diff-address").on("change", function() {

		if (this.checked) {

			$("#otherCheckoutDetails").slideUp();
		} else {
			$("#otherCheckoutDetails").slideDown();
		}
		
	});

	//Evento onClick no body, quando o click for num elemento com a classe "buttonDeleteAdvancedProduct" (elemina atributo do HTML e do arrayAttributes)
	$("body").on("click", '.quantity', function () {
	
		let id = $(this).closest(".quantity-add").data("id")
		let quantity = $(`.input-qty-${id}`).val()
		let data = {
			'quantity': quantity
		}
		changeQuantity(id, data)
	});
	
	$("body").on("click",".remove-item", function (e) {
	
		e.preventDefault();
	
		let id = $(this).data("id")
		remove(id)
	
	})
	
	function remove(id) {
		$.ajax({
			url: "/cart/" + id,
			type: "DELETE",
			success: function (response) {
	
				if (!response.success) {
	
					// Output do erro
					console.error(response);
	
					// Não deixar a função executar mais
					return;
				}
	
				location.reload()
	
			},
			error: function (jqXHR, textStatus, errorThrown) {
	
				console.log(textStatus, errorThrown);
			}
		});
	}
	
	function changeQuantity(id, data) {
		$.ajax({
			url: "/quantity/" + id,
			data: data,
			type: "POST",
			dataType: "json",
			success: function (response) {
	
				if (!response.success) {
	
					// Output do erro
					console.error(response);
	
					// Não deixar a função executar mais
					return;
				}
				location.reload()
			},
			error: function (jqXHR, textStatus, errorThrown) {
	
				console.log(textStatus, errorThrown);
			}
		});
	}
</script>
<script>
	const round = (n, dp = 2) => {
			const h = +('1'.padEnd(dp + 1, '0'))
			return Math.round(n * h) / h
		}
	
		var total 	= round("<?php echo e($total); ?>", 2);
		var tax 	= round("<?php echo e($settings->tax); ?>", 2);
		
		String.prototype.countDecimals = function () {
			
			if (Math.floor(this.valueOf()) === this.valueOf()) return 0;
			return this.toString().split(".")[1].length || 0; 
		}

		Number.prototype.countDecimals = function () {
			
			if (Math.floor(this.valueOf()) === this.valueOf()) return 0;
			return this.toString().split(".")[1].length || 0; 
		}
	
		$('input[type=radio][name=shipping]').change(function() {
	
			let shipping_price 	= round($(this).data("price"), 2);
			let final_total 	= round(total + shipping_price);
	
			console.log(total, shipping_price);
	
			if (final_total.countDecimals() == 1) {
	
				final_total = String(final_total) + "0";
			}
	
			if (tax != 0) {
	
				let final_tax		= round((final_total / 100) * tax, 2);
					final_total		= round(final_total + final_tax, 2);
	
				if (final_tax.countDecimals() == 1) {
	
					final_tax = String(final_tax) + "0";
				}
	
				let formatted_tax	= String(final_tax).replace(".", ",");
	
				$("#tax").text(formatted_tax + "€");
			}
	
			let formatted_total = String(final_total).replace(".", ",");
	
			console.log(final_total);
			if (final_total.countDecimals() == 1) {
	
				final_total = String(final_total) + "0";
			}
	
			if (shipping_price.countDecimals() == 1) {
	
				shipping_price = String(shipping_price) + "0";
			}
	
			$("#shipping").text((shipping_price) + "€");
			$("#total").text((formatted_total) + "€");
		});
	
		$("#form-checkout").on("submit", function () {
			$("#divSpinner").removeClass("hide")
		})
	
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/checkout_service_html.blade.php ENDPATH**/ ?>