
<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<section class="page_header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h2 class="text-uppercase">Menu</h2>
                        </div>
                    </div>
                </div>
            </section>
            <!-- menu-->
            <section class="menu space60">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-header wow fadeInDown">
                                <h1>Nosso Menu</h1>
                            </div>
                        </div>
                    </div>
                    <div class="food-menu wow fadeInUp">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="menu-tags">
                                <span data-filter="*" class="tagsort-active">Todos</span>
                                    <span data-filter=".starter">Entradas</span>
                                    <!-- estava: <span data-filter=".starter  class="tagsort-active">Entradas</span> -->
                                    <!-- a class comentada faz com que em entradas, apareça tudo o que esta em almocos, jantares e sobremensas -->
                                    <span data-filter=".lunch">Almoços e Jantares</span>
                                    <!--  <span data-filter=".dinner">Jantares</span>  -->
                                    <span data-filter=".desserts">Sobremesas</span>
                                </div>
                            </div>
                        </div>
                        <div class="row menu-items">
                            <div class="menu-item col-sm-4 col-xs-12 starter">
                              <img src="/static/images/menu/sobremesas.jpg" alt="" class="img-responsive" >
                              </div>
                              <div class="menu-item col-sm-8 col-xs-12 starter">
                                <div class="clearfix menu-wrapper">
                                    <h4>Entradas</h4>
                                </div>
                                <p>Entradas deliciosas:</p>
                                <br>
                                <p>
                                    Pão;<br> Azeitonas; <br> Morcela Grelhada;
                                    Queijos; <br>Patê atum, frango ou delícias mar; <br>Polvo; <br>Orelha; <br>
                                </p>
                            </div>
                            <div class="menu-item col-sm-8 col-xs-12 lunch">
                                <div class="clearfix menu-wrapper">
                                    <h4>Almoços e Jantares</h4>
                                </div>
                                <p>
                                    Deixe-se surpreender com os nossos pratos.<br> <br> <b>AS NOSSAS ESPECIALIDADES :</b><br> • GRELHADOS - A
                                    nossa cozinha assenta na confecção de pratos tradicionais portugueses tendo como base os grelhados.<br> • FRANGO ASSADO
                                    - Se é amante de frango assado então não irá resistir ao nosso.
                                </p>
                                <br>
                                <p>
                                    <b>CARNE</b>
                                </p>
                                <p>
                                    Frango;<br> Entrecosto;<br> Secretos Porco Preto;<br> Tiras de Churrasco de Porco Preto;<br> Costeletas
                                    de Porco, Lentrisca de Vitela;<br> Costeletas de Vitela, Costeletas de Vitela Mirandesa;<br> Picanha, Picanha
                                    Maturada;<br> Bife de Vaca;<br> Costeletas de Borrego;<br> Espetadas de Perú;<br> Coelho.<br>
                                    <br>
                                </p>
                                <p>
                                    <b>PEIXE</b>
                                </p>
                                <p>
                                    Bacalhau;<br> Dourada;<br> Peixe Espada;<br> Robalo;<br> Salmão.<br>
                                </p>
                                </div>
                                <div class="menu-item col-sm-4 col-xs-12 lunch">
                                  <img src="/static/images/menu/almocosJantares1.jpg" alt="" class="img-responsive" style="padding-bottom:20px">
                                  <img src="/static/images/menu/almocosJantares2.jpg" alt="" class="img-responsive" >
                                  </div>

                            <div class="menu-item col-sm-6 col-xs-12 desserts">
                              <img src="/static/images/menu/sobremesas.jpg" alt="sobremesa" class="img-responsive">
                            </div>
                            <div class="menu-item col-sm-6 col-xs-12 desserts">
                                <div class="clearfix menu-wrapper">
                                    <h4>Sobremesas</h4>
                                </div>
                                <p>Poderá degustar as diversas sobremesas feitas por nós:</p>
                                <br>
                                <p>
                                    Mousse de chocolate<br> Três sabores; <br> Serradura maria; <br> Serradura de oreo; <br> Baba de camelo;
                                    <br> Pannacota de frutos vermelhos; <br> Serradura de filipinos; <br> Molotoff; <br> Pudim de ovos; <br>
                                    Pudim de pão; <br> Pudim de maçã; <br> Torta de laranja; <br>Baba de camelo; <br>Bolo de bolacha.
                                </p>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/menu.blade.php ENDPATH**/ ?>