
<?php $__env->startSection('title', 'Blog'); ?>
<?php $__env->startSection('content'); ?>
<style>
    .bg-gradient-fast-blue-purple img{ width:333px; height:333px;}
</style>
<main class="main">
        <section class="half-section bg-light-gray parallax" data-parallax-background-ratio="0.5" style="background-image:url('images/portfolio-bg2.jpg');">
            <div class="container">
                <div class="row justify-content-center">
                <!-- <div class="col-12 col-md-7 text-center margin-4-rem-bottom sm-margin-3-rem-bottom wow animate__fadeIn"> -->
                    <div class="container pt-5"> 
                        <div class="row justify-content-center">
                            <div class="col-12 col-xl-8 col-lg-10 text-center overlap-gap-section">
                                <div class="w-40px h-2px bg-gradient-orange-pink separator-line-vertical margin-30px-tb d-inline-block"></div>
                                <h3 class="alt-font font-weight-500 text-extra-dark-gray letter-spacing-minus-1px">Notícias</h3>
                                <p><a href="/<?php echo e($selected_language->code); ?>/">Início</a> | Notícias</p>
                                <!-- <h3 class="alt-font font-weight-500 text-extra-dark-gray letter-spacing-minus-1px"><?php echo e($new->title); ?><span class="text-gradient-orange-pink font-weight-600"><?php echo e($new->title); ?></span></h3> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end page title -->
        <!-- start section --> 
        <section class="bg-light-gray pt-0 padding-ten-lr xl-padding-two-lr lg-padding-three-lr sm-no-padding-lr">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 blog-content">
                        <ul class="blog-clean blog-wrapper grid grid-loading grid-4col xl-grid-4col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-extra-large">
                            <li class="grid-sizer"></li>
                            <!-- start blog item -->
                            <?php
							//$news = array();
							?>
							<?php $__empty_1 = true; $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li class="grid-item fashion wow animate__fadeIn">
                                <div class="blog-post text-center border-radius-6px bg-white box-shadow box-shadow-large-hover">
                                    <div class="blog-post-image bg-gradient-fast-blue-purple">
                                        <a href="/<?php echo e($selected_language->code); ?>/news/<?php echo e($article->id); ?>"><img src="<?php echo e($article->photo_path); ?>" alt="<?php echo e($article->title); ?>" >
                                            <div class="blog-rounded-icon bg-white border-color-white absolute-middle-center">
                                                <i class="feather icon-feather-arrow-right text-extra-dark-gray icon-extra-small"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="post-details padding-30px-all xl-padding-25px-lr">
                                        <a href="/<?php echo e($selected_language->code); ?>/news/<?php echo e($article->id); ?>" class="post-author text-medium text-uppercase"><?php echo e($article->date); ?></a>
                                        <a href="/<?php echo e($selected_language->code); ?>/news/<?php echo e($article->id); ?>" class="text-extra-dark-gray font-weight-500 alt-font d-block"><?php echo e($article->title); ?></a>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
							<?php endif; ?>
                            
                        </ul>
                        
                    </div>                   
                </div>
            </div>
        </section>
</main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/news/index.blade.php ENDPATH**/ ?>