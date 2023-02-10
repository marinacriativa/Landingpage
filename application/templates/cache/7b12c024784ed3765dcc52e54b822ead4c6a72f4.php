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
				<section class="promo-primary promo-primary--shop">
					<picture>
						<source srcset="/public/static/images/banner/banner1.jpg" media="(min-width: 992px)"/><img class="img--bg" src="/public/static/images/banner/banner1.jpg" alt="img"/>
					</picture>
					<div class="promo-primary__description"> <span>Freedom</span></div>
					<div class="container">
						<div class="row">
							<div class="col-auto">
								<div class="align-container">
									<div class="align-container__item"><span class="promo-primary__pre-title">Coliworld</span>
										<h1 class="promo-primary__title"><span>Shop</span> <span>Checkout</span></h1>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				<section class="section background--brown">
					<div class="container">
						<div class="row">
							<div class="col-12">
								<form class="form checkout-form" action="javascript:void(0);">
									<div class="row">
										<div class="col-lg-7 col-xl-8">
											<div class="form__fieldset">
												<h6 class="form__title">Shipping Address</h6>
												<div class="row offset-30">
													<div class="col-lg-6">
														<input class="form__field" type="text" name="first-name" placeholder="First Name *"/>
													</div>
													<div class="col-lg-6">
														<input class="form__field" type="text" name="last-name" placeholder="Last Name *"/>
													</div>
													<div class="col-lg-6">
														<input class="form__field" type="email" name="email" placeholder="Email"/>
													</div>
													<div class="col-lg-6">
														<input class="form__field" type="tel" name="phone-number" placeholder="Phone *"/>
													</div>
													<div class="col-12">
														<input class="form__field" type="text" name="adress" placeholder="Adress Line 1 *"/>
													</div>
													<div class="col-lg-6">
														<select class="form__select" name="state-select">
															<option value="value">State</option>
															<option value="value2">Value 2</option>
															<option value="value3">Value 3</option>
															<option value="value4">Value 4</option>
															<option value="value5">Value 5</option>
														</select>
													</div>
													<div class="col-lg-6">
														<select class="form__select" name="country-select">
															<option value="value">Country</option>
															<option value="value2">Value 2</option>
															<option value="value3">Value 3</option>
															<option value="value4">Value 4</option>
															<option value="value5">Value 5</option>
														</select>
													</div>
													<div class="col-lg-6">
														<input class="form__field" type="text" name="city" placeholder="City *"/>
													</div>
													<div class="col-lg-6">
														<input class="form__field" type="text" name="zip" placeholder="Zip *"/>
													</div>
													<div class="col-12">
														<textarea class="form__field form__message" name="message" placeholder="Comment"></textarea>
													</div>
												</div>
											</div>
											<div class="form__fieldset">
												<h6 class="form__title">Shipping Method</h6>
												<div class="row offset-30">
													<div class="col-12">
														<select class="form__select" name="shipping-select">
															<option value="value">Choose shipping method</option>
															<option value="value2">Value 2</option>
															<option value="value3">Value 3</option>
															<option value="value4">Value 4</option>
															<option value="value5">Value 5</option>
														</select>
													</div>
												</div>
											</div>
											<div class="form__fieldset">
												<h6 class="form__title">Payment Method</h6>
												<div class="row offset-30">
													<div class="col-12 margin-30">
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
													<div class="col-lg-6">
														<input class="form__field" type="text" name="first-name" placeholder="First Name *"/>
													</div>
													<div class="col-lg-6">
														<input class="form__field" type="text" name="last-name" placeholder="Last Name *"/>
													</div>
													<div class="col-lg-4">
														<select class="form__select" name="month-select">
															<option value="value">MM</option>
															<option value="value2">Value 2</option>
															<option value="value3">Value 3</option>
															<option value="value4">Value 4</option>
															<option value="value5">Value 5</option>
														</select>
													</div>
													<div class="col-lg-4">
														<select class="form__select" name="year-select">
															<option value="value">YY</option>
															<option value="value2">Value 2</option>
															<option value="value3">Value 3</option>
															<option value="value4">Value 4</option>
															<option value="value5">Value 5</option>
														</select>
													</div>
													<div class="col-lg-4">
														<input class="form__field" type="text" name="cvv" placeholder="CVV"/>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-5 col-xl-4">
											<div class="form__fieldset">
												<h6 class="form__title">Order Summary</h6>
												<div class="order-item">
													<div class="row no-gutters align-items-center">
														<div class="col-4 col-sm-3 col-md-2 col-lg-4">
															<div class="order-item__img"><img class="img--contain" src="/public/static/images/products/causes_16.jpg" alt="img"/></div>
														</div>
														<div class="col-4 col-sm-5 col-md-6 col-lg-4">
															<div class="order-item__description"><a class="order-item__link" href="#">Pen 16GB</a><span class="order-item__count">$15.00 x 1</span></div>
														</div>
														<div class="col-3 text-center"><span class="order-item__price">$15.00</span></div>
														<div class="col-1 text-right"><span class="order-item__remove">
															<svg class="icon">
																<use xlink:href="#remove"></use>
															</svg></span></div>
													</div>
												</div>
												<div class="order-item">
													<div class="row no-gutters align-items-center">
														<div class="col-4 col-sm-3 col-md-2 col-lg-4">
															<div class="order-item__img"><img class="img--contain" src="/public/static/images/products/causes_13.jpg" alt="img"/></div>
														</div>
														<div class="col-4 col-sm-5 col-md-6 col-lg-4">
															<div class="order-item__description"><a class="order-item__link" href="#">Make up case</a><span class="order-item__count">$15.00 x 1</span></div>
														</div>
														<div class="col-3 text-center"><span class="order-item__price">$15.00</span></div>
														<div class="col-1 text-right"><span class="order-item__remove">
															<svg class="icon">
																<use xlink:href="#remove"></use>
															</svg></span></div>
													</div>
												</div>
												<div class="order-item">
													<div class="row no-gutters align-items-center">
														<div class="col-4 col-sm-3 col-md-2 col-lg-4">
															<div class="order-item__img"><img class="img--contain" src="/public/static/images/products/causes_4.jpg" alt="img"/></div>
														</div>
														<div class="col-4 col-sm-5 col-md-6 col-lg-4">
															<div class="order-item__description"><a class="order-item__link" href="#">Mousepad</a><span class="order-item__count">$25.00 x 1</span></div>
														</div>
														<div class="col-3 text-center"><span class="order-item__price">$25.00</span></div>
														<div class="col-1 text-right"><span class="order-item__remove">
															<svg class="icon">
																<use xlink:href="#remove"></use>
															</svg></span>
														</div>
													<div class="col-12">
														<h6 class="form__title col-lg-12 entitie">Choose Where The Purchase Goes</h6>
														<select class="form__select" name="shipping-select">
															<option value="value2">Adoption of animals</option>
															<option value="value3">Sustainability Projects</option>
															<option value="value4">Entities that protect animals</option>
															<option value="value5">Coliworld Products</option>
														</select>
													</div>
													</div>
												</div>
											</div>
											<div class="form__fieldset">
												<div class="row offset-30">
													<h6 class="form__title col-lg-12">Choose Your Donation Amount</h6>
													<div class="col-lg-12 currency-wrap">
														<span class="currency-code">€</span>
														<input class="form__field marg_don text-currency" type="number" placeholder="Donate">
													</div>
												</div>
											</div>
											<div class="form__fieldset">
												<div class="cart-totals">
													<h6 class="form__title">Cart Totals</h6>
													<ul class="cart-totals__list">
														<li><span>Subtotal:</span><span>$ 55.00</span></li>
														<li><span>Sale:</span><span>$ 10.00</span></li>
														<li><span>Donation:</span><span>$ 100.00</span></li>
														<li><span>Total:</span><span>$ 145.00</span></li>
													</ul>
													<button class="form__submit" type="submit">Checkout</button>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</section>
				<section class="bottom-background background--brown">
					<div class="container">
						<div class="row">
							<div class="col-12">
								<div class="bottom-background__img"><img src="/public/static/images/bottom-bg.png" alt="img"/></div>
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/checkout_html.blade.php ENDPATH**/ ?>