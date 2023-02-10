
<?php 
$logged = false;
$total	= 0;
if ($user !== null) {
$logged = true;
}

$total_discount 	= 0;
$type_discount  	= 0;
$apply_discount  	= 0;
$text_type 			= '';
$products_ids 		= [];
?>

<?php $__env->startSection('title', 'Checkout'); ?>
<?php $__env->startSection('content'); ?>
<style>
	.bg-f9{
	background-color: #f9f9f9;
	}
	.bg-tr{
	background-color: transparent;
	}
</style>
<div id="divSpinner" class="hide">
	<div class="spinner"></div>
</div>
<main class="main">
	<div class="page-header text-center" style="background-image: url('/public/static/images/newsletter-bg.jpg')">
		<div class="container">
			<h1 class="page-title"><?php echo e(ucfirst($translations["frontoffice"]["cart_checkout"])); ?><span><?php echo e(ucfirst($translations["frontoffice"]["mini_cart_checkout"])); ?> <?php echo e(ucfirst($translations["frontoffice"]["list_orders_fill_number"])); ?></span></h1>
		</div>
	</div>
	<nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/<?php echo e($selected_language->code); ?>"><?php echo e(ucfirst($translations["frontoffice"]["home"])); ?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php echo e(ucfirst($translations["frontoffice"]["cart_checkout"])); ?></li>
			</ol>
		</div>
	</nav>
	<form id="form-checkout" class="billing-box" action="/checkout" method="POST">
		<div class="container">
			<div class="row">
				<aside class="col-lg-8">
					<div class="row">
						<div class="col-lg-12 client-col">
							<h2 >As suas Informações</h2>
							<div class="row">
								<div class="col-sm-12">
									<label>Nome*</label>								
									<input type="text" name="customer_name" placeholder="O seu nome" class="form-control" value="<?php if($logged): ?><?php echo e($user['name']); ?><?php endif; ?>" required>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<label>Contacto*</label>
									<input type="tel" name="customer_phone" value="<?php if($logged): ?><?php echo e($user['phone']); ?><?php endif; ?>" name="customer_phone" placeholder="910 000 000"  class="form-control" required>
								</div>
								<div class="col-sm-6">
									<label>Email*</label>
									<input type="email" name="customer_email" value="<?php if($logged): ?><?php echo e($user['email']); ?><?php endif; ?>"  placeholder="O seu email" class="form-control" required>
								</div>
							</div>
							<label>Morada Completa *</label>
							<input type="text" class="form-control" name="customer_address" value="<?php if($logged): ?><?php echo e($user['address']); ?><?php endif; ?>" placeholder="Rua, Travessa, Avenida..." required>
							<div class="row">
								<div class="col-sm-6">
									<label>Cidade *</label>
									<input type="text" value="<?php if($logged): ?><?php echo e($user['city']); ?><?php endif; ?>" name="customer_city" placeholder="Cidade" class="form-control" required>
								</div>
								<div class="col-sm-2">
									<label>Código Postal *</label>
									<input value="<?php if($logged): ?><?php echo e($user['zipCode']); ?><?php endif; ?>" name="customer_zip"  placeholder="0000-000" type="text" class="form-control" required>
								</div>
								<div class="col-sm-4">
									<label>País *</label>
									<select class="form-control" name="customer_country" required>
										<option value="">Selecione um país</option>
										<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option <?php if($logged && $country->country_code == $user['country']): ?> selected <?php endif; ?> value="<?php echo e($country->country_code); ?>"><?php echo e($country->country_name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div>
							</div>
						</div>
						
						<div class="col-12">
							<label>Observações (opcional)</label>
							<textarea class="form-control" name="order_note" cols="30" rows="4" placeholder="Notas sobre a sua encomenda"></textarea>
						</div>
					</div>
					<div class="row mb-3 mt-3">
						<div class="col-lg-12">
							<strong>Dados Faturação (opcional)</strong>
							<div class="custom-control custom-checkbox">
								<input checked type="checkbox" class="custom-control-input" id="checkout-diff-address">
								<label class="custom-control-label" for="checkout-diff-address">Os mesmos dados cliente.</label>
							</div>
							<div id="otherCheckoutDetails" style="display:none">
								<div class="row">
									<div class="col-sm-12">
										<label>Nome completo *</label>
										<input name="billing_name" type="text" class="form-control">
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<label>NIF *</label>
										<input name="billing_nif" type="text" value="" class="form-control">
									</div>
									<div class="col-sm-6">
										<label>Contacto*</label>
										<input name="billing_phone" type="tel" class="form-control">
									</div>
								</div>
								<label>Morada Completa *</label>
								<input type="text" class="form-control" name="billing_address" value="" placeholder="Rua, Travessa, Avenida..." >
								<div class="row">
									<div class="col-sm-6">
										<label>Cidade *</label>
										<input type="text" value="" name="billing_city" placeholder="Cidade" class="form-control">
									</div>
									


									<div class="col-sm-4">
										<label>País *</label>
										<select class="form-control" name="billing_country">
											<option value="">Selecione um país</option>
												<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option <?php if($logged && $country->country_code == $user["country"]): ?> selected <?php endif; ?> value="<?php echo e($country->country_code); ?>"><?php echo e($country->country_name); ?></option>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>
									</div>
								</div>
							</div>							
						</div>
					</div>
					<div class="summary col-12 bg-tr">
						<h2 class="summary-title">Resumo da Encomenda</h2>
						<table class="table table-cart table-mobile">
							<thead>
								<tr>
									<th>Produto</th>
									<th>Preço</th>
									<th>Quantidade</th>
									<th>Total</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php
								if ($item['product']->type == 1) {
								$local_total = ($item['quantity'] * $item['advanced']->current_price);
								$total += ($item['quantity'] * $item['advanced']->current_price);
								$price  = $item['advanced']->current_price;
								} else {
								$local_total = ($item['quantity'] * $item['product']->price);
								$total += ($item['quantity'] * $item['product']->price);								
								$price  = $item['product']->price;
								}
								$products_ids[] = $item['product']->id;
								?>
								<tr>
									<?php if(isset($item['advanced'])): ?>
										<?php if(isset($item['advanced'])): ?> 
											<?php $__currentLoopData = $item['advanced']->gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
												<?php if(!empty($gallery)): ?>	
													<?php												
														$item['advanced']->photo =  $gallery->path;
														break;
													?>										
												<?php endif; ?>										
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
										<td class="product-col">
											<div class="product">
												<figure class="product-media">
													<a  href="/<?php echo e($selected_language->code); ?>/products/<?php echo e($item['product']->slug); ?>">
													<?php if(!empty($item['advanced']->photo)): ?>
														<img src="<?php echo e($item['advanced']->photo); ?>" alt="<?php echo e($item['advanced']->name); ?> ">
													<?php endif; ?>
													</a>
												</figure>
												<h3 class="product-title">
													<a href="/<?php echo e($selected_language->code); ?>/products/<?php echo e($item['product']->slug); ?>" ><?php echo e($item['advanced']->name); ?></a>
												</h3>
											</div>
										</td>
										<td class="price-col"><?php echo e(number_format((float) $price, 2, ',', '')); ?>€</td>
										<td class="quantity-col">
											<div class="cart-product-quantity quantity-add quantity" data-advanced="<?php echo e($item['advanced']->id); ?>" data-id="<?php echo e($item['id']); ?>">
												<input onchange="saveinputs()" name="quantity" type="number" class="quantity-number input-qty-<?php echo e($item['advanced']->id); ?>" value="<?php echo e($item['advanced']->quantity); ?>" min="1" max="<?php echo e($item['advanced']->stock); ?>" step="1" data-decimals="0" required>
											</div>
										</td>
										<td class="total-col"><?php echo e(number_format((float) $local_total, 2, ',', '')); ?>€</td>
										<td class="remove-col"><button class="btn-remove remove-item-advanced" data-id="<?php echo e($item['advanced']->id); ?>"><i class="icon-close"></i></button></td>
									<?php else: ?>									
										<td class="product-col">
											<div class="product">
												<figure class="product-media">
													<a  href="/<?php echo e($selected_language->code); ?>/products/<?php echo e($item['product']->slug); ?>">
													<img src="<?php echo e($item['product']->photo); ?>" alt="<?php echo e($item['product']->name); ?>">
													</a>
												</figure>
												<h3 class="product-title">
													<a href="/<?php echo e($selected_language->code); ?>/products/<?php echo e($item['product']->slug); ?>" ><?php echo e($item['product']->name); ?></a>
												</h3>
											</div>
										</td>
										<td class="price-col"><?php echo e(number_format((float) $price, 2, ',', '')); ?>€</td>
										<td class="quantity-col">
											<div class="cart-product-quantity quantity-add quantity" data-id="<?php echo e($item['id']); ?>">
												<input onchange="saveinputs()" name="quantity" type="number" class="quantity-number input-qty-<?php echo e($item['id']); ?>" value="<?php echo e($item['quantity']); ?>" min="1" max="<?php echo e($item['product']->stock); ?>" step="1" data-decimals="0" required>
											</div>
										</td>
										<td class="total-col"><?php echo e(number_format((float) $local_total, 2, ',', '')); ?>€</td>
										<td class="remove-col"><button class="btn-remove remove-item" data-id="<?php echo e($item['id']); ?>"><i class="icon-close"></i></button></td>
									<?php endif; ?>
								</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>
							<tbody>
								<tr>
									<td class="product-col"></td>
									<td class="quantity-col"></td>
									<td class="price-col">Subtotal</td>
									<td class="total-col"><?php echo e(number_format((float) $total, 2, ',', '')); ?>€</td>
									<td class="remove-col"></td>
									<?php
										$subtotal = $total;
									?>
								</tr>
							</tbody>
						</table>
					</div>
					</table>
				</aside>
				<aside class="col-lg-4">
					<div class="summary">
						<table class="table table-summary">
							<h3 class="summary-title">Opções de envio</h3>
							<tbody>
								<?php $__currentLoopData = $shipping; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php
								$original_price = $method->price;
								if (empty($method->price)) {
								$method->price = "grátis";
								} else {
								$method->price = number_format((float) $method->price, 2, ',', '')  . "€";
								}
								?>
								<tr class="summary-shipping-row">
									<td>
										<?php if($subtotal < $method->price_limit): ?>
											<input data-name="<?php echo e($method->title); ?>" data-price="<?php echo e($original_price); ?>" type="radio" name="shipping" value="<?php echo e($method->id); ?>" disabled>
										<?php else: ?>
											<input data-name="<?php echo e($method->title); ?>" data-price="<?php echo e($original_price); ?>" type="radio" required name="shipping" value="<?php echo e($method->id); ?>">
										<?php endif; ?>
										<label><?php echo e($method->title); ?></label>
										<p><?php echo e($method->subtitle); ?></p>
									</td>
									<td><?php echo e($method->price); ?></td>
								</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>
						</table>
						<div class="table-summary" >
							<table class="table table-summary">
								<br>
								<h3 class="summary-title">CUPÃO</h3>
								<tbody>
									<?php
										$ids_products = implode(",", $products_ids);
									?>
									<tr class="summary-subtotal">
										<td>Código:</td> 
										<td><input class='form-control' type="text" id="coupon_ipt"></td> 
										<td><input class='form-control' type="hidden" id="products_ids" value="<?php echo e($ids_products); ?>"></td> 
										<td><button class='form-control' id="coupon_btn" type="button">Aplicar</button></td>
									</tr>									
									<?php $__currentLoopData = $coupon; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>													
										<?php 
											$total_discount += $cp['coupon']->discount;
											switch($cp['coupon']->type){
												case 0:
													$type_discount = 0;
													break;
												default:
													$type_discount = 1;													
													break;	
											}

											switch($cp['coupon']->apply_discount){
												case 0:
													$text_type = '(Valor dos Produtos + Frete)';
													$apply_discount = 0;
													break;
												case 1:
													$text_type = '(Somente nos Produtos)';
													$apply_discount = 1;
													break;
												case 2:
													$text_type = '(Somente no Frete)';
													$apply_discount = 2;
													break;	
											}											
										?>	
										<tr id="all-coupons">
											<td><?php echo e($cp['code']); ?></td>
											<td></td>
											<td><?php echo e(number_format((float) $cp['coupon']->discount, 2, ',', '')); ?><?php if($type_discount == 0): ?>%<?php else: ?>€<?php endif; ?></td>
											<td><button class='form-control' onClick="removeCoupon('<?php echo e($cp['code']); ?>')">x</button></td>		
											<input type="hidden" name="coupon_code" 	value="<?php echo e($cp['code']); ?>">	
											<input type="hidden" name="coupon_discount" value="<?php echo e($cp['coupon']->discount); ?>">	
										</tr>		
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>									
								</tbody>
							</table>
						</div>
						<div class="table-summary" >
							<table class="table table-summary">
								<br>
								<h3 class="summary-title">Totais</h3>
								<tbody>
									<tr class="summary-subtotal">
										<td>Subtotal:</td>
										<td><?php echo e(number_format((float) $total, 2, ',', '')); ?>€</td>
									</tr>
									<tr class="summary-subtotal">
										<td>Portes:</td>
										<td id="shipping">Selecione um método</td>
									</tr>
									<tr class="summary-subtotal">
										<td>Desconto: <p style="font-size: 13px;"><?php echo e($text_type); ?></p></td>
										<td id="discount_cp">Utilize um coupon</td>
									</tr>
									<?php if($settings->tax != 0): ?>
									<?php 
									$tax = ($total / 100) * $settings->tax;
									$total_formatted = $total + $tax;
									?>
									<tr>
										<td>Taxas <?php echo e($settings->tax); ?>%</td>
										<td id="tax"><?php echo e(number_format((float) $tax, 2, ',', '')); ?>€</td>
									</tr>
									<?php else: ?> 
									<?php 
									$total_formatted = $total;
									?>
									<?php endif; ?>
									<tr class="summary-total">
										<td>Total da encomenda:</td>
										<td id="total"><?php echo e(number_format((float) $total_formatted, 2, ',', '')); ?>€</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="accordion-summary" id="accordion-payment">
							<br>
							<h3 class="summary-title">Opcões de Pagamento</h3>
							<ul class="pay-list">
								<?php $__currentLoopData = $payment_gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gateway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<li>
									<input type="radio" required name="method" value="<?php echo e($gateway->id); ?>">
									<label><?php echo e($gateway->name); ?></label>
								</li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						</div>
						<div class="row pb-2">
                            <div class="col-xs-12 col-md-12 mt-2" >
                                <div class="input-field checkb" style="display: inline-flex;" >
                                    <input type="checkbox" id="terms" name="terms" value="terms" required="" style="padding-bottom: 0px">
                                    <label class="ml-2" for="terms">Li e concordo com os Termos e Condições. * </label><br>
									<a class="ttn small" href="/pt/terms" target="_blank" style="float: right;">Consulte aqui »</a>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12 mt-2">
                                <div class="input-field checkb" style="display: inline-flex;">
                                    <input type="checkbox" id="privacy" name="privacy" value="privacy" required="">
                                    <label class="ml-2" for="privacy">Li e concordo com a Política de Privacidade.  * </label>&nbsp;&nbsp;<a class="ttn small" href="/pt/terms" target="_blank" style="float: right;">Consulte aqui »</a>
                                </div>
                            </div>
                        </div>
						<button type="submit" class="btn btn-outline-primary-2 btn-block">
						<span class="btn-text">Concluir Checkout</span>
						<span class="btn-hover-text">Concluir Checkout</span>
						</button>
					</div>					
				</aside>				
			</div>			
		</div>		
		</div>			
	</form>
	
</main>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("scripts"); ?>
<script>

	        document.addEventListener("DOMContentLoaded", function() {
            $('#checkout-diff-address').on('click',function(){
                if(this.checked){
                    $('[name="billing_name"]').prop('required', false);
                    $('[name="billing_nif"]').prop('required', false);
                    $('[name="billing_phone"]').prop('required', false);
                    $('[name="billing_address"]').prop('required', false);
                    $('[name="billing_city"]').prop('required', false);
					$('[name="billing_country"]').prop('required', false);

                }else{
                    $('[name="billing_name"]').prop('required', true);
                    $('[name="billing_nif"]').prop('required', true);
                    $('[name="billing_phone"]').prop('required', true);
                    $('[name="billing_address"]').prop('required', true);
                    $('[name="billing_city"]').prop('required', true);
					$('[name="billing_country"]').prop('required', true);
				}
            });
		});
	
	$(document).ready(function() {
		
		if(localStorage['formvalues0'] !== undefined)
		{
			$('[name="coupon_ipt"]').val(localStorage['formvalues0']);
			$('[name="customer_name"]').val(localStorage['formvalues1']);
			$('[name="customer_phone"]').val(localStorage['formvalues2']);
			$('[name="customer_email"]').val(localStorage['formvalues3']);
			$('[name="customer_address"]').val(localStorage['formvalues4']);
			$('[name="customer_city"]').val(localStorage['formvalues5']);
			$('[name="customer_zip"]').val(localStorage['formvalues6']);
			$('[name="customer_country"]').val(localStorage['formvalues7']);
			$('[name="order_note"]').val(localStorage['formvalues8']);

			$("input[value='" + localStorage['formvalues9'] + "']").prop('checked', true);
			$("input[value='" + localStorage['formvalues10'] + "']").prop('checked', true);
			$("input[value='" + localStorage['formvalues11'] + "']").prop('checked', true);
			$("input[value='" + localStorage['formvalues12'] + "']").prop('checked', true);
		}
	

	});

	$("#checkout-diff-address").on("change", function() {

		if (this.checked) {

			$("#otherCheckoutDetails").slideUp();
		} else {
			$("#otherCheckoutDetails").slideDown();
		}
		
	});
	
	//aplicar coupon
	document.getElementById('coupon_ipt').addEventListener('keyup', function(e){		
		if(e.which == 13) $('#coupon_btn').click();	
	});

	$("#coupon_btn").on("click", function () {
	
		let code = $(`#coupon_ipt`).val()
		let products_id = $(`#products_ids`).val()		
		addCoupon(code, products_id)

	});

	function error(msg) {
		alert(msg);
	}

	function addCoupon(code, products_id) {
		
		console.log(products_id);
		let data = {
			code: code,
			products_id: products_id,
			total: round("<?php echo e($total); ?>", 2)
		};

		if (data.code == undefined) {

			error("Por favor, insira o código do coupon.");
			return;
		}

		$.ajax({
			url: "/coupon",
			dataType: "json",
			type: "POST",
			data: data,
			dataType: "json",
			success: function (response) {

				if (!response.success) {

					// Output do erro
					console.error(response);

					error(response.message);

					// Deu erro, nao vamos executar mais
					return;
				}
				saveinputs()
				// adicionar coupon
				alert('Coupon adicionado com sucesso!');
				location.reload();
			},
			error: function (jqXHR, textStatus, errorThrown) {

				error('Ocorreu algum erro ao processar o pedido');
			}
		});
	}

	function removeCoupon(code) {
		$.ajax({
			url: "/coupon/" + code,
			type: "DELETE",
			success: function (response) {

				if (!response.success) {

					// Output do erro
					console.error(response);

					// Não deixar a função executar mais
					return;
				}
				saveinputs()
				location.reload()
			},
			error: function (jqXHR, textStatus, errorThrown) {

				console.log(textStatus, errorThrown);
			}
		});
	}

	//Evento onClick no body, quando o click for num elemento com a classe "buttonDeleteAdvancedProduct" (elemina atributo do HTML e do arrayAttributes)
	$("body").on("change", '.quantity', function (e) {

		let id = $(this).closest(".quantity-add").data("id")

		let id_advanced = $(this).closest(".quantity-add").data("advanced")



		if(id_advanced != undefined) {
			let quantity = $(`.input-qty-${id_advanced}`).val()					
			
			let cart_cookie = getCookie('cart');
			let idCookie = 0;
			if(cart_cookie != '[]' && cart_cookie != ''){
				let jsonCookie = JSON.parse(cart_cookie)
				$.each(jsonCookie, function(key, value) {
					if(value.personalization == id_advanced) {
						let data = {
							'quantity': quantity,
							'id_product': id
						}
						changeQuantityAdvanced(id_advanced, data)	                                                   
					}					                
				})     
			}

			return false;
		}

		let quantity = $(`.input-qty-${id}`).val()		

		let data = {
			'quantity': quantity
		}

		changeQuantity(id, data)
	});

	function changeQuantityAdvanced(id, data) {
		$.ajax({
			url: "/quantity/advanced/" + id,
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
	
	$("body").on("click",".remove-item", function (e) {

        saveinputs()


		e.preventDefault();

		let id = $(this).data("id")
		remove(id)


	});

	$("body").on("click",".remove-item-advanced", function (e) {

		e.preventDefault();

		let id = $(this).data("id")

		let cart_cookie = getCookie('cart');
		let idCookie = 0;
		if(cart_cookie != '[]' && cart_cookie != ''){
			let jsonCookie = JSON.parse(cart_cookie)
			$.each(jsonCookie, function(key, value) {
				if(value.personalization == id) {
					removeAdv(key)		                                                   
				}					                
			})     
		}

	})
	
	function saveinputs() {
            localStorage['formvalues0'] = $('[name="coupon_ipt"]').val();
	        localStorage['formvalues1'] = $('[name="customer_name"]').val();
			localStorage['formvalues2'] = $('[name="customer_phone"]').val();
			localStorage['formvalues3'] = $('[name="customer_email"]').val();
			localStorage['formvalues4'] = $('[name="customer_address"]').val();
			localStorage['formvalues5'] = $('[name="customer_city"]').val();
			localStorage['formvalues6'] = $('[name="customer_zip"]').val();
			localStorage['formvalues7'] = $('[name="customer_country"]').val();
			localStorage['formvalues8'] = $('[name="order_note"]').val();
		    localStorage['formvalues9'] = $('[name="shipping"]:checked').val();
			localStorage['formvalues10'] = $('[name="method"]:checked').val();
			localStorage['formvalues11'] = $('[name="terms"]:checked').val();
			localStorage['formvalues12'] = $('[name="privacy"]:checked').val();

	}

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
				
				let coupon = getCookie('coupon');
				if(coupon != '[]' && coupon != ''){
					let code = JSON.parse(coupon) //code[0].code
					removeCoupon(code[0].code)
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

				let coupon = getCookie('coupon');
				if(coupon != '[]' && coupon != ''){
					let code = JSON.parse(coupon) //code[0].code
					removeCoupon(code[0].code)
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
	

		


		$(document).ready(function(){	
			if($('[name="shipping"]:checked').length != 0) {
				$("#shipping").text((Number($('[name="shipping"]:checked').attr('data-price')).toFixed(2)) + "€");	
			}	
		});


		const round = (n, dp = 2) => {
			const h = +('1'.padEnd(dp + 1, '0'))
			return Math.round(n * h) / h
		}
	
		var total 			= round("<?php echo e($total); ?>", 2);
		var subtotal 		= round("<?php echo e($subtotal); ?>", 2);
		var tax 			= round("<?php echo e($settings->tax); ?>", 2);
		var discount_cp 	= round("<?php echo e($total_discount); ?>", 2);
		var type_discount 	= "<?php echo e($type_discount); ?>";
		var apply_discount 	= "<?php echo e($apply_discount); ?>";
		
		String.prototype.countDecimals = function () {
			
			if (Math.floor(this.valueOf()) === this.valueOf()) return 0;
			return this.toString().split(".")[1].length || 0; 
		}

		Number.prototype.countDecimals = function () {
			
			if (Math.floor(this.valueOf()) === this.valueOf()) return 0;
			return this.toString().split(".")[1].length || 0; 
		}

		
	
		$('input[type=radio][name=shipping]').change(function() {
	
			shipping_price 	= round($(this).data("price"), 2);
			let final_total 	= round(total + shipping_price, 2);			
			
			
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
	
			
			if (final_total.countDecimals() == 1) {
	
				final_total = String(final_total) + "0";
			}
			
			if (shipping_price.countDecimals() == 1) {
	
				shipping_price = String(shipping_price) + "0";
			}			
			$("#shipping").text((Number(shipping_price).toFixed(2)) + "€");
			$("#total").text((formatted_total) + "€");

			fill()
		});
	
		$("#form-checkout").on("submit", function () {

			$("#divSpinner").removeClass("hide")
		})

		$(window).ready(function() {
			$("#form-checkout").on("keypress", function (event) {
				var keyPressed = event.keyCode || event.which;
				if (keyPressed === 13) {
					event.preventDefault();
					return false;
				}
			});
        });
		
		function fill() {
			let shipping_price = $('input[type=radio][name=shipping]:checked').data('price') != null ? $('input[type=radio][name=shipping]:checked').data('price') : 0;
		
			if(discount_cp != 0) {

				let total_by_type 	= 0;			
				let total_value 	= 0;
				let final_total 	= 0;			

				switch (parseInt(apply_discount)) {					
					case 2:
						total_by_type = $("#shipping").text() == 'Selecione um método' ? 0 : shipping_price;
						break;
					case 1:
						total_by_type = subtotal;
						break;	
					default:
						total_by_type = $("#shipping").text() == 'Selecione um método' ? total : (shipping_price + total);
						break;					
				}	

				
				
				switch (parseInt(type_discount)) {
					case 1:
						$("#discount_cp").text("-" + ( discount_cp ) + "€");
						totalSub 			= total_by_type - discount_cp;		
						final_total = totalSub;
						if(final_total <= 0) {
							final_total = 0;
						}									
						break;
					default:
						let percentage 			= total_by_type * discount_cp / 100;						
						final_total 			= total_by_type - percentage;	
						$("#discount_cp").text("-" + ( discount_cp ) + "% | -"+ round(percentage).toFixed(2) + "€");	
						break;
				}			
				
				if(final_total <= 0) { 
					total_value 	= round(total, 2).toFixed(2);					
				} else {
					total_value 	= round(final_total + total, 2).toFixed(2);
				}
					
				if(total_by_type != 0) {								
					let formatted_total = final_total.toFixed(2);
					if(formatted_total <= 0) {
						formatted_total = 0;
					}
					
					switch (parseInt(apply_discount)) {
						case 2:								
							$("#total").text((total_value) + "€");
							break;
						case 1:								
							let final_value = final_total + shipping_price;									
							$("#total").text((round(final_value, 2).toFixed(2)) + "€");
							break;
						default:
							$("#total").text((formatted_total) + "€");
							break;
					}
				} 
				
			} else {
				shipping_price 	= $('input[type=radio][name=shipping]:checked').data('price');
				let final_total 	= round(total, 2);
				if(shipping_price != undefined) {
					final_total 	= round(total + shipping_price, 2);					
					$("#shipping").text((Number(shipping_price).toFixed(2)) + "€");
				}

				$("#total").text((Number(final_total).toFixed(2)) + "€");

			}
		}					

		$( document ).ready( fill );

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/checkout.blade.php ENDPATH**/ ?>