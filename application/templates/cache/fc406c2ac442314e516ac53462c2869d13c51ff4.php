
<?php $__env->startSection('title', $new->title); ?>
<?php $__env->startSection('content'); ?>
    <style>
        .bg-gradient-orange-pink {
            background-image: linear-gradient(to right top, #36404A, #36404A, #36404A, #36404A, #36404A);
        }

        .text-gradient-sky-blue-pink {
            background: linear-gradient(to right, #36404A, #36404A, #36404A, #36404A, #36404A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .swiper-slide img {
            width: 480px;
            height: 410px;
        }
    </style>

    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-8 col-lg-10 text-center overlap-gap-section">
                <div class="w-40px h-2px bg-gradient-orange-pink separator-line-vertical margin-30px-tb d-inline-block">
                </div>
                <h3 class="alt-font font-weight-500 text-extra-dark-gray letter-spacing-minus-1px"><?php echo e($new->title); ?></h3>
                <p><a href="/<?php echo e($selected_language->code); ?>/">Início</a> | <a
                        href="/<?php echo e($selected_language->code); ?>/news">Notícias</a></p>
                <p></p>
                <!-- <h3 class="alt-font font-weight-500 text-extra-dark-gray letter-spacing-minus-1px"><?php echo e($new->title); ?><span class="text-gradient-orange-pink font-weight-600"><?php echo e($new->title); ?></span></h3> -->
            </div>
        </div>
    </div>
    <section class="border-top border-color-medium-gray">
        <div class="container">
            <div class="row">
                <div class="col tab-style-01 without-number wow animate__fadeIn">
                    <div class="tab-content">
                        <div id="planning-tab" class="tab-pane fade in active show">
                            <div class="row align-items-center">
                                <div class="col col-md-5 text-end sm-margin-40px-bottom">
                                    <div class="swiper-container white-move h-auto margin-4-half-rem-bottom  border-radius-6px"
                                        data-slider-options='{ "slidesPerView": 1, "loop": true, "pagination": { "el": ".swiper-pagination", "clickable": true }, "autoplay": { "delay": 2000, "disableOnInteraction": false }, "navigation": { "nextEl": ".swiper-button-next-nav", "prevEl": ".swiper-button-previous-nav" }, "keyboard": { "enabled": true, "onlyInViewport": true }, "effect": "slide" }'>

                                        <div class="swiper-wrapper">
                                            <?php $__currentLoopData = $gallery_img; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="swiper-slide">
                                                    <img src="<?php echo e($gallery->path); ?>" alt="">
                                                </div><!-- end slider item -->
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>

                                        <div
                                            class="swiper-button-next-nav swiper-button-next light slider-navigation-style-01">
                                            <i class="feather icon-feather-arrow-right" aria-hidden="true"></i>
                                        </div>
                                        <div
                                            class="swiper-button-previous-nav swiper-button-prev light slider-navigation-style-01">
                                            <i class="feather icon-feather-arrow-left" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-7 text-center text-sm-start">
                                    <h5
                                        class="alt-font font-weight-600 text-extra-dark-gray margin-35px-bottom md-margin-30px-bottom">
                                        <?php echo e($new->title); ?></h5>
                                    <ul class="list-unstyled margin-2-rem-bottom">
                                        <li class=" align-middle margin-25px-right"><i
                                                class="feather icon-feather-calendar text-fast-blue margin-10px-right"></i><a
                                                href="blog-grid.html"><?php echo e($new->date); ?></a></li>
                                        <!-- <li class="d-inline-block align-middle margin-25px-right"><i class="feather icon-feather-folder text-fast-blue margin-10px-right"></i><a href="blog-grid.html">Creative</a></li>
                                                                                                                                                                                        <li class="d-inline-block align-middle"><i class="feather icon-feather-user text-fast-blue margin-10px-right"></i>By <a href="blog-grid.html">Shane doe</a></li> -->
                                    </ul>
                                    <p><?php echo $new->text; ?></p>
                                    <div
                                        class="col-12 d-flex flex-wrap align-items-center padding-15px-tb mx-auto margin-20px-bottom wow animate__fadeIn">
                                        <div class="col-12 col-md-9 text-center text-md-start sm-margin-10px-bottom px-0">
                                            <div class="tag-cloud">
                                                <a href="#">#rudesystems</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="col-12 text-left elements-social social-icon-style-09 mx-auto a2a_kit a2a_kit_size_64 a2a_default_style">
                                        <ul class="medium-icon">
                                            <li class="wow animate__fadeIn" data-wow-delay="0.1s">
                                                <span>Partilhar:</span></a>
                                            </li>
                                            <li class="wow animate__fadeIn" data-wow-delay="0.2s"><a
                                                    class="a2a_button_facebook facebook"><i
                                                        class="sharepub fab fa-facebook-f"></i><span></span></a></li>
                                            <li class="wow animate__fadeIn" data-wow-delay="0.4s"><a
                                                    class="a2a_button_instagram instagram"><i
                                                        class="sharepub fab fa-instagram"></i><span></span></a></li>
                                    </div>
                                    <script async src="https://static.addtoany.com/menu/page.js"></script>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/news/page.blade.php ENDPATH**/ ?>