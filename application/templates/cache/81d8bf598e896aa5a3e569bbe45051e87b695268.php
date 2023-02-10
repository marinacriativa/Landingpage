
<?php $__env->startSection('content'); ?>
<section class="page-title pattern" style="background-image: url(/static/images/bg/02.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-name">
                    <h1>CORPOS SOCIAIS</h1>
                    <p></p>
                </div>
                <ul class="page-breadcrumb">
                    <li><a href="#"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-double-right"></i></li>
                    <li><span>Corpos Sociais</span> </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-lg-7">
            <div class="title mb-30" >
                <h5></h5>
            </div>
            <br>
            <h3 class="mb-40" align="center">Órgãos Sociais para o triénio 2018/2020:</h3>

            <h2 align="center">Direção:</h2>
            <div class="accordion plus-icon shadow mb-30">
                <div class="acd-group">
                    <a href="#" class="acd-heading"><b>Efectivos</b></a>
                    <div class="acd-des"><p></p>
                        <? echo nl2br($orgaos["direcao_efetivos"]) ?>
                    </div>
                    <div class="acd-group">
                        <a href="#" class="acd-heading"><b>Suplentes</b></a>
                        <div class="acd-des"><p></p>
                            <? echo nl2br($orgaos["direcao_suplentes"]) ?>
                        </div>
                    </div>
                </div>
            </div>






            <div class="title mb-30">
                <h5></h5>
            </div>
            <h2 align="center">Mesa da Assembleia:</h2>
            <div class="accordion plus-icon shadow mb-30">
                <div class="acd-group">
                    <a href="#" class="acd-heading"><b>Efectivos</b></a>
                    <div class="acd-des"><p></p>
                        <? echo nl2br($orgaos["mag_efetivos"]) ?>

                    </div>
                    <div class="acd-group">
                        <a href="#" class="acd-heading"><b>Suplentes</b></a>
                        <div class="acd-des"><p></p>
                            <? echo nl2br($orgaos["mag_suplentes"]) ?>

                        </div>
                    </div>
                </div>

            </div>


            <div class="title mb-30">
                <h5></h5>
            </div>



            <h2 align="center">Conselho Fiscal:</h2>
            <div class="accordion plus-icon shadow mb-30">
                <div class="acd-group">
                    <a href="#" class="acd-heading"><b>Efectivos</b></a>
                    <div class="acd-des"><p></p>
                        <? echo nl2br($orgaos["fiscal_efetivos"]) ?>

                    </div>
                    <div class="acd-group">
                        <a href="#" class="acd-heading"><b>Suplentes</b></a>
                        <div class="acd-des"><p></p>
                            <? echo nl2br($orgaos["fiscal_suplentes"]) ?>

                        </div>
                    </div>


                </div>
            </div>
        </div>





        <div class="col-lg-5">

            <img src="/static/images/os3.jpg" style="margin-top:50px" alt="sociais">
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/socialentities.blade.php ENDPATH**/ ?>