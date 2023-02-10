
<?php $__env->startSection('title', 'Serviços'); ?>
<?php $__env->startSection('pageclass'); ?>
    <?php
        $slugArray = [];
        foreach ($services as $sv) {
            $slugArray[] = $sv->slug;
        }
        
        $index = array_search($service->slug, $slugArray);
        if ($index !== false) {
            $next = isset($slugArray[$index + 1]) ? $slugArray[$index + 1] : false;
            $previous = isset($slugArray[$index - 1]) ? $slugArray[$index - 1] : false;
        }
        
    ?>
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

        @media(min-width: 1600px) {

            /* pagina servicos */
            .orb-blog-2 .orb-description-services .orb-nav-frame-services .orb-nav-services {}

            .orb-teste {
                text-align: center;
                padding: 0 20rem 0 20rem;
            }

            .orb-blog-2 .orb-content .orb-text-frame {
                padding: 20px 0px 0 0 !important;
            }

            .orb-grid-teste {
                margin-bottom: 15rem;
                width: auto;
                margin-left: 0;
                margin-right: auto;
                height: auto;
            }

            .orb-blog-2 .orb-content .orb-text-frame .orb-post-title h2 {
                font-size: 50px;
            }

            .orb-blog-2 .orb-description-services {
                bottom: 60%;
            }

            .orb-blog-2 .orb-description-services .orb-nav-frame-services .orb-nav-services .orb-next-services {
                margin-left: 92%;
            }
        }
    </style>

    <div class="orb-page-frame orb-blog-2">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>


        <div class="orb-content" data-swiper-parallax="-200" data-swiper-parallax-opacity="0">
            <!-- TITULO E DESCRIÇÃO SERVIÇOS -->
            <div class="orb-grid-teste">
                <div class="orb-g-50 orb-sm-100">
                    <div class="orb-text-frame" data-swiper-parallax-y="60" data-swiper-parallax-scale="0.5"
                        data-swiper-parallax-duration="1250">
                        <div class="orb-teste">
                            <div href="#" class="orb-post-title">
                                <h2> <?php echo e($service->title); ?> </h2>
                            </div>
                            <div class="orb-post-text postext">
                                <p> <?php echo mb_strimwidth($service->details, 0, 3000, '...'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BOTÕES NEXT AND PREV -->
            <div class="orb-description-services" style="margin-top: 3rem; margin-left: 1rem;">
                <div class="orb-nav-frame-services">
                    <div class="orb-nav-services">

                        <?php if(isset($previous) && !empty($previous) && $previous != false): ?>
                            <div class="orb-prev-services">
                                <a href="/<?php echo e($selected_language->code); ?>/services/<?php echo e($previous); ?>">
                                    <img src="/public/static/images/ui/arrow-1.svg" alt="arrow">
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="orb-prev-services">
                                <a href="#">
                                    <img src="/public/static/images/ui/excluir.svg" alt="arrow">
                                </a>
                            </div>
                        <?php endif; ?>


                        <?php if(isset($next) && !empty($next) && $next != false): ?>
                            <div class="orb-next-services nextarrowc">
                                <a href="/<?php echo e($selected_language->code); ?>/services/<?php echo e($next); ?>">
                                    <img src="/public/static/images/ui/arrow-1.svg" alt="arrow">
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="orb-next-services nextarrowc">
                                <a href="#">
                                    <img src="/public/static/images/ui/excluir.svg" alt="arrow">
                                </a>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            <!-- GALERIA DE IMAGENS -->
            <div class="orb-blog-list orb-scroll-frame2">
                <div class="orb-grid orb-padding-grid">
                    <?php if(isset($works)): ?>
                        <?php $__currentLoopData = $works; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="orb-g-25 orb-md-50 orb-sm-100">
                                <a href="/<?php echo e($selected_language->code); ?>/constructions/<?php echo e($wk->slug); ?>"
                                    class="orb-blog-card1">
                                    <div class="orb-photo-frame orb-active">
                                        <img src="<?php echo e($wk->photo); ?>" alt="<?php echo e($wk->photo); ?>">
                                    </div>
                                    <div class="orb-post-text">
                                        <h2><?php echo e($wk->name); ?></h2>
                                    </div>
                                </a>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/services/page.blade.php ENDPATH**/ ?>