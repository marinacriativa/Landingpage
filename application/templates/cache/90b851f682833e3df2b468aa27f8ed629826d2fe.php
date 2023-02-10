
<?php $__env->startSection('title', $product->name); ?>

<?php $__env->startSection('content'); ?>
<?php
    if ($categories == null) { $categories = array(); }
    $categories_pair = array_column($categories, 'name', 'id');
    $categories_parent          = array_column($categories, 'parent', 'id');

    $productsAdvanced_json = json_encode($productsAdvanced);

?>
    <main>
        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/<?php echo e($selected_language->code); ?>"><?php echo e(ucfirst($translations["frontoffice"]["home"])); ?></a></li>
                    <li class="breadcrumb-item"><a href="/<?php echo e($selected_language->code); ?>/products"><?php echo e(ucfirst($translations["frontoffice"]["products"])); ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo e($product->name); ?></li>
                </ol>
            </div>
        </nav>
        <br>
        <div class="page-content">
            <div class="container">
                <div class="product-details-top">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="product-gallery product-gallery-vertical">
                                <div class="row">                                    
                                    <div class="fotorama" data-allowfullscreen="true" data-loop="true">                                                                          
                                        <?php $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                            
                                           
                                                 <img src="<?php echo e($image->path); ?>" id="foto-<?php echo e($image->id); ?>" alt="<?php echo e($product->name); ?>">                                               
                                                 
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="product-details">
                                <h1 class="product-title " id="main-name"><?php echo e($product->name); ?></h1>

                                <div class="product-price">
                                    <?php if($product->price_request == 0): ?>
                                        <span class="new-price" id="main-price"><?php if($product->type == 0): ?><?php echo e(number_format((float) $product->price, 2, ',', '')); ?>€<?php endif; ?></span>
                                        <?php if($product->previous_price != "0" && !empty($product->previous_price) && $product->type == 0): ?>
                                            <span class="old-price"><?php echo e(number_format((float) $product->previous_price, 2, ',', '')); ?>€</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="new-price" id="main-price">Preço sob consulta</span>
                                    <?php endif; ?>
                                </div>

                                <p><?php echo $product->policy; ?></p>
                                <?php if($product->type == '1'): ?>                                                              
                        
                                <div class="details-filter-row details-row-size">
                                    <label for="size">Outras opções:</label>
                                    <div class="select-custom">
                                        <select name="options_advanced" id="options_advanced" class="form-control">
                                            <option value="#" selected="selected">Selecione uma opção</option>                                     
                                            <?php $__currentLoopData = $productsAdvanced; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productAdvanced): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                        
                                                <option value="<?php echo e($productAdvanced->id); ?>"><?php echo e($productAdvanced->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(empty($productsAdvanced)): ?>
                                                <p><?php echo e(ucfirst($translations["frontoffice"]["product_advanced_empty"])); ?></p>
                                            <?php endif; ?>                                        
                                        </select>
                                    </div>
                                </div>
                                <?php endif; ?>                              
                                <input type="hidden" id="productAdvancedID">                             
                                <div class="details-filter-row details-row-size">
                                    <label for="qttotal">Quantidade:</label>
                                    <div class="product-details-quantity">
                                        <input type="number" id="qttotal" class="form-control" value="1" min="1" max="<?php echo e($product->stock); ?>" step="1" data-decimals="0" required>
                                    </div>
                                </div>                              
                                <?php if($product->type == '2'): ?>
                                    <div id="error-personalizationNotSelected">

                                    </div>
                                    <?php $__currentLoopData = $product_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $personalization): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="product_personalization_group"
                                                data-id="<?php echo e($personalization->id); ?>" style="display:none">
                                            <label><?php echo e($personalization->name); ?></label>
                                            <div class="product-owl-carousel owl-carousel owl-theme owl-loaded">
                                                <div class="owl-stage-outer">
                                                    <div class="owl-stage">
                                                        <?php $__currentLoopData = $personalization->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="owl-item">
                                                                <div class="shop-post mb-0">
                                                                    <div class="post-gal">
                                                                        <div data-id="<?php echo e($item->id); ?>"
                                                                                class="product_personalization_item">
                                                                            <img class="imgprdt"onerror="this.onerror=null;this.src='/static/backoffice/images/placeholder.png'"
                                                                                    src="<?php echo e($item->photo); ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <div class="product-details-action">                                    
                                    <a href="javascript:;" class="btn-product btn-cart add-to-cart">
                                        <span><?php echo e(ucfirst($translations["frontoffice"]["product_btn_add_cart"])); ?></span>
                                    </a>                                   
                                </div>

                                
                                <b id="ref_product">REF: <?php if(!empty($product->sku)): ?> <?php echo e($product->sku); ?>  <?php else: ?> Não informado. <?php endif; ?> </b><br>    
                                                             
                                                                   
                                <?php echo e(ucfirst($translations["frontoffice"]["product_stock"])); ?>: <?php if($product->stock < 999 && $product->stock !== null && !empty($product->stock)): ?> <span id="qntd_stock"><?php echo e($product->stock); ?></span> em stock <?php elseif(!empty($productAdvanced->stock)): ?> <span id="qntd_stock"></span> em stock <?php else: ?> <span id="qntd_stock">*ESTE PRODUTO NÃO TEM STOCK</span> <?php endif; ?>                                 
                             
                                </a>
                                <div class="product-details-footer">
                                    <div class="product-cat">
                                        <?php 
                                            $mainCategory = 1;
                                            $categoriesFormatted = [];
                                            $mainCategoriesProduct = [];
                                        ?>

                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <?php   
                                            $categoriesFormatted[$category->id] = [
                                                'id' => $category->id,
                                                'name' => $category->name,
                                                'parent' => $category->parent    
                                            ];
                                            ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                        <?php $__currentLoopData = explode(',', $product->categories); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(isset($categoriesFormatted[$productCategory])): ?>
                                                <?php if($categoriesFormatted[$productCategory]['parent'] == $mainCategory): ?>
                                                    <?php 
                                                        $mainCategoriesProduct[] = $categoriesFormatted[$productCategory];
                                                    ?>
                                                <?php endif; ?>                                                               
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php $__currentLoopData = $mainCategoriesProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $mainCategoryProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>             
                                            <?php                                                             
                                                foreach ($categories as $category) {
                                                    if ($category->parent == $mainCategoryProduct['id'] && in_array($category->id, (explode(',', $product->categories)))) {
                                                        $mainCategoriesProduct[$key]['child'][] = $category->name;
                                                    }
                                                }
                                            ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php $__currentLoopData = $mainCategoriesProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainCategoryProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                            <?php if(isset($mainCategoryProduct['child']) && !empty($mainCategoryProduct['child'])): ?>
                                                <li><a><strong><?php echo e($mainCategoryProduct['name']); ?>:</strong> <?php echo e(implode(', ', $mainCategoryProduct['child'])); ?> </a></li> 
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                    </div>

                                    <div class="social-icons social-icons-sm a2a_kit a2a_kit_size_32">
                                        <span class="social-label">Partilhar:</span>
                                        <a href="#" class="social-icon a2a_button_facebook" title="Facebook"
                                            target="_blank"><i class="icon-facebook-f"></i>
                                        </a>
                                        <a href="#" class="social-icon a2a_button_instagram" title="Instagram"
                                        target="_blank"><i class="icon-instagram"></i>
                                        </a>
                                        <!--<a href="#" class="social-icon a2a_button_twitter" title="Twitter"
                                            target="_blank"><i class="icon-twitter"></i></a>
                                        <a href="#" class="social-icon a2a_button_linkedin" title="Linkedin"
                                            target="_blank"><i class="icon-linkedin"></i></a>
                                        <a href="#" class="social-icon a2a_button_pinterest" title="Pinterest"
                                            target="_blank"><i class="icon-pinterest"></i></a> -->
                                        <script async src="https://static.addtoany.com/menu/page.js"></script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-details-tab">
                    <ul class="nav nav-pills justify-content-center" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#product-desc-tab" role="tab" style="text-transform: uppercase;" aria-selected="true"><?php echo e(ucfirst($translations["frontoffice"]["product_info"])); ?></a>
                        </li>
                        <?php if(!empty($product->youtube) && $product->youtube_active == 1): ?>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#product-youtube-tab" role="tab" style="text-transform: uppercase;">Vídeo</a>
                        </li>
                        <?php endif; ?>



                        
                        <?php if(!empty($attributes)): ?>
                        <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#atribute-table" role="tab" style="text-transform: uppercase;">Tabela Nutricional</a>
                        </li>
                        <?php endif; ?>






                        <?php if(/* !empty($product->policy) || */ !empty($discounts)): ?>
                        <li class="nav-item">
                            <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" style="text-transform: uppercase;" aria-selected="false">Mais Informações</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel"
                            aria-labelledby="product-desc-link">
                            <div class="product-desc-content">
                                <h2><?php echo e(ucfirst($translations["frontoffice"]["product_info"])); ?></h2>
                                <?php if(empty($product->sku)): ?>
                                <?php else: ?>
                                <p class="p-sku">
                                    <h6>Referência do Produto: </h6><span class="idno"><?php echo e($product->sku); ?></span>
                                </p>
                                <?php endif; ?>
                                <br>
                               <?php if(!empty($product->details)): ?>                               
                                    <p class="p-sku">
                                      <h6>Detalhes:</h6><span class="idno"><?php echo $product->details; ?></span>
                                    </p><br>
                              <?php endif; ?>
                                <p><br></p>
                            </div>
                        </div>
                        <?php if(/* !empty($product->policy) || */ !empty($discounts)): ?>
                            <div class="tab-pane fade" id="product-info-tab" role="tabpanel"
                                aria-labelledby="product-info-link">
                                <div class="product-desc-content">
                                    <h2>Informações adicionais</h2>
                                    <!-- <p></p>
                                    <p><?php echo $product->policy; ?> </p> -->
                                    <?php if(!empty($discounts)): ?>
                                        <br>
                                        <hr>
                                        <h3 class="mb-0">Desconto por quantidade</h3><br>
                                        <table class="table">
                                            <tbody>
                                            <?php $__currentLoopData = $discounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <th style="width: 50%">
                                                        <p class="text-bold">
                                                            <?php echo e($discount->quantity); ?> uni</p>
                                                    </th>
                                                    <td style="width: 50%">
                                                        <p><?php echo e($discount->percentage); ?>%</p>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    <?php endif; ?>
                                    <?php if($product->type == '2'): ?>
                                        <div class="col-lg-12">
                                            <div class="card mb-0">
                                                <div class="card-header" id="headingThree">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link collapsed" type="button"
                                                                data-toggle="collapse" data-target="#collapseThree"
                                                                aria-expanded="false" aria-controls="collapseThree">
                                                            <?php echo e(ucfirst($translations["frontoffice"]["product_customizations"])); ?>

                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree">
                                                    <div class="card-deck row">
                                                        <?php $__currentLoopData = $product_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $personalization): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <h4 class="titleGroupPersonalizationCard"><?php echo e($personalization->name); ?></h4>
                                                            <div class="product-description-owl-carousel owl-carousel owl-theme owl-loaded">
                                                                <div class="owl-stage-outer personalizationCard-text-align">
                                                                    <div class="owl-stage">
                                                                        <?php $__currentLoopData = $personalization->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="owl-item">
                                                                                <div class="card personalizationCard">
                                                                                    <img onerror="this.onerror=null;this.src='/static/backoffice/images/placeholder.png'"
                                                                                         class="imageCard imgPersonalizationCard"
                                                                                         src="<?php echo e($item->photo); ?>">
                                                                                    <div class="card-body personalizationCard-body">
                                                                                        <br>
                                                                                        <h3 class="card-title titlePersonalizationCard">
                                                                                            <?php echo e($item->name); ?></h3>
                                                                                        <br>
                                                                                        <div id="personalization-info">
                                                                                            <p data-textId="<?php echo e($item->id); ?>-<?php echo e($personalization->id); ?>"
                                                                                               class="card-text break-word display-none">
                                                                                                <?php echo $item->text; ?></p>
                                                                                        </div>
                                                                                        <button class="btn-default btn-dark"
                                                                                                id="open-info"
                                                                                                data-buttonId="<?php echo e($item->id); ?>-<?php echo e($personalization->id); ?>">
                                                                                            <?php echo e(ucfirst($translations["frontoffice"]["product_customizations_more_info"])); ?>

                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if(!empty($product->youtube)): ?>
                            <?php 
                                $youtube = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","<iframe width=\"100%\" height=\"650\" src=\"//www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe>", $product->youtube);
                            ?>

                            <div class="tab-pane fade" id="product-youtube-tab" role="tabpanel" aria-labelledby="product-youtube-link">
                                <div class="reviews">
                                    <?php echo $youtube; ?>

                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($attributes)): ?>
                        <div class="tab-pane fade" id="atribute-table" role="tabpanel" aria-labelledby="">
                            <div class="reviews">
                                    <table class="table table-striped table-bordered">
                                        <tbody>
                                            <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <th style="width: 50%" class="p-2 atributes">
                                                    <p class="text-bold">
                                                        <?php echo e($attribute->attribute_key); ?></p>
                                                </th>
                                                <td style="width: 50%" class="p-2 atributes">
                                                    <p><?php echo e($attribute->value); ?></p>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                    </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <h2 class="title text-center mb-4 mt-4"><?php echo e(ucfirst($translations["frontoffice"]["product_list_recommended"])); ?></h2>
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                    data-owl-options='{
                    "nav": true, 
                    "dots": true,
                    "margin": 20,
                    "loop": true,
                    "responsive": {
                    "0": {
                    "items":1
                    },
                    "480": {
                    "items":2
                    },
                    "768": {
                    "items":3
                    },
                    "992": {
                    "items":4
                    },
                    "1200": {
                    "items":5,
                    "nav": true,
                    "dots": false
                    }
                    }
                    }'>
                    <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recommended_product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="product product-7 text-center">
                            <figure class="product-media">

                                <a href="/<?php echo e($selected_language->code); ?>/products/<?php echo e($recommended_product->slug); ?>">
                                    <img src="<?php echo e($recommended_product->photo); ?>" alt="<?php echo e($recommended_product->name); ?>" class="product-image">
                                </a>
                            </figure>
                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="/<?php echo e($selected_language->code); ?>/products/<?php echo e($recommended_product->slug); ?>">REF <?php echo e($recommended_product->sku); ?></a>
                                </div>
                                <h3 class="product-title">
                                    <a href="/<?php echo e($selected_language->code); ?>/products/<?php echo e($recommended_product->slug); ?>">
                                        <?php echo e($recommended_product->name); ?>

                                    </a>
                                </h3>
                                <div class="product-price">
                                    <span class="new-price" ><?php echo e(number_format((float) $recommended_product->price, 2, ',', '')); ?>€</span>
                                    <?php if($recommended_product->previous_price != "0" && !empty($recommended_product->previous_price)): ?>
                                        <span class="old-price"><?php echo e(number_format((float) $recommended_product->previous_price, 2, ',', '')); ?>€</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>
        </div>
    </main>

    <style>
        .modal-content {padding: 20px}
        .modal button {
            text-transform: none;
            border: 0.1rem solid #D5023F;
            color: #D5023F;
            background-color: transparent;
            font-size: 1.2rem;
            font-weight:400;
            font: normal 400 1.4rem/1.86 "Mulish", sans-serif;
            padding: 5px;
            margin: 5px;
        }
        .modal button:hover {

            border-color: var(--color_1);
            background-color: var(--color_1);
            color: #ffffff;
        }
        .modal img {
            display: block;
            max-width: 100px;
            height: auto;
        }
        .modal .d-block{display

        }
        
    </style>   
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {       
            let productsAdvanced_data_x = `<?php echo $productsAdvanced_json; ?>`;
            var product_type = "<?php echo e($product->type); ?>";
            var product_id = "<?php echo e($product->id); ?>";         
            
            let productsAdvanced_data = JSON.parse(productsAdvanced_data_x);

            let $fotoramaDiv = $('.fotorama').fotorama();
            let fotorama = $fotoramaDiv.data('fotorama');  

            //fotorama.show('foto-1139')

            $('#options_advanced').change(function() {    
                let selectedID = $(this).val();
               
                if(productsAdvanced_data.length > 0) {    
                    productsAdvanced_data.forEach((productADV) => {                                
                        if(productADV.id == selectedID) {
                            $('#productAdvancedID').val(productADV.id);   
                            $('#qttotal').attr('max', productADV.stock );  
                            
                            let id_formatted = 0;                                    

                            $.each(productADV.gallery, function (key, item) {
                                id_formatted = item.id.replace(',', '');   
                                fotorama.show('foto-' + id_formatted)
                            });                            
                                                                         
                            let formatted_price = String(productADV.current_price).replace(".", ",");
                            $('#main-price').text((formatted_price) + "€");
                            $('#main-name').text(productADV.name); 
                            
                            if(productADV.ref.length > 0) {
                                $('#ref_product').text('REF: ' + productADV.ref); 
                            }

                            if(productADV.stock < 999 && productADV.stock !== null && productADV.stock.length > 0) {                                
                                $('#qntd_stock').html(productADV.stock);                                
                            }   
                        }                                    
                    })                    
                }
            });


            $('#product-zoom').elevateZoom({
                gallery: 'product-zoom-gallery',
                galleryActiveClass: 'active',
                zoomType: "inner",
                cursor: "crosshair",
                zoomWindowFadeIn: 400,
                zoomWindowFadeOut: 400,
                responsive: true
            });
            
            // On click change thumbs active item
            $('.product-gallery-item').on('click', function(e) {
                $('#product-zoom-gallery').find('a').removeClass('active');
                $(this).addClass('active');
            
                e.preventDefault();
            });
            
            var ez = $('#product-zoom').data('elevateZoom');
            
            // Open popup - product images
            $('#btn-product-gallery').on('click', function(e) {
                if ($.fn.magnificPopup) {
                    $.magnificPopup.open({
                        items: ez.getGalleryList(),
                        type: 'image',
                        gallery: {
                            enabled: true
                        },
                        fixedContentPos: false,
                        removalDelay: 600,
                        closeBtnInside: false
                    }, 0);
            
                    e.preventDefault();
                }
            });

            // Iniciar a página de produto
            init();
            

            let personalizations = [];

            function init() {

                // Retirar o hidden dos produtos personalizados, se tiver
                setTimeout(function () {

                    $(".product_personalization_group").fadeIn("fast");

                }, 200);

                listners();
            }

            function getCookie(cname) {
                let name = cname + "=";
                let decodedCookie = decodeURIComponent(document.cookie);
                let ca = decodedCookie.split(';');
                for(let i = 0; i <ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                    }
                }
                return "";
            }

            function listners() {

                $(".add-to-cart").on("click", function (e) {
                    const numberOfGroups = $(".product_personalization_group").length;
                    let personalizations = {};
                    let advanced

                    let stock = parseInt($('#qntd_stock').text());
                    let qntd_selected = parseInt($('#qttotal').val());

                    let cart_cookie = getCookie('cart');
                    let quantityCookie = 0;
                    let idCookie = 0;
                    let currentID = product_id;
                    let qntd_in_cart = 0;
                    
                    if (product_type == 1) {
                        currentID = $("#productAdvancedID").val()                                   
                    }

                    if(cart_cookie != '[]' && cart_cookie != ''){
                        let jsonCookie = JSON.parse(cart_cookie)

                        $.each(jsonCookie, function(key, value) {
                            if(product_type != 2) {
                                if(value.personalization != undefined) {
                                    if(value.personalization == currentID) {
                                        quantityCookie  = value.quantity                        
                                        idCookie        = value.personalization
                                        return;
                                    }
                                } else {                         
                                    quantityCookie  = value.quantity                        
                                    idCookie        = value.id
                                } 
                            } else {
                                if(value.id == currentID) {                                                     
                                    idCookie        = value.id
                                    qntd_in_cart    += value.quantity
                                    return
                                }
                            }                                                      
                        })      
                        
                    }

    
                    
                    if(stock == 0 || stock == undefined || stock == null || isNaN(stock)) {
                        e.preventDefault();

                        alert("Produto sem stock");
                        return;
                    }

                   
    
                    if(idCookie == currentID) {
                        if(product_type != 2) {
                            let totalqtd = qntd_selected  + quantityCookie;
                            if(stock < totalqtd) {
                                e.preventDefault();

                                alert("A quantidade escolhida ultrapassa o stock de " + stock + " produto(s).");
                                return;
                            }
                        } else {
                            let totalqtd = qntd_selected  + qntd_in_cart;
                            if(stock < totalqtd) {
                                e.preventDefault();

                                alert("A quantidade escolhida ultrapassa o stock de " + stock + " produto(s).");
                                return;
                            }
                        }
                    }                    

                    if (product_type == 2) {
                        $(".product_personalization_group").each(function (index, element) {
                            $(element).find(".product_personalization_item").each(function (i, el) {
                                if ($(el).hasClass("active")) {
                                    personalizations[$(element).data("id")] = $(el).data(
                                        "id");
                                }
                            })
                        })
                        //error("É obrigatório escolher opções de personalização antes de adicionar o produto ao carrinho")
                        if (Object.keys(personalizations).length < numberOfGroups){
                            let template = `
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong><?php echo e(ucfirst($translations["frontoffice"]["product_btn_add_cart"])); ?></strong> <?php echo e(ucfirst($translations["frontoffice"]["product_custom_message_error"])); ?>

                                </div>
                            `
                            $("#error-personalizationNotSelected").append(template)
                            return
                        }

                        // Não deixar o browser redirecionar para o link: #
                        e.preventDefault();

                        addToCart(personalizations);
                    }

                    if (product_type == 1) {
                        let advanced = $("#productAdvancedID").val()                                 

                        // Não deixar o browser redirecionar para o link: #
                        e.preventDefault();
                        if(advanced == "undefined" || advanced == "") {
                            alert("Por favor, selecione um produto composto.");
                            return;
                        }
                        addToCart(advanced);
                    }

                    if (product_type == 0) {
                        // Não deixar o browser redirecionar para o link: #
                        e.preventDefault();

                        addToCart();
                    }

                });

                $(".product_personalization_item").on("click", function () {

                    // Remover classe ativo se existir noutro
                    $(this).closest(".product_personalization_group").find(
                        ".product_personalization_item.active").removeClass("active")

                    // Adicionar classe ativo
                    $(this).addClass("active");
                });

                //Item ver mais
                $("body").off("click", "#open-info");
                $("body").on("click", "#open-info", function () {

                    let id = $(this).data("buttonid");

                    if ($(`p[data-textid="${id}"]`).hasClass("display-none")) {

                        $(`p[data-textid="${id}"]`).removeClass("display-none");
                    } else {
                        $(`p[data-textid="${id}"]`).addClass("display-none");
                    }
                });
            }

            function addToCart(personalization = "") {

                let data = {
                    product_id: product_id
                };

                data.quantity = $("#qttotal").val();
                data.type = product_type                
                data.personalization = personalization

                if (data.quantity == 0) {

                    error("A quantidade não pode ser zero");
                    return;
                }

                $.ajax({
                    url: "/cart",
                    dataType: "json",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    success: function (response) {

                        if (!response.success) {

                            // Output do erro
                            console.error(response);

                            error('Ocorreu algum erro ao processar o pedido');

                            // Deu erro, nao vamos executar mais
                            return;
                        }

                        // Abrir o carrinho
                        $(".shopping-popup").removeClass("active");
                        $('a.toggle-shopping').get(0).click();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                        error('Ocorreu algum erro ao processar o pedido');
                    }
                });
            }

            function error(message) {

                $(".error-box p").text(message);
                $(".error-box").fadeIn("fast");

                setTimeout(function () {

                    $(".error-box").fadeOut("fast");

                }, 5000);
            }
        });

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/products/page.blade.php ENDPATH**/ ?>