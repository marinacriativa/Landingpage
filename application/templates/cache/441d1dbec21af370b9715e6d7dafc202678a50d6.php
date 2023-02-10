<div id="email_settings">
    <h4 class="inline"><?php echo e(ucfirst($translations["backoffice"]["email_title"])); ?></h4>
    <hr>
    <label><?php echo e(ucfirst($translations["backoffice"]["email_logo"])); ?></label>
    <div id="email-image"></div>
    <br><br>

    <label class="form-group has-float-label">
        <input class="form-control" type="text" name="smtp_host" data-config-name="smtp_host" placeholder="">
        <span><?php echo e(ucfirst($translations["backoffice"]["email_host"])); ?></span>
    </label>

    <label class="form-group has-float-label">
        <input class="form-control" type="text" name="smtp_port" data-config-name="smtp_port" placeholder="">
        <span><?php echo e(ucfirst($translations["backoffice"]["email_port"])); ?></span>
    </label>

    <label class="form-group has-float-label">
        <input class="form-control" type="text" name="smtp_username" data-config-name="smtp_username" placeholder="">
        <span><?php echo e(ucfirst($translations["backoffice"]["email_username"])); ?></span>
    </label>

    <label class="form-group has-float-label">
        <input class="form-control" type="text" name="smtp_password" data-config-name="smtp_password" placeholder="">
        <span><?php echo e(ucfirst($translations["backoffice"]["email_password"])); ?></span>
    </label>

    <label class="form-group has-float-label">
        <input class="form-control" type="text" name="smtp_security" data-config-name="smtp_security" placeholder="">
        <span><?php echo e(ucfirst($translations["backoffice"]["email_security"])); ?></span>
    </label>

    <button type="button" class="btn btn-outline-primary btn-xs float-right ml-2" data-settings="smtp_host,smtp_port,smtp_username,smtp_password,smtp_security"><?php echo e(ucfirst($translations["backoffice"]["email_btn_save"])); ?></button>
    <button type="button" class="btn btn-outline-primary btn-xs float-right test-smtp"><?php echo e(ucfirst($translations["backoffice"]["email_btn_test"])); ?></button>
</div>


<script>

    function email() {

        // Botão de guardar
        $("#email_settings [data-settings]").off("click");
        $("#email_settings [data-settings]").on("click", function() {

            let settings_to_save = $(this).data("settings").split(",");

            $.each(settings_to_save, function(id, key) {

                // Vamos buscar cada name e mandar um request de update
                let value = $("#email_settings [name='" + key + "']").val();

                // Esta função está em /templates/backoffice/config/index.blade.php
                saveSetting(key, value);
            });

            // Guardar a imagem
            // Adicionar a imagem da página
            let slim_data = $("#email-image").slim('data')[0];

            if (slim_data.server) {
                
                saveSetting("mail_logo", slim_data.server);
            }

            // Mostrar mensagem de sucesso
            $.alert({
                title: '<?php echo e(ucfirst($translations["backoffice"]["success"])); ?>',
                theme: "supervan",
                content: '<?php echo e(ucfirst($translations["backoffice"]["success_message_save_settings_email"])); ?>',
            });
        });

        // Slim image
        $("#email-image").slim(slimDefaultConfig( { folder: 'logo' } ));       
        // Carregar imagem guardada
        setTimeout(() => {           
            $("#email-image").slim('load', "" + window.CONFIG.mail_logo + "?cache=" + new Date().getTime(), { blockPush : true }, function(error, data) { });
        }, 1000);
        
       
        
        // Ao clicar no botão teste
        $(".test-smtp").off("click");
        $(".test-smtp").on("click", function() {

            test();
        });
    }

    // Botão de testar o SMTP 
    function test() {

        $.confirm({
            title: 'Teste SMTP',
            type: "orange",
            theme: "supervan",
            content: '' +
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label><?php echo e(ucfirst($translations["backoffice"]["email_fill_email"])); ?></label>' +
            '<input type="email" placeholder="<?php echo e(ucfirst($translations["backoffice"]["email_placeholder_email"])); ?>" class="name form-control" required />' +
            '</div>' +
            '</form>',
            buttons: {
                formSubmit: {
                    text: 'Enviar',
                    btnClass: 'btn-default',
                    action: function () {

                        var email = this.$content.find('.name').val();
                        
                        if (!email) {
                            
                            window.notification.display("<?php echo e(ucfirst($translations["backoffice"]["email_fill_email_invalid"])); ?>");
                            return false;
                        }
                        
                        let data = {email: email};
                        
                        $.post("/api/email/test", data, function(response) {
                
                            $.confirm({
                                title: 'SMTP DEBUG',
                                content: response.data.debug.replace("\n", "<br>"),
                                columnClass: "large",
                                theme: 'supervan',
                                animation: "scale",
                                buttons: {
                                    Ok: function () {
                                    },
                                }
                            });
                        });
                    }
                },
                Cancelar: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }

</script><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\backoffice/pages/config/items/email.blade.php ENDPATH**/ ?>