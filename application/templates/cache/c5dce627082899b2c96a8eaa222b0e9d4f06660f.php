
<?php $__env->startSection('title', 'Serviços'); ?>
<?php $__env->startSection('pageclass'); ?>
    <style>
        #link3 {
            color: #C57642 !important;
        }

        #link3::after {
            content: '';
            background-color: #C57642;
            height: 2px;
            width: 60%;
            top: 49%;
            left: 20%;
            position: absolute;
        }
    </style>
    <div class="orb-scroll-frame">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <div class="orb-banner">
            <h1>Serviços</h1>
        </div>
        <div class="orb-blog-list">
            <div class="orb-grid orb-padding-grid">
                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="orb-g-25 orb-md-50 orb-sm-100">
                        <a href="/<?php echo e($selected_language->code); ?>/services/<?php echo e($service->slug); ?>" class="orb-blog-card">
                            <div class="orb-photo-frame orb-active">
                                <img src="<?php echo e($service->front); ?>" alt="<?php echo e($service->title); ?>">
                            </div>
                            <div class="orb-post-text">
                                <h2><?php echo e($service->title); ?></h2>
                                <p><?php echo mb_strimwidth($service->details, 0, 65, '...'); ?></p>
                                <div class="orb-date">
                                    <div class="button1">
                                        
                                        Ver projetos
                                        
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/services/index.blade.php ENDPATH**/ ?>