<script src="https://google.com/recaptcha/api.js?onload=initRecaptcha&render=explicit"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        $(".form-booking").submit(function(e) {
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
            let data = new FormData (document.querySelector('.form-booking'));
            $.ajax({
                url: "/booking", // Validate the recaptcha challenge
                method: "POST",
                contentType: false,
                processData: false,
                data: data,
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
                    //resetForm(container);
                }
            });
        }
        /**
         * Reset form fields
         **/
       /*  var resetForm = function($form) {      
            $form.find('input:not([readonly]), select, textarea').val('');
            $form.find('input:radio:not([readonly]), input:checkbox:not([readonly])').removeAttr('checked')
                .removeAttr('selected');
            $form.find(
                'input:text, input:password, input, input:file, select, textarea, input:radio, input:checkbox'
            ).parent().find('.form-control-feedback').hide();
            $form.find('.has-feedback').removeClass('has-feedback');
            $form.find('.has-success').removeClass('has-success');
        }; */
    });
</script><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/items/booking-script.blade.php ENDPATH**/ ?>