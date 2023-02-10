
<?php $__env->startSection('content'); ?>
    <div class="intro intro-small">
        <div class="intro-image fullsize-image-container" data-stellar-background-ratio="0.54">
            <img src="/static/images/3.jpg" class="fullsize-image" alt="" />
        </div><!-- /.intro-image -->

        <div class="row">
            <div class="intro-caption">
                <h5>Clinipousos </h5>

                <h2>Perguntas Frequentes</h2>
            </div><!-- /.intro-caption -->
        </div><!-- /.row -->
    </div><!-- /.intro intro-small -->

    <div class="main grey" itemscope itemtype="https://schema.org/BlogPosting">
        <div class="row">
            <div class="columns large-12">
                <p class="breadcrumbs">
                    <a href="/">Home</a>

                    <span>
                        <i class="fa fa-angle-right"></i>
                    </span>

                    <a href="/<?php echo e($selected_language->code); ?>/faq" class="current">Faqs</a>
                </p><!-- /.breadcrumbs -->
            </div><!-- /.columns large-12 -->

            <h3>Perguntas | Repostas</h3><!-- /.section-default-title -->
            <br>
            <dl class="accordion" data-accordion>
                <dd class="accordion-navigation">
                    <a href="#panel1b">A Amálgama dentária, vulgarmente conhecida como chumbo, é perigosa?</a>
                    <div id="panel1b" class="content">
                        De acordo com estudos científicos aprovados pela Direcção Geral para a Saúde e Consumidor da
                        Comissão Europeia (CE) não existe justificação clínica para a remoção de restaurações em amálgama,
                        clinicamente satisfatórias, excepto nos casos de doentes alérgicos aos seus componentes.

                    </div>
                </dd>
                <dd class="accordion-navigation">
                    <a href="#panel2b">A partir de que idade devo levar o meu filho ao dentista?</a>
                    <div id="panel2b" class="content">
                        A partir da altura em nasce o primeiro dente decíduo - “de leite”, os pais devem levar os filhos ao
                        dentista, tendo o cuidado de higienizar a cavidade oral desde o nascimento. É importante estabelecer
                        um programa preventivo e interceptar hábitos que sejam prejudiciais. Além de observar o estado de
                        saúde oral, a consulta de medicina dentária ajuda a melhorar as técnicas de escovagem e são dadas
                        todas as instruções sobre higiene oral. Estas visitas servem também para criar um ambiente de
                        confiança e à vontade entre a criança e o médico.

                    </div>
                </dd>
                <dd class="accordion-navigation">
                    <a href="#panel3b">Fazer uma limpeza (destartarização) desgasta os dentes?</a>
                    <div id="panel3b" class="content">
                        Não, não há qualquer problema em fazer destartarizações regulares. Passar muito tempo sem o fazer é
                        que pode ser prejudicial para os dentes pois pode aparecer uma gengivite (infecção generalizada das
                        gengivas), ou até mesmo aparecer uma periodontite de nome popular “piorreia” (doença das gengivas e
                        osso) podendo levar à queda dos dentes.

                    </div>
                </dd>
                <dd class="accordion-navigation">
                    <a href="#panel4b">É normal que a gengiva sangre?</a>
                    <div id="panel4b" class="content">
                        Não. O sinal que mais precocemente nos avisa da existência de problemas gengivais é a ocorrência de
                        sangramento espontâneo ou durante/após a escovagem. Uma gengiva que sangra pode apresentar uma
                        gengivite (inflamação gengival) ou uma periodontite (doença da gengiva e osso).
                    </div>
                </dd>
                <dd class="accordion-navigation">
                    <a href="#panel5b">Durante a gravidez os dentes enfraquecem porque há perda de cálcio para o bebé?</a>
                    <div id="panel5b" class="content">
                        Não. O cálcio está presente nos dentes da mãe, de forma estável e cristalina, não sendo disponível
                        para a circulação sistémica. A gravidez não propicia aumento de incidência de cárie dentária pode
                        apenas e devido às alterações hormonais, a gengiva doer e sangrar facilmente. Esta situação
                        agrava-se se não existirem cuidados adequados de higiene oral.
                    </div>
                </dd>
                <dd class="accordion-navigation">
                    <a href="#panel6b">Os branqueamentos dentários são eficazes e seguros?</a>
                    <div id="panel6b" class="content">
                        Existem hoje diversos materiais e técnicas de branqueamento. O cuidado passa pela selecção e uso
                        correcto para que haja um resultado seguro. Embora existam disponíveis no mercado diversas opções,
                        aconselhe-se com o seu médico dentista sobre o assunto. Opte por um produto certificado e sujeito a
                        controlo.
                    </div>
                </dd>
            </dl>

            <br><br>
        </div><!-- /.row -->
        <br><br>
        <div class="row">
            <div class="ad">
                <div class="ad-image mobile-hidden">
                    <img src="/static/images/logos/icon.png" alt="" />
                </div><!-- /.ad-image -->

                <header class="ad-head">
                    <h3>Marque a Sua Consulta </h3>

                    <p>Dispomos de um método fácil e rápido para a marcação de consultas.</p>
                </header><!-- /.ad-head -->

                <div class="ad-actions">
                    <a href="/<?php echo e($selected_language->code); ?>/#section-book-appointment" class="button btn-white btn-small">Marque Agora</a>
                </div><!-- /.ad-actions -->

                <div class="ad-contacts">
                    <p class="phone">
                        <i class="fa fa-mobile"></i>
                        <small>Marcar através de chamada</small>
                        <a href="tel: 244 856 831">244 856 831</a>
                        *(Custo de chamada para rede móvel)
                    </p><!-- /.phone -->
                </div><!-- /.ad-contacts -->
            </div><!-- /.ad -->
        </div><!-- /.row -->
    </div><!-- /.main -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/faq.blade.php ENDPATH**/ ?>