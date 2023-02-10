@extends('layouts.master')
@section('content')
<section id="main" class="main">
    <div class="container-fluid fullheight">
      <div class="main-intro col-xs-12 col-md-8 col-lg-9" style="background-image:url(/static/images/backgrounds/bg4.jpg);">
        <div class="layer-black"></div>
        <div class="logo">
          <img src="/static/images/logoWhite.svg" alt="Bioalternativa - Produtos Naturais">
        </div>
        <div class="menu">
          <nav>
            <ul>
              <li><a href="#" id="about-trigger">Sobre nós</a></li>
            <!--  <li><a href="#" id="contact-trigger">Contactos</a></li>-->
            </ul>
          </nav>
        </div>
        <div class="headline">
          <p class="additional-text" style="padding-top: 2rem;">BIOALTERNATIVA | Produtos Naturais</p>
          <h1 class="main-headline clip">
            <span class="words-wrapper" style="padding-bottom: 2rem; padding-top: 2rem;">
              <b class="is-visible">NÓS COLHEMOS</b>
              {{-- <b>Florestas - Madeiras</b> --}}
              <b>Os melhores Ferscos</b>
              <b>Nós Colhemos</b>
              <b>Você Escolhe</b>

            </span>
          </h1>
          <p class="description-text">Estamos a preparar algo Fantástico para criar a melhor experiência de navegação. BREVEMENTE disponível...</p>
         <!-- <a href="#" class="btn btn-solid" id="notify-trigger">
            <span class="fa fa-paper-plane"></span>
            <span class="btn-caption">Contacte-nos</span>
          </a>-->
        </div>
        <div class="countdown">
          <div id="countdown"></div>
          <span class="help-text">Brevemente...</span>
        </div>
      </div>
      <div class="main-aside col-xs-12 col-md-4 col-lg-3">
        <div class="aside-content" >
          <p><a href="#"><i class="fa fa-map"></i>&nbsp; LEIRIA - PORTUGAL</i></a></p>
          <p><a href="tel:+351-913662492"><i class="fa fa-phone"></i>&nbsp; +351 913 662 492 </a><sup>(*Chamada para rede móvel nacional)</sup><br></p>
          <p><a href = "mailto: geral@bioalternativa.pt"><i class="fa fa-envelope"></i>&nbsp; geral@bioalternativa.pt</a></p>
          <a href="#0" id="stayintouch-trigger" class="btn btn-outline">
            <span class="fa fa-pencil"></span>
            <span class="btn-caption">Contacte-nos</span>
          </a>
        </div>
        <div class="socials">
          <!-- <ul>
            <li><p>Folow us:</p></li>
            <li>
              <a href="https://www.facebook.com/" target="_blank">
                <i class="fa fa-facebook"></i>
              </a>
            </li>
            <li>
              <a href="https://www.instagram.com/" target="_blank">
                <i class="fa fa-instagram"></i>
              </a>
            </li>
          </ul> -->
        </div>
        <div class="stayintouch">
          <a class="btn-square btn-outline transparent" href="#0" id="stayintouch-close">
            <span class="fa fa-times"></span>
          </a>
          <div class="stayintouch-title">
            <p class="title">Envie-nos a sua mensagem</p>
          </div>
          <div class="form-container">
            <div class="reply-group">
              <i>
                <span class="fa fa-check"></span>
              </i>
              <p class="reply-group__title">Sucesso!</p>
              <p class="reply-group__text">Obrigada pela sua mensagem. Responderemos tão breve quanto possível.</p>
            </div>
            <form class="form form-light no-padding" id="stayintouch-form" class="form">
              <input type="hidden" name="project_name" value="Bioalternativa - >Produtos Naturais">
              <input type="hidden" name="admin_email" value="prog4@criativatek.com.br">
              <input type="hidden" name="form_subject" value="Stay-in-touch Contact Form Message">
              <input class="col-xs-12 animate" type="text" name="name" placeholder="Os seu nome*" required>
              <input class="col-xs-12 animate" type="email" name="email" placeholder="O seu email*" required>
              <textarea class="col-xs-12 animate" name="description" placeholder="A sua mensagem*"></textarea>
              <span class="inputs-description">*Campos de preenchimento obrigatório</span>
              <div style="color: white;">
                <input style="-webkit-appearance:checkbox;" type="checkbox" name="terms" id="terms" data-required></input> Autorizo o tratamento pela Bioalternativa dos meus dados pessoais nos termos do Regulamento Geral de Proteção de Dados (RGPD)
            </div>
            <br>
            <button type="submit" class="btn btn-solid">
              <span class="fa fa-paper-plane"></span>
              <span class="btn-caption">Enviar</span>
            </button>
            <div class="recaptcha" style="visibility:hidden;"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="about" class="content-section about">
    <div class="container-fluid">
      <a class="btn-square btn-outline dark section-close" href="#0" id="about-close">
        <span class="fa fa-arrow-left"></span>
      </a>
      <div class="section-title">
        <h2 class="second-edit">
          <span style="color: #018938 ;">Benvindo</span>
          <!-- <span style="font-weight: 600;">Bioalternativa</span> -->
        </h2>
        <p>Bioalternativa - Produtos Naturais</p>
      </div>
      <div class="about-features">
        <div class="col-xs-12 no-padding">
          <div class="col-xs-12 col-sm-4 feature-image feature-image-1" style="background-image:url(/static/images/backgrounds/wood.jpg);"></div>
          <div class="col-xs-12 col-sm-8 feature-description">
            <div class="feature-item">
              <!-- <i class="icon feature-icon feature-icon-1"></i> -->
              <h3>quem somos</h3>
              <p>Comunidade que pretende alargar horizontes e partilhar os mais belos costumes. Damos importância às raízes e aos princípios, consideramos que a origem é o segredo fundamental para a qualidade da nossa essência.</p>
              <h3>Como Produzimos</h3>
              <p>A terra é altamente potenciadora e rica de nutrientes. Através da eficaz gestão do solo conseguimos obter o melhor cultivo dispensando a necessidade de adição de substâncias químicas e prejudiciais à nossa saúde.</p><!-- <p>Through awareness, we hope that living beings can cooperate and develop in simbiosis.</p> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
 <!-- <section id="works" class="content-section works">
    <div class="container-fluid">
      <a class="btn-square btn-outline dark section-close" href="#0" id="works-close">
        <span class="fa fa-arrow-left"></span>
      </a>
      <div class="section-title">
        <h2 class="second-edit">Our works</h2>
      </div>
      <div class="gallery">
        <div class="my-gallery" itemscope itemtype="http://schema.org/ImageGallery">
          <figure class="col-xs-12 col-sm-6 col-lg-4" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
            <a href="/static/images/gallery/portfolio-item-1_1200x900.jpg" itemprop="contentUrl" data-size="1200x900">
              <img src="/static/images//gallery/portfolio-thumb-1_600x450.jpg" itemprop="thumbnail" alt="Image description" />
              <div class="overlay"></div>
            </a>
            <figcaption class="works-description" itemprop="caption description">
              <h4>Packaging</h4>
              <p>Mauris porttitor lobortis ligula, quis molestie lorem scelerisque eu. Morbi aliquam enim odio, a mollis ipsum tristique eu. Nam finibus euismod quam at aliquam.</p>
            </figcaption>
          </figure>
          <figure class="col-xs-12 col-sm-6 col-lg-4" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
            <a href="/static/images/gallery/portfolio-item-2_1200x900.jpg" itemprop="contentUrl" data-size="1200x900">
              <img src="/static/images//gallery/portfolio-thumb-2_600x450.jpg" itemprop="thumbnail" alt="Image description" />
              <div class="overlay"></div>
            </a>
            <figcaption class="works-description" itemprop="caption description">
              <h4>Branding</h4>
              <p>Mauris porttitor lobortis ligula, quis molestie lorem scelerisque eu. Morbi aliquam enim odio, a mollis ipsum tristique eu. Nam finibus euismod quam at aliquam.</p>
            </figcaption>
          </figure>
          <figure class="col-xs-12 col-sm-6 col-lg-4" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
            <a href="/static/images/gallery/portfolio-item-3_1200x900.jpg" itemprop="contentUrl" data-size="1200x900">
              <img src="/static/images//gallery/portfolio-thumb-3_600x450.jpg" itemprop="thumbnail" alt="Image description" />
              <div class="overlay"></div>
            </a>
            <figcaption class="works-description" itemprop="caption description">
              <h4>Mobile App</h4>
              <p>Mauris porttitor lobortis ligula, quis molestie lorem scelerisque eu. Morbi aliquam enim odio, a mollis ipsum tristique eu. Nam finibus euismod quam at aliquam.</p>
            </figcaption>
          </figure>
          <figure class="col-xs-12 col-sm-6 col-lg-4" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
            <a href="/static/images/gallery/portfolio-item-4_1200x900.jpg" itemprop="contentUrl" data-size="1200x900">
              <img src="/static/images//gallery/portfolio-thumb-4_600x450.jpg" itemprop="thumbnail" alt="Image description" />
              <div class="overlay"></div>
            </a>
            <figcaption class="works-description" itemprop="caption description">
              <h4>Logotype</h4>
              <p>Mauris porttitor lobortis ligula, quis molestie lorem scelerisque eu. Morbi aliquam enim odio, a mollis ipsum tristique eu. Nam finibus euismod quam at aliquam.</p>
            </figcaption>
          </figure>
          <figure class="col-xs-12 col-sm-6 col-lg-4" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
            <a href="/static/images/gallery/portfolio-item-5_1200x900.jpg" itemprop="contentUrl" data-size="1200x900">
              <img src="/static/images//gallery/portfolio-thumb-5_600x450.jpg" itemprop="thumbnail" alt="Image description" />
              <div class="overlay"></div>
            </a>
            <figcaption class="works-description" itemprop="caption description">
              <h4>Web Design</h4>
              <p>Mauris porttitor lobortis ligula, quis molestie lorem scelerisque eu. Morbi aliquam enim odio, a mollis ipsum tristique eu. Nam finibus euismod quam at aliquam.</p>
            </figcaption>
          </figure>
          <figure class="col-xs-12 col-sm-6 col-lg-4" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
            <a href="/static/images/gallery/portfolio-item-6_1200x900.jpg" itemprop="contentUrl" data-size="1200x900">
              <img src="/static/images//gallery/portfolio-thumb-6_600x450.jpg" itemprop="thumbnail" alt="Image description" />
              <div class="overlay"></div>
            </a>
            <figcaption class="works-description" itemprop="caption description">
              <h4>Print Design</h4>
              <p>Mauris porttitor lobortis ligula, quis molestie lorem scelerisque eu. Morbi aliquam enim odio, a mollis ipsum tristique eu. Nam finibus euismod quam at aliquam.</p>
            </figcaption>
          </figure>
        </div>
      </div>
    </div>
  </section>-->
 <!-- <section id="contact" class="content-section contact">
    <div class="container-fluid">
      <a class="btn-square btn-outline dark section-close" href="#0" id="contact-close">
        <span class="fa fa-arrow-left"></span>
      </a>
      <div class="section-title">
        <h2 class="second-edit"><span style="color: #018938 ;">Contact</span><span style="font-weight: 600;"> us</span></h2>
        <p>Pode ligar ou deixar a sua mensagem aqui.
          Contacte-nos:
          <span><a href="tel:+351-910579717" data-tooltip="*(Chamada para rede móvel)">(+351) 910 579 717 <sup>(*)</sup></a></span>
          or email:
          <span>Bioalternativa@gmail.com</span>
        </p>
      </div>
      <div class="form-container">
        <div class="reply-group">
          <i>
            <span class="fa fa-check"></span>
          </i>
          <p class="reply-group__title light">Sucesso!</p>
          <p class="reply-group__text light">Obrigado pela sua mensagem. Responderemos tão breve quanto possível.</p>
        </div>
        <form class="form form-dark contact-form" id="contact-form">
          <input type="hidden" name="project_name" value="Bioalternativa - Produtos Naturais">
          <input type="hidden" name="admin_email" value="prog4@criativatek.com.br">
          <input type="hidden" name="form_subject" value="Contact Form Message">
          <input class="" type="text" name="name" placeholder="O seu nome*" required>
          <input class="" type="email" name="email" placeholder="O seu email*" required>
          <textarea class="col-xs-12" name="description" placeholder="A sua mensagem*" required></textarea>
          <span class="inputs-description">*Os campos obrigatórios</span>
          <button class="btn btn-solid" type="submit">
            <span class="fa fa-paper-plane"></span>
            <span class="btn-caption">Enviar</span>
          </button>
          <div class="recaptcha" style="visibility:hidden;"></div>
        </form>
      </div>
    </div>
  </section>-->
  <div class="notify">
    <a class="btn-square btn-outline dark" href="#0" id="notify-close">
      <span class="fa fa-times light"></span>
    </a>
    <div class="notify-content">
      <div class="notify-title">
        <p class="title">Get to know about our launch</p>
        <p class="subtitle">Subscribe to our newsletter and we will send you a notification about the launch of our brand new site.</p>
      </div>
      <div class="form-container">
          <div class="reply-group subscription-ok">
            <i>
              <span class="fa fa-check"></span>
            </i>
            <span class="reply-group__title light">Done!</span>
            <span class="reply-group__text light">Thanks for subscribing. We will send you a notification about the launch of our brand new website.</span>
          </div>
          <div class="reply-group subscription-error">
            <i>
              <span class="fa fa-times"></span>
            </i>
            <span class="reply-group__title light">Ooops!</span>
            <span class="reply-group__text light">Something went wrong. Please try again later.</span>
          </div>
        <form action="/newsletter" method="post" class="notify-form form form-dark no-padding">
          <input class="col-xs-12" type="email" placeholder="Email Adress*" required>
          <input type="hidden" name="redirect" value="">
          <button class="btn btn-solid" type="submit">
            <span class="fa fa-paper-plane"></span>
            <span class="btn-caption">Enviar</span>
          </button>
        </form>
      </div>
    </div>
  </div>
  <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">
      <div class="pswp__container">
          <div class="pswp__item"></div>
          <div class="pswp__item"></div>
          <div class="pswp__item"></div>
      </div>
      <div class="pswp__ui pswp__ui--hidden">
        <div class="pswp__top-bar">
          <div class="pswp__counter"></div>
          <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
          <button class="pswp__button pswp__button--share" title="Share"></button>
          <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
          <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
          <div class="pswp__preloader">
            <div class="pswp__preloader__icn">
              <div class="pswp__preloader__cut">
                <div class="pswp__preloader__donut"></div>
              </div>
            </div>
          </div>
        </div>
          <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
              <div class="pswp__share-tooltip"></div>
          </div>
          <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
          </button>
          <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
          </button>
          <div class="pswp__caption">
              <div class="pswp__caption__center"></div>
          </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script src="https://google.com/recaptcha/api.js?onload=initRecaptcha&render=explicit"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        $("form").submit(function(e) {
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
                    var container = jQuery(this).parents('form');
                    var tempID = grecaptcha.render(el, {
                        'sitekey': '{{ $website_config->recaptcha_site_key }}',
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
                url: "/contact", // Validate the recaptcha challenge
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
                        alert("Erro ao submeter pedido de contacto");
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
@endsection
