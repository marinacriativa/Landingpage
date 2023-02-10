
<?php $__env->startSection('content'); ?>
<div id="content">

			<div class="section-content page-banner3 contact-page-banner"></div>

			<div class="container">
				<h1>Contactos</h1>
			</div>

			<div class="section-content contact-section">
				<div class="title-section">
					<div class="container triggerAnimation animated" data-animate="bounceIn">
						<h1>A nossa localização</h1>
					</div>
				</div>
				<div class="row">
							<div class="col-md-12" >

				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1825.6188400549102!2d-8.89016148509397!3d39.68767319981037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd220bae77dabb41%3A0x417f8479b366be2e!2sPaulo+%26+Isabel+Fragoso+Lda!5e0!3m2!1spt-PT!2spt!4v1513174973337"
				 width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>

				</div>
				</div>
				</div>

				<div class="contact-info triggerAnimation animated" data-animate="flipInX">
					<div class="container">
						<div class="row">
							<div class="col-md-3">
								<a href="#"><i class="fa fa-map-marker"></i></a>
								<h2>Morada</h2>
								<p>
									<span>Travessa Fonte Mangas </span>
									<span>2405-028 Maceira Lis</span>
								</p>
							</div>
							<div class="col-md-3">
								<a href="#"><i class="fa fa-phone"></i></a>
								<h2>Telefone</h2>
								<p>
									<span><b>Telefone:</b> 244 772 636</span><small>(Chamada para rede fixa nacional)</small>
									<br>
									<span><b>Fax:</b> 917 253 231</span><small>(Chamada para rede móvel)</small>
								</p>
							</div>
							<div class="col-md-3">
								<a href="#"><i class="fa fa-envelope-o"></i></a>
								<h2>E-mail</h2>
								<p>
									<span>info@biocaracol.pt<br>infobiocaracol@gmail.com</span>
								</p>
							</div>
								<div class="col-md-3">
								<a href="#"><i class="fa fa-clock-o"></i></a>
								<h2>Horário da Loja</h2>
								<p>
									<span> <b>Segunda – Sexta:</b> <br> 9h - 13h & 14h - 18h <br>
									 <b>Sabado:</b> (manhã) 9h - 13h</span>
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="contact-area">
					<br>
					<div class="title-section">
						<div class="container triggerAnimation animated" data-animate="slideInLeft">
							<h1>Deixe-nos uma mensagem</h1>
							<p>Tentaremos responder-lhe o mais rápido possivel.</p>
						</div>
					</div>
					<form id="contact-form" class="form" name="contact-form">
						<div class="container triggerAnimation animated" data-animate="slideInLeft">
							<div class="row">
								<div class="col-md-4">
									<input name="name" id="name" type="text" placeholder="Nome">
								</div>
								<div class="col-md-4">
									<input name="email" id="email" type="email" placeholder="E-mail">
								</div>
								<div class="col-md-4">
									<input name="subject" id="subject" type="text" placeholder="Assunto">
								</div>
							</div>
							<textarea name="description" id="description" placeholder="A sua mensagem"></textarea>
							<div class="submit-area">
							<div class="form-group">
	                            <input style="-webkit-appearance:checkbox;" type="checkbox" name="terms" id="terms" data-required></input> Autorizo o tratamento pela Biocaracol dos meus dados pessoais nos termos do Regulamento Geral de Proteção de Dados (RGPD)
                            </div>
                            <input type="submit" id="submit" value="Enviar">
                            <div class="recaptcha" style="visibility: hidden;"></div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  

    <script src="https://google.com/recaptcha/api.js?onloadCallback=initRecaptcha&render=explicit"></script>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/contact.blade.php ENDPATH**/ ?>