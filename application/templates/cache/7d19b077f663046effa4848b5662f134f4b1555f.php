
<?php $__env->startSection('title', $construction->name); ?>
<?php $__env->startSection('pageclass'); ?>
    <style>
        #link4 a {
            color: #C57642 !important;
        }

        #link4::after {
            content: '';
            background-color: #C57642;
            height: 2px;
            width: 60%;
            top: 49%;
            left: 20%;
            position: absolute;
        }
    </style>
    <div class="orb-page-frame orb-blog-4">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <div class="orb-content">
            <div class="orb-grid">
                <!-- imagem lado esquerdo -->
                <div class="orb-g-40 orb-sm-100">
                    <div class="rb-object-frame">
                        <div class="orb-photo-frame orb-obj-1">
                            <img src="<?php echo e($construction->photo); ?>" alt="photo"> <!-- Link para imagem base dados -->
                        </div>
                        <!-- Titulo imagem -->
                        

                    </div>

                </div>
                <div class="orb-g-60 orb-sm-100">
                    <div class="orb-blog-frame">
                        <div class="orb-post-text">

                            <h2><?php echo e($construction->name); ?></h2> <!-- link para titulo noticia da base dados-->
                            <p><?php echo $construction->details; ?></p> <!-- link para descrição da noticia base dados  -->

                            <h2 class="mb-0">Galeria</h2>

                            <div>

                                <span class="orb-line"><br>

                                    <a target="_blank" href="#" data-no-swup class="a2a_button_instagram instagram"
                                        style="padding: 0.5rem 5.1rem 1rem 0rem; float:right; margin-top: -4rem;">
                                        <img src="/static/images/ui/instagram-2.svg" alt="Instagram">
                                    </a><i class="sharepub">
                                        <a target="_blank" href="https://br.pinterest.com/nadyellef/" data-no-swup
                                            class="a2a_button_pinterest pinterest"
                                            style="padding: 0.5rem 2.2rem 1rem 1rem; float:right; margin-top: -4rem;">
                                            <img src="/static/images/ui/pintrest.svg" alt="pinterest">
                                        </a><i class="sharepub">
                                </span>
                                <script async src="https://static.addtoany.com/menu/page.js"></script>
                            </div>
                            <?php $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row"
                                    style="display: inline-block; flex-direction: row; width:45%; margin-right:25px; margin-top: 25px;">
                                    <?php if($gallery->isvideo == 0): ?>
                                        <div class="col-sm">
                                            <div class="orb-object-frame">
                                                <div class="orb-photo-frame orb-obj-1 orb-active">
                                                    <!-- link para as imagens da correspondentes á noticia -->
                                                    <img src="<?php echo e($gallery->path); ?>" alt="Sem Imagem">
                                                    <a data-fancybox="gallery" data-no-swup="" href="<?php echo e($gallery->path); ?>"
                                                        class="orb-zoom"><img src="/static/images/ui/zoom.svg"
                                                            alt="zoom"></a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <video controls autoplay loop muted width="405" height="300">
                                            <source src="<?php echo e($gallery->papth); ?>">
                                        </video>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <!-- footer para data e partilha -->
                        <div class="orb-post-footer">
                            <div class="orb-date"><?php echo e($construction->price); ?></div>
                            <div class="orb-share">
                                <?php if(isset($construction->duration) && !empty($construction->duration)): ?>
                                    <span>Duração: <?php echo e($construction->duration); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/constructions/page.blade.php ENDPATH**/ ?>