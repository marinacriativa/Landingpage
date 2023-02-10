
<?php $__env->startSection('content'); ?>
    <style>
        /* .modal-backdrop {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1;
            background-color: #000;
        } */
        #overlay1 {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            background-color: #000;
            opacity: 0.7;
            filter: alpha(opacity=70) !important;
            display: none;
            z-index: 100;
        }

        #overlayContent1 {
            position: fixed;
            width: 100%;
            top: 100px;
            text-align: center;
            display: none;
            overflow: hidden;
            z-index: 100;
        }

        #contentGallery1 {
            margin: 0px auto;
        }

        #imgBig1,
        #imgSmall1 {
            cursor: pointer;
        }

        .imgh {
            position: relative;
            /* margin-top: 50px; */
            width: 340px;
            margin-right: 30px;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            color: #FFF;
            background: rgba(0, 0, 0, 0);
            transition: background 0.5s ease;
        }

        .imgh:hover .overlay {
            display: block;
            background: rgba(0, 0, 0, .3);
        }

        .imgh:hover .title {
            top: 90px;
        }

        .button1 {
            position: absolute;
            width: 340px;
            left: 0;
            margin: 0px;
            top: 100px;
            text-align: center;
            opacity: 0;
            color: #fff;
            transition: opacity .35s ease;
            background-color: rgba(255, 255, 255, 0) !important;
        }

        .button1 a {
            width: 200px;
            padding: 4px 30px;
            text-align: middle;
            color: white;
            border: solid 1px #fff;
            border-radius: 10px;
            color: #fff;
            z-index: 0;
        }

        .imgh:hover .button1 {
            opacity: 1;
        }

        #content .container {
            position: initial;
        }
    </style>
    <main>
        <section id="slider" class="slider-element swiper_wrapper full-screen clearfix" data-loop="true"
            data-autoplay="99000">

            <div class="swiper-container swiper-parent">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" style="background-image: url('/static/images/slider/1.jpg');">
                        <div class="container clearfix">
                            <div class="slider-caption slider-caption-left" style="max-width: 700px;">
                                <h2 data-caption-animate="flipInX">clínica dentária <span>POMBAL</span></h2>
                                <p class="d-none d-sm-block" data-caption-animate="flipInX" data-caption-delay="500">Há 20
                                    anos a construir sorrisos e a motivar para a saúde oral.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="content">
            <div class="content-wrap">
                <div class="container clearfix">
                    <div class="heading-block center nobottomborder">
                        <h3>
                            <span><b>serviços</b></span>
                        </h3>
                        <span>Medicina Dentária</span>
                    </div>
                    <div class="col_one_third">
                        <div class="feature-box fbox-plain">
                            <div class="fbox-icon" data-animate="bounceIn">
                                <a href="#"><i class="icon-medical-i-social-services"></i></a>
                            </div>
                            <h3>Plano Familiar</h3>
                            <p>Planos de familia adapatados às suas necessidades.</p>
                        </div>
                    </div>
                    <div class="col_one_third">
                        <div class="feature-box fbox-plain">
                            <div class="fbox-icon" data-animate="bounceIn" data-delay="200">
                                <a href="#"><i class="icon-medical-i-dental"></i></a>
                            </div>
                            <h3>Tratamentos Dentários</h3>
                            <p>Profissionais empenhados e experientes.</p>
                        </div>
                    </div>
                    <div class="col_one_third col_last">
                        <div class="feature-box fbox-plain">
                            <div class="fbox-icon" data-animate="bounceIn" data-delay="400">
                                <a href="#"><i class="icon-medical-i-imaging-root-category"></i></a>
                            </div>
                            <h3>Raio-X</h3>
                            <p>Tecnologia avançada para uma melhor resposta.</p>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div id="oc-team"></div>
                </div>
            </div>
            <div id="overlay1" onclick="fecha()"></div>
            <div id="overlayContent1" onclick="fecha()">
                <img id="imgBig1" onclick="fecha()" src="" alt="" width="400" />
            </div>
            <div class="section notopmargin">
                <div class="container clearfix">
                    <div class="heading-block center nobottomborder">
                        <h3><span><b>a Equipa</b></span></h3>
                        <span>Profissionais experientes e dedicados.</span>
                    </div>
                    <div id="pictures" class="owl-carousel team-carousel carousel-widget" data-margin="30" data-nav="true"
                        data-pagi="true" data-items-xs="1" data-items-sm="1" data-items-lg="2" data-items-xl="3">
                        <div class="team">
                            <!-- onclick="abre('/static/images/doctors/5.png')"-->
                            <div class="imgh">
                                <img src="/static/images/doctors/6.png" alt="Catarina cid">
                                <div class="overlay">
                                    <div class="button1">
                                        <a data-toggle="modal" href="#myModal2">Saiba mais...</a>
                                    </div>
                                </div>
                            </div>
                            <p align="center"><b>Médica Dentista</b><br>Dra. Catarina Cid</p>
                        </div>

                        <div class="team">
                            <div class="imgh">
                                <img src="/static/images/doctors/7.png" alt="ana castelo">
                                <div class="overlay">
                                    <div class="button1">
                                        <a data-toggle="modal" href="#myModal3">Saiba mais...</a>
                                    </div>
                                </div>
                            </div>
                            <p align="center"><b>Médica Dentista</b><br>Dra. Ana Castelo</p>
                        </div>
                        <div class="team">
                            <!-- onclick="abre('/static/images/doctors/5.png')"-->
                            <div class="imgh">
                                <img src="/static/images/doctors/5.png" alt="Assistente dentária">
                                <div class="overlay">
                                    <div class="button1">
                                        <a data-toggle="modal" href="#myModal4">Saiba mais...</a>
                                    </div>
                                </div>
                            </div>
                            <p align="center"><b>Assistente dentária</b><br>Ana Paula</p>
                        </div>
                    </div>
                    <div id="oc-inst">
                    </div>
                </div>
                <div class="section notopmargin" style="background: #fff;">
                    <div class="container clearfix">
                        <div class="heading-block center nobottomborder">
                            <h3><span><b>a clínica</b></span></h3>
                            <span>Investimos na qualidade da nossa tecnologia, e em profissionais de excelência para que o
                                seu sorriso fique em boas mãos.</span>
                        </div>
                        <div id="pictures" class="owl-carousel team-carousel carousel-widget" data-margin="30"
                            data-nav="true" data-pagi="true" data-items-xs="1" data-items-sm="2" data-items-lg="3"
                            data-items-xl="4">
                            <div class="team" onclick="abre('/static/images/doctors/1.jpg')">
                                <div class="team-image">
                                    <img src="/static/images/doctors/1.jpg" alt="dentista pombal">
                                </div>
                            </div>
                            <div class="team" onclick="abre('/static/images/doctors/5.jpg')">
                                <div class="team-image">
                                    <img src="/static/images/doctors/2.jpg" alt="dentista leiria">
                                </div>
                            </div>
                            <div class="team" onclick="abre('/static/images/doctors/3.jpg')">
                                <div class="team-image">
                                    <img src="/static/images/doctors/3.jpg" alt="implantes dentarios">
                                </div>
                            </div>
                            <div class="team" onclick="abre('/static/images/doctors/4.jpg')">
                                <div class="team-image">
                                    <img src="/static/images/doctors/4.jpg" alt="dentes">
                                </div>
                            </div>
                            <div class="team" onclick="abre('/static/images/doctors/6.jpg')">
                                <div class="team-image">
                                    <img src="/static/images/doctors/6.jpg" alt="pombal">
                                </div>
                            </div>
                            <div class="team" onclick="abre('/static/images/doctors/7.jpg')">
                                <div class="team-image">
                                    <img src="/static/images/doctors/7.jpg" alt="desvitalizacao">
                                </div>
                            </div>
                            <div class="team" onclick="abre('/static/images/doctors/8.jpg')">
                                <div class="team-image">
                                    <img src="/static/images/doctors/8.jpg" alt="clínica dentária">
                                </div>
                            </div>
                        </div>
                        <div id="oc-consult"></div>
                    </div>
                </div>

                <div class="section notopmargin"
                    style="background: #FFF url('/static/images/about-us/1.jpg') right center no-repeat / cover;">

                    <div class="d-block d-md-block d-lg-none"
                        style="background-color: rgba(238,238,238,0.9); position: absolute; top: 0;left: 0; z-index: 1;width: 100%; height: 100%;">
                    </div>

                    <div class="container clearfix">

                        <div class="row clearfix">
                            <div class="col-lg-5" data-lightbox="gallery">
                                <div class="heading-block nobottomborder bottommargin-sm">
                                    <h3 class="nott ls0">Acordos</h3>
                                </div>
                                <p>A Clínica Dentária Catarina Cid dispõe de alguns acordos com entidades para o servir
                                    melhor</p>
                                <div class="feature-box fbox-plain">
                                    <div class="fbox-icon" data-animate="fadeIn">
                                        <a href="#"><i class="icon-check"></i></a>
                                    </div>
                                    <p>SAMS Quadros</p>
                                </div>

                                <div class="feature-box fbox-plain">
                                    <div class="fbox-icon" data-animate="fadeIn">
                                        <a href="#"><i class="icon-check"></i></a>
                                    </div>
                                    <p>SAMS SIB</p>
                                </div>

                                <div class="feature-box fbox-plain bottommargin-sm">
                                    <div class="fbox-icon" data-animate="fadeIn">
                                        <a href="#"><i class="icon-check"></i></a>
                                    </div>
                                    <p>Cheque dentista (Crianças e idosos)</p>
                                </div>
                                <div class="feature-box fbox-plain bottommargin-sm">
                                    <div class="fbox-icon" data-animate="fadeIn">
                                        <a href="#"><i class="icon-check"></i></a>
                                    </div>
                                    <p>Cheque dentista PIPCO
                                        (Programa intervenção precoce cancro oral)</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="opening-table">
                                    <div class="heading-block bottommargin-sm nobottomborder">
                                        <h4>O Nosso Horário</h4>
                                        <span>A Clínica têm serviço de urgência.</span>
                                    </div>
                                    <div class="time-table-wrap clearfix">
                                        <div class="row time-table">
                                            <h5 class="col-lg-5">Segunda-Feira</h5>
                                            <span class="col-lg-7">9:30am - 13:00pm | 14:30 - 19:00</span>
                                        </div>
                                        <div class="row time-table">
                                            <h5 class="col-lg-5">Terça- Feira</h5>
                                            <span class="col-lg-7">9:30am - 13:00pm | 14:30 - 16:00</span>
                                        </div>
                                        <div class="row time-table">
                                            <h5 class="col-lg-5">Quarta-Feira</h5>
                                            <span class="col-lg-7">9:30am - 13:00pm | 14:30 - 19:00</span>
                                        </div>
                                        <div class="row time-table">
                                            <h5 class="col-lg-5">Quinta-Feira</h5>
                                            <span class="col-lg-7">9:30am - 13:00pm | 14:30 - 19:00</span>
                                        </div>
                                        <div class="row time-table">
                                            <h5 class="col-lg-5">Sexta-Feira</h5>
                                            <span class="col-lg-7">9:30am - 13:00pm | 14:30 - 19:00</span>
                                        </div>
                                        <div class="row time-table">
                                            <h5 class="col-lg-5">Sábado</h5>
                                            <span class="col-lg-7">9:30am - 13:00pm | 14:30 - 19:00</span>
                                        </div>
                                        <div class="row time-table">
                                            <h5 class="col-lg-5">Domingo</h5>
                                            <span class="col-lg-7 color t600">Encerrado</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="oc-appointment"></div>
                    </div>

                </div>




                <div class="section row nopadding common-height dark topmargin-sm">
                    <div class="col-lg-5" data-height-xl="597" data-height-lg="614" data-height-md="400"
                        data-height-sm="300" data-height-xs="200"
                        style="background: url('/static/images/section-bg.jpg') center center no-repeat; background-size: cover;">
                        <div>&nbsp;</div>
                    </div>
                    <div id="booking-appointment-form" class="col-lg-7 nopadding">
                        <div class="bgcolor contact-widget col-padding" data-loader="button"
                            style="background-color: #fff !important;">
                            <h2>Marque <span> a sua consulta</span></h2>
                            <div class="contact-form-result"></div>
                            <form class="nobottommargin" id="form" name="template-medical-form" method="post">
                                <div class="col_two_third">
                                    <label for="template-medical-name">Nome:</label>
                                    <input type="text" id="template-medical-name" name="name"
                                        class="form-control not-dark required" value="" required>
                                </div>
                                <div class="col_one_third col_last">
                                    <label for="template-medical-phone">Contacto:</label>
                                    <input type="text" id="template-medical-phone" name="phone"
                                        class="form-control not-dark required" value="" required>
                                </div>
                                <div class="clear"></div>
                                <div class="col_two_third">
                                    <label for="template-medical-email">Email:</label>
                                    <input type="email" id="template-medical-email" name="email"
                                        class="form-control not-dark required" value="" required>
                                </div>
                                <div class="col_one_third col_last">
                                    <label for="template-medical-dob">Data de nascimento:</label>
                                    <input type="date" id="template-medical-dob" name="custom_1"
                                        class="form-control not-dark required" value="" placeholder="dd/mm/aaaa"
                                        required>
                                </div>
                                <div class="clear"></div>
                                <div class="col_two_fifth nobottommargin">
                                    <div class="col_full">
                                        <label for="template-medical-appoint-date">Data pretendida para consulta:</label>
                                        <input type="date" id="template-medical-appoint-date" name="custom_2"
                                            class="form-control not-dark required" value=""
                                            placeholder="dd/mm/aaaa" required>
                                    </div>
                                    <div class="col_full nobottommargin">
                                        <label for="template-medical-second-booking">É nosso Paciente?</label><br>
                                        <label class="rightmargin-sm">
                                            <input type="radio" id="template-medical-second-booking" name="custom_3"
                                                value="Sim">
                                            Sim
                                        </label>
                                        <label>
                                            <input type="radio" name="custom_3" value="Não" checked>
                                            Não
                                        </label>
                                    </div>
                                </div>
                                <div class="col_three_fifth nobottommargin col_last">
                                    <label for="template-medical-message">Mensagem:</label>
                                    <textarea id="template-medical-message" name="description" class="form-control not-dark required" required
                                        cols="30" rows="5"></textarea>
                                </div>
                                <div class="clear"></div>
                                <div class="col_full hidden">
                                    <input type="text" name="template-medical-botcheck" value="" />
                                </div>
                                <div class="col_full topmargin-sm nobottommargin">
                                </div>
                                <div class="clear"></div>

                                <div class="col_full nobottommargin">
                                    <p><input type="checkbox"></input> Autorizo o tratamento pela CatarinaCid dos meus
                                        dados pessoais nos termos do Regulamento Geral de Proteção de Dados (RGPD)</p>
                                </div>

                            </form>
                            <p id="reply" style=""></p>
                            <button  id="btn-enviar submit" class="button  button-rounded button-white button-light nomargin  submit">Enviar pedido</button>
                                <div class="recaptcha" style="visibility:hidden;"></div>
                        </div>
                        
                    </div>
                </div>
                <div id="oc-contacts"></div>
                <div class="promo promo-flat promo-dark promo-full uppercase footer-stick">
                    <div class="container clearfix">
                        <h3 style="letter-spacing: 2px;">O SEU DENTISTA EM POMBAL</h3>
                        <span class="nott">Na nossa Clínica vai encontrar quem ouça as suas dúvidas e motivações, estude
                            as suas necessidades e lhe proponha uma solução individualizada.</span>
                        <a href="#"
                            class="button button-large button-border button-rounded button-light button-white">Contacte-nos</a>
                    </div>
                </div>


        </section>


    </main>





    <!-- Modal1 -->

    <!-- Modal2 -->
    <div class="modal fade" id="myModal2" role="dialog" style="padding-top:100px">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Drª Catarina Cid</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p><b>Currículo Resumido</b></p>
                    <p>• Cédula Profissional nº. 2713 da Ordem dos Médicos Dentistas.<br>
                        • Licenciatura em Medicina Dentária pela Faculdade de Medicina da Universidade de Coimbra
                        (1992-1999).<br>
                        • I Curso de Cirurgia Oral - Centro de Formação em Saúde, coordenado p/ Prof Dr. Francisco Salvado
                        (2000-2001);<br>
                        • Máster em Implantologia Straumann - Centro de Estudos do Amial, coordenado p/ Prof. Dr. Manuel
                        Neves (2005-2006);<br>
                        • Advanced Course in Implant Dentistry (ITI Dental Implant System)- Universidade de Berna (2006)<br>
                        • Curso Teórico de Selecção/calibragem em diagnóstico diferencial de cancro oral e biópsias da
                        cavidade oral (2014)<br>
                        • Participação em diversos Congressos, Reuniões Científicas e Cursos de Formação Contínua nacionais
                        e internacionais. </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal3 -->
    <div class="modal fade" id="myModal3" role="dialog" style="padding-top:100px">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Dra. Ana Castelo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p><b>Currículo Resumido</b></p>
                    <p>• Cédula Profissional nº. 2713 da Ordem dos Médicos Dentistas.<br>
                        • Licenciatura em Medicina Dentária pela Faculdade de Medicina da Universidade de Coimbra
                        (1992-1999).<br>
                        • I Curso de Cirurgia Oral - Centro de Formação em Saúde, coordenado p/ Prof Dr. Francisco Salvado
                        (2000-2001);<br>
                        • Máster em Implantologia Straumann - Centro de Estudos do Amial, coordenado p/ Prof. Dr. Manuel
                        Neves (2005-2006);<br>
                        • Advanced Course in Implant Dentistry (ITI Dental Implant System)- Universidade de Berna (2006)<br>
                        • Curso Teórico de Selecção/calibragem em diagnóstico diferencial de cancro oral e biópsias da
                        cavidade oral (2014)<br>
                        • Participação em diversos Congressos, Reuniões Científicas e Cursos de Formação Contínua nacionais
                        e internacionais. </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="https://google.com/recaptcha/api.js?onload=initRecaptcha&render=explicit"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            $("#form").submit(function(e) {
                e.preventDefault();
                if (grecaptcha.getResponse() !== 0) {
                    grecaptcha.execute();
                }
            });
            /**
             * Init recaptcha
             */
            if (typeof grecaptcha !== 'undefined') {
                var reCaptchaIDs = [];
                initRecaptcha = function() {
                    jQuery('.recaptcha').each(function(index, el) {
                        var container = jQuery(this).parents('#form');
                        var tempID = grecaptcha.render(el, {
                            'sitekey': '<?php echo e($website_config->recaptcha_site_key); ?>',
                            'theme': 'light',
                            'badge': 'inline',
                            'size': 'invisible',
                            'callback': function(
                                token) { // We may need the token later, who knows!
                                globalFormsAjax(token, container);
                            }
                        });
                        reCaptchaIDs.push(tempID);
                    });
                };
                //Reset reCaptcha
                var recaptchaReset = function() {
                    if (typeof reCaptchaIDs != 'undefined') {
                        var arrayLength = reCaptchaIDs.length;
                        for (var i = 0; i < arrayLength; i++) {
                            grecaptcha.reset(reCaptchaIDs[i]);
                        }
                    }
                };
            }
            /**
             * The callback
             **/
            var globalFormsAjax = function(token, container) {
                $.ajax({
                    url: "/booking", // Validate the recaptcha challenge
                    method: "POST",
                    dataType: 'json',
                    data: container.serialize(),
                    beforeSend: function(xhr) {
                        // Show our loader
                        container.append(
                            '<div class="loading-container"><div class="loading-spinner"><div class="circle_01"></div><div class="circle_02"></div><div class="circle_03"></div><div class="circle_04"></div><div class="circle_05"></div><div class="circle_06"></div><div class="circle_07"></div><div class="circle_08"></div></div></div>'
                        );
                        container.addClass('ajax-loader');
                    },
                    success: function(data) {
                        // Stop the loader
                        container.removeClass('ajax-loader');
                        container.children('.loading-container').remove();
                        if (data.success) {
                            alert("Sucesso!");
                        } else {
                            alert("Erro ao submeter pedido de reserva");
                        }
                        // Reset recaptcha challenge if it's here
                        if (typeof grecaptcha !== 'undefined') {
                            recaptchaReset();
                        }
                        // Reset the form fields
                        resetForm(container);
                    }
                });
            }
            /**
             * Reset form fields
             **/
            var resetForm = function($form) {
                // Reset the error message
                /*$form.find('.validation-errors').stop(0,0).slideUp(500,function(){
                $(this).css('height','auto').html('');
                });*/
                $form.find('input:not([readonly]), select, textarea').val('');
                $form.find('input:radio:not([readonly]), input:checkbox:not([readonly])').removeAttr('checked')
                    .removeAttr('selected');
                $form.find(
                    'input:text, input:password, input, input:file, select, textarea, input:radio, input:checkbox'
                ).parent().find('.form-control-feedback').hide();
                $form.find('.has-feedback').removeClass('has-feedback');
                $form.find('.has-success').removeClass('has-success');
            };
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/booking.blade.php ENDPATH**/ ?>