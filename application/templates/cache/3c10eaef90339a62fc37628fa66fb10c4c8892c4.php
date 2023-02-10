
<?php $__env->startSection('title', 'produtos'); ?>
<?php $__env->startSection('content'); ?>
    <main class="main">
        <section class="promo-primary">
            <picture>
                <source srcset="/public/static/images/banner/rhyno.jpg" media="(min-width: 992px)" /><img class="img--bg"
                    src="/public/static/images/dog.jpg" alt="img" />
            </picture>
            <div class="promo-primary__description">Our<span>Services</span></div>
            <div class="container">
                <div class="row">
                    <div class="col-auto">
                        <div class="align-container">
                            <div class="align-container__item"><span class="promo-primary__pre-title">Coliworld</span>
                                <h1 class="promo-primary__title"><span>Our</span><span>Services</span></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section background--brown">
            <div class="container">
                <div class="row offset-margin">

                    <div class="col-md-6 col-lg-4">
                        <div class="blog-item blog-item--style-1">
                            <div class="blog-item__img"><img class="img--bg" src="/public/static/images/blog_1.png"
                                    alt="img" /></div>
                            <div class="blog-item__content">
                                <h6 class="blog-item__title"><a
                                        href="/<?php echo e($selected_language->code); ?>/checkout_service_html">Formation</a></h6>
                                <p>We are an association for animals and nature conservation. We bring awareness througth
                                    comunication.</p>
                                <div class="/<?php echo e($selected_language->code); ?>/checkout_service_html"><span
                                        class="blog-item__date"></span><span>Learn more &rarr;</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="blog-item blog-item--style-1">
                            <div class="blog-item__img"><img class="img--bg" src="/public/static/images/blog_1.png"
                                    alt="img" /></div>
                            <div class="blog-item__content">
                                <h6 class="blog-item__title"><a
                                        href="/<?php echo e($selected_language->code); ?>/checkout_service_html">Petsiting</a></h6>
                                <p>We are an association for animals and nature conservation. We bring awareness througth
                                    comunication.</p>
                                <div class="/<?php echo e($selected_language->code); ?>/checkout_service_html"><span
                                        class="blog-item__date"></span><span>Learn more &rarr;</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="blog-item blog-item--style-1">
                            <div class="blog-item__img"><img class="img--bg" src="/public/static/images/blog_1.png"
                                    alt="img" /></div>
                            <div class="blog-item__content">
                                <h6 class="blog-item__title"><a
                                        href="/<?php echo e($selected_language->code); ?>/checkout_service_html">Events</a></h6>
                                <p>We are an association for animals and nature conservation. We bring awareness througth
                                    comunication.</p>
                                <div class="/<?php echo e($selected_language->code); ?>/checkout_service_html"><span
                                        class="blog-item__date"></span><span>Learn more &rarr;</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="blog-item blog-item--style-1">
                            <div class="blog-item__img"><img class="img--bg" src="/public/static/images/blog_1.png"
                                    alt="img" /></div>
                            <div class="blog-item__content">
                                <h6 class="blog-item__title"><a
                                        href="/<?php echo e($selected_language->code); ?>/checkout_service_html">Consulting</a></h6>
                                <p>We are an association for animals and nature conservation. We bring awareness througth
                                    comunication.</p>
                                <div class="/<?php echo e($selected_language->code); ?>/checkout_service_html"><span
                                        class="blog-item__date"></span><span>Learn more &rarr;</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- pagination start-->
                    <ul class="pagination">
                        <li class="pagination__item pagination__item--prev"><i class="fa fa-angle-left"
                                aria-hidden="true"></i><span>Back</span>
                        </li>
                        <li class="pagination__item"><span>1</span></li>
                        <li class="pagination__item pagination__item--active"><span>2</span></li>
                        <li class="pagination__item"><span>3</span></li>
                        <li class="pagination__item"><span>4</span></li>
                        <li class="pagination__item"><span>5</span></li>
                        <li class="pagination__item pagination__item--disabled">...</li>
                        <li class="pagination__item"><span>12</span></li>
                        <li class="pagination__item pagination__item--next"><span>Next</span><i class="fa fa-angle-right"
                                aria-hidden="true"></i>
                        </li>
                    </ul>
                    <!-- pagination end-->
                </div>
            </div>
        </section>
        <!-- section end-->
        <!-- bottom bg start-->
        <section class="bottom-background background--brown">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="bottom-background__img"><img src="/public/static/images/bottom-bg.png" alt="img" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- bottom bg end-->
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/services_index_html.blade.php ENDPATH**/ ?>