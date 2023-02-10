
<?php $__env->startSection('title', 'Carrinho'); ?>
<?php $__env->startSection('content'); ?>
<?php
    $total = 0;	
?>
<div id="content">
	
	<div class="page-header text-center" style="background-image: url('/public/static/images/newsletter-bg.jpg')">
		<div class="container">
			<h1 class="page-title"><?php echo e(ucfirst($translations["frontoffice"]["cart_title"])); ?>

				<span>Listagem | Consulta</span></h1>
		</div>
	</div>
	<nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
		<div class="container">
			<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/<?php echo e($selected_language->code); ?>"><?php echo e(ucfirst($translations["frontoffice"]["home"])); ?></a></li>
			<li class="breadcrumb-item active" aria-current="page"><?php echo e(ucfirst($translations["frontoffice"]["cart_title"])); ?></li>
			</ol>
		</div>
	</nav>
	
	<div class="page-content">
			<div class="cart">
				<div class="container">
					<div class="row">
						<div class="col-lg-9">
							<table class="table table-cart table-mobile">
								<thead>
									<tr>
										<th><?php echo e(ucfirst($translations["frontoffice"]["cart_table_fill_product"])); ?></th>
										<th><?php echo e(ucfirst($translations["frontoffice"]["cart_table_fill_price"])); ?></th>
										<th><?php echo e(ucfirst($translations["frontoffice"]["cart_table_fill_quantity"])); ?></th>
										<th><?php echo e(ucfirst($translations["frontoffice"]["cart_table_fill_total"])); ?></th>
									</tr>
								</thead>

								<tbody>
								<?php $__empty_1 = true; $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

									<?php
									
										if ($item['product']->type == 1) {

											$total += ($item['quantity'] * $item['advanced']->current_price);

										} else {

											$total += ($item['quantity'] * $item['product']->price);
										}															
					
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
														<?php if(!empty($item['advanced']->photo)): ?>
															<a href="#">
																<img src="<?php echo e($item['advanced']->photo); ?>" alt="<?php echo e($item['advanced']->name); ?>">
															</a>
														<?php endif; ?>
													</figure>

													<h3 class="product-title">
														<a href="#"><?php echo e($item['advanced']->name); ?></a>
													</h3>
												</div>
											</td>
											<td class="price-col"><?php echo e(number_format((float) $item['advanced']->current_price, 2, ',', ',')); ?>€</td>
											<input type="hidden" name="stock_product_<?php echo e($item['advanced']->id); ?>" value="<?php echo e($item['advanced']->stock); ?>">
											<td class="quantity-col">
												<div class="cart-product-quantity quantity-add quantity"  data-advanced="<?php echo e($item['advanced']->id); ?>" data-id="<?php echo e($item['id']); ?>">
													<input name="quantity" type="number" class="quantity-number input-qty-<?php echo e($item['advanced']->id); ?>" value="<?php echo e($item['advanced']->quantity); ?>" min="1" max="<?php echo e($item['advanced']->stock); ?>" step="1" data-decimals="0" required>
												</div>
											</td>
											<td class="total-col"><?php echo e($item['advanced']->current_price * $item['quantity']); ?>€</td>
											<td class="remove-col"><button class="btn-remove remove-item-advanced" data-id="<?php echo e($item['advanced']->id); ?>"><i class="icon-close"></i></button></td>
										<?php else: ?>
											<td class="product-col">
												<div class="product">
													<figure class="product-media">
														<a href="#">
															<img src="<?php echo e($item['product']->photo); ?>" alt="<?php echo e($item['product']->name); ?>">
														</a>
													</figure>

													<h3 class="product-title">
														<a href="#"><?php echo e($item['product']->name); ?></a>
													</h3>
												</div>
											</td>
											<input type="hidden" name="stock_product_<?php echo e($item['product']->id); ?>" value="<?php echo e($item['product']->stock); ?>">
											<td class="price-col"><?php echo e(number_format((float) $item['product']->price, 2, ',', ',')); ?>€</td>
											<td class="quantity-col">
												<div class="cart-product-quantity quantity-add quantity" data-id="<?php echo e($item['id']); ?>">
													<input name="quantity" type="number" class="quantity-number input-qty-<?php echo e($item['id']); ?>" value="<?php echo e($item['quantity']); ?>" min="1" max="<?php echo e($item['product']->stock); ?>" step="1" data-decimals="0" required>
												</div>
											</td>
											<td class="total-col"><?php echo e(number_format((float) ($item['product']->price * $item['quantity']), 2, ',', '')); ?>€</td>
											<td class="remove-col"><button class="btn-remove remove-item" data-id="<?php echo e($item['id']); ?>"><i class="icon-close"></i></button></td>
										<?php endif; ?>								
									</tr>

									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td><?php echo e(ucfirst($translations["frontoffice"]["cart_empty"])); ?></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
                            </tr>

									<?php endif; ?>
									
								</tbody>
							</table>
						</div>
						<aside class="col-lg-3">
							<div class="summary summary-cart">
								<h3 class="summary-title">Carrinho Totais</h3>

								<table class="table table-summary">
									<tbody>
										<tr class="summary-subtotal">
											<td><?php echo e(ucfirst($translations["frontoffice"]["cart_subTotal_title"])); ?>:</td>
											<td><span class="total-price-withshipping"><?php echo e(number_format((float) $total, 2, ',', '')); ?>€</span></td>
										</tr>
										<?php if($settings->tax != 0): ?>
												<?php

													$tax = ($total / 100) * $settings->tax;
													$total_formatted = $total + $tax;

												?>
												<tr>
													<td><?php echo e(ucfirst($translations["frontoffice"]["cart_subTotal_tax"])); ?> <?php echo e($settings->tax); ?>%</td>
													<td id="tax"><?php echo e(number_format((float) $tax, 2, ',', '')); ?>€</td>
												</tr>
												<tr>
													<td><?php echo e(ucfirst($translations["frontoffice"]["cart_subTotal_text"])); ?></td>
													<td><span class="total-price-withshipping"><?php echo e(number_format((float) $total_formatted, 2, ',', '')); ?>€</span></td>
												</tr>
										<?php endif; ?>
									</tbody>
								</table>

								<a href="/checkout" class="btn btn-outline-primary-2 btn-order btn-block">Finalizar Checkout</a>
							</div>

							<a href="/<?php echo e($selected_language->code); ?>/products" class="btn btn-outline-dark-2 btn-block mb-3"><span>Continuar a comprar</span><i class="icon-refresh"></i></a>
						</aside>
					</div>
				</div>
			</div>
		</div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script>	

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/cart.blade.php ENDPATH**/ ?>