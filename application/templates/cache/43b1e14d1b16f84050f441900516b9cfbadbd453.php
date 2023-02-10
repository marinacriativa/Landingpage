
<?php $__env->startSection('title', '404'); ?>
<?php $__env->startSection('content'); ?>
<!-- <div class="error-content text-center" style="background-image: url(assets/images/backgrounds/error-bg.jpg)">
    <div class="container">
        <h1 class="error-title"><?php echo e(ucfirst($translations["frontoffice"]["page_not_found_title"])); ?></h1>
        <p><?php echo e(ucfirst($translations["frontoffice"]["page_not_found_description"])); ?></p>
        <a href="/<?php echo e($selected_language->code); ?>/" class="btn btn-outline-primary-2 btn-minwidth-lg">
            <span><?php echo e(ucfirst($translations["frontoffice"]["page_not_found_btn_goMainPage"])); ?></span>
            <i class="icon-long-arrow-right"></i>
        </a>
    </div>
</div> -->

<section class="p-0 cover-background wow animate__fadeIn" style="background-image:url('images/404-bg.jpg');">
           <div class="container">
               <div class="row align-items-stretch justify-content-center full-screen">
                   <div class="col-12 col-xl-6 col-lg-7 col-md-8 text-center d-flex align-items-center justify-content-center flex-column">
                       <h6 class="alt-font text-fast-blue font-weight-600 letter-spacing-minus-1px margin-10px-bottom text-uppercase"><?php echo e(ucfirst($translations["frontoffice"]["error_page_title"])); ?></h6>
                       <h1 class="alt-font text-extra-big font-weight-700 letter-spacing-minus-5px text-extra-dark-gray margin-6-rem-bottom md-margin-4-rem-bottom">404</h1>
                       <span class="alt-font font-weight-500 text-extra-dark-gray d-block margin-20px-bottom"><?php echo e(ucfirst($translations["frontoffice"]["error_page_text"])); ?></span>
                       <a href="/<?php echo e($selected_language->code); ?>/" class="btn btn-fancy btn-large btn-olivine-green btn-round-edge w-60 no-margin-bottom">
                        <?php echo e(ucfirst($translations["frontoffice"]["error_page_btn"])); ?>

                       </a>
                   </div>
               </div>
           </div>
       </section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/404.blade.php ENDPATH**/ ?>