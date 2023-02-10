<?php
    $total = 0;
?>
<div class="dropdown-cart-products mt-2">

        <?php $__empty_1 = true; $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            
            <?php
            if ($item['product']->type == 1) {

                $total += ($item['quantity'] * $item['advanced']->current_price);

            } else {

                $total += ($item['quantity'] * $item['product']->price);
            }
        ?>
        <?php if(isset($item['advanced'])): ?>

            <?php if(isset($item["advanced"]->gallery[0])): ?>

                <?php $item['product']->photo =  $item["advanced"]->gallery[0]->path ?>
            <?php endif; ?>

        <?php endif; ?>

        <div class="product">
            <div class="product-cart-details">
                <h4 class="product-title">
                    <a href="/<?php echo e($selected_language->code); ?>/products/<?php echo e($item['product']->slug); ?>"><?php echo e($item['product']->name); ?></a>
                </h4>
                
                <span class="cart-product-info">
                <?php if(isset($item['advanced'])): ?>
                    <span><?php echo e($item['advanced']->name); ?></span>
                    <span class="cart-product-qty"><?php echo e($item['quantity']); ?> x <?php echo e(number_format((float) $item['advanced']->current_price, 2, ',', '')); ?>€</span>
                <?php elseif(isset($item['personalization'])): ?>
                    <span>Personalizado</span>
                    <span class="cart-product-qty"><?php echo e($item['quantity']); ?> x <?php echo e(number_format((float) $item['product']->price, 2, ',', '')); ?>€</span>
                <?php else: ?> 
                    <span class="cart-product-qty"><?php echo e($item['quantity']); ?> x <?php echo e(number_format((float) $item['product']->price, 2, ',', '')); ?>€</span>
                <?php endif; ?>
                </span>
            </div>
            <figure class="product-image-container">
                <a href="/<?php echo e($selected_language->code); ?>/products/<?php echo e($item['product']->slug); ?>" class="product-image">
                    <img src="<?php echo e($item['product']->photo); ?>" alt="<?php echo e($item['product']->name); ?>">
                </a>
            </figure>
            <?php if(isset($item['advanced'])): ?>
                <a href="#" data-id="<?php echo e($item['advanced']->id); ?>" class="btn-remove delete-art-adv" title="Remove Product"><i class="icon-close"></i></a>
            <?php else: ?>
                <a href="#" data-id="<?php echo e($item['id']); ?>" class="btn-remove delete-art" title="Remove Product"><i class="icon-close"></i></a>
            <?php endif; ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php echo e(ucfirst($translations["frontoffice"]["cart_empty"])); ?>

    <?php endif; ?>
</div>


<?php if(!empty($cart)): ?>
    <div class="dropdown-cart-total">
        <span><?php echo e(ucfirst($translations["frontoffice"]["mini_cart_subTotal"])); ?></span>

        <span class="cart-total-price"><?php echo e(number_format((float) $total, 2, ',', '')); ?>€</span>
    </div>
<?php endif; ?>

<?php if(!empty($cart)): ?>
<div class="dropdown-cart-action">
    <a href="/cart/details" class="btn btn-outline-primary-2"><?php echo e(ucfirst($translations["frontoffice"]["mini_cart_see_cart"])); ?></a>
    <a href="/checkout" class="btn btn-primary"><span><?php echo e(ucfirst($translations["frontoffice"]["mini_cart_checkout"])); ?></span><i class="icon-long-arrow-right"></i></a>
</div>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/items/cart.blade.php ENDPATH**/ ?>