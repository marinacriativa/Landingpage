<h4><?php echo e(ucfirst($translations["backoffice"]["settings_title"])); ?>

    <div class="btn-group top-right-button-container">
        <?php 
            $countLangs = 0;
        ?>
        <?php if(count($languages) > 1): ?>
            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $langs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($langs->active == 1): ?>
                    <?php 
                        $countLangs ++;
                    ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <?php if($countLangs > 1): ?>
        <button id="btnGroupDrop1" type="button" class="btn btn-xs btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo e(ucfirst($translations["backoffice"]["languages"])); ?></button>
            <div class="dropdown-menu dropdown-menu-right p-3" style="width: max-content;">
                <ul class="nav nav-tabs" id="store-languages-list" role="tablist"></ul>
            </div>
        <?php endif; ?>
    </div>
</h4>
<hr>
<div class="row mt-2">
    <div class="col-12">
        <div class="tab-content" id="store-languages-tabs">
        </div>
    </div>
</div>

<div class="form-group mt-2">
    <div class="custom-switch custom-switch-secondary mb-2 custom-switch-small">
        <label><?php echo e(ucfirst($translations["backoffice"]["store_settings_btn_maintenance"])); ?></label>
        <input class="custom-switch-input" name="is_maintain" id="is_maintain" type="checkbox">
        <label rel="tooltip" class="custom-switch-btn float-left mr-2" for="is_maintain" data-original-title="Desativa a loja ao público"></label>
    </div>
    <hr>
    <h4>Extras</h4>

    <div class="custom-switch custom-switch-secondary mb-2 custom-switch-small mt-4">
        <label>Ativar Neve (Natal)</label>
        <input class="custom-switch-input" name="neve" id="is_snowing" type="checkbox">
        <label rel="tooltip" class="custom-switch-btn float-left mr-2" for="is_snowing" data-original-title="Ativar Neve"></label>
    </div>

    <h4 class="mt-4">Formulário de contacto</h4>
    <div class="custom-switch custom-switch-secondary mb-2 custom-switch-small mt-4">
        <label>Ativar escolha de colaborador no formulário</label>
        <input class="custom-switch-input" name="can_choose_collaborator_for_contact_page" id="can_choose_collaborator_for_contact_page" type="checkbox">
        <label rel="tooltip" class="custom-switch-btn float-left mr-2" for="can_choose_collaborator_for_contact_page" data-original-title="Ativar/Desativar"></label>
    </div>
    <h4 class="mt-4">Recaptcha</h4>
    <label class="form-group has-float-label mt-4">
        <input class="form-control" type="text" value="" id="recaptcha_site_key" name="recaptcha_site_key" placeholder=""> 
        <span>Chave google recaptcha pública</span>
    </label>
    <label class="form-group has-float-label mt-4">
        <input class="form-control" type="text" value="" id="recaptcha_secret_key" name="recaptcha_secret_key" placeholder=""> 
        <span>Chave google recaptcha privada</span>
    </label>
</div>
<div class="row">
    <div class="col-12 mt-4">
        <button type="button" class="btn btn-outline-primary btn-xs float-right save-store-settings"><?php echo e(ucfirst($translations["backoffice"]["store_settings_btn_save"])); ?></button>
    </div>
</div>

<script>

    function store() {

         // Estamos a guardar estas definições em json dentro de cada config da database
         var config_keys = ["title", "header_email", "header_phone", "header_address", "copyright", "footer", "maintain_text", "whatsapp_active", "whatsapp_number", "is_snowing", "messenger_active", "messenger_value", "cookies_active", "cookies_value", "can_choose_collaborator_for_contact_page", "is_maintain", "recaptcha_site_key", "recaptcha_secret_key"];

        storeInit();
        
        function storeInit() {

            getStoreLanguages(function() {

                // Limpar linguas do modal de editar
                $("#store-editor select").html("");
                $("#store-languages-list").html("");
                $("#store-languages-tabs").html("");

                // Ativar os listners da página
                storeListners();

                // Por cada lingua que tivermos temos de adicionar uma tab
                $.each(window.LANGUAGES, function(key, language) {

                    // Introduzir as linguas no modal de editar
                    $("#store-editor select").append(`<option value="` + language.code + `">` +
                        language.name + `</option>`);

                    // Vereficar se é a lingua default ou não
                    (language.default === "1") ? default_language = language.code: null;

                    // Nav links
                    if ($("#store-languages-list").find(".nav-item").length < window.LANGUAGES.length) {

                        $("#store-languages-list").append(`
                            <li>
                                <a class="nav-link ` + ((language.default === "1") ? "active" : "") +
                                ` text-small" id="language-store-tab-` + language.code +
                                `" data-toggle="tab" href="#language-store-` + language.code +
                                `" role="tab">` + language.name + `</a>
                           </li>
                        `);

                        // Tabs
                        $("#store-languages-tabs").append(`
                            <div class="tab-pane fade ` + ((language.default === "1") ? "active show" : "") +
                                `" id="language-store-` + language.code + `" role="tabpanel">
                                <div class="form-group mt-4 has-float-label">
                                    <label><?php echo e(ucfirst($translations["backoffice"]["store_settings_fill_title"])); ?></label>
                                    <input name="title" data-multi-lang-config-name="title" data-language="` + language.code + `" type="text" class="form-control"/>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 col-xl-4 has-float-label">
                                        <label class="ml-3"><?php echo e(ucfirst($translations["backoffice"]["store_fill_main_email"])); ?></label>
                                        <input name="header_email" data-multi-lang-config-name="header_email" data-language="` + language.code + `" type="text" class="form-control"/>
                                    </div>
                                    <div class="col-12 col-xl-4 mt-xl-0 mt-4 has-float-label">
                                        <label class="ml-3"><?php echo e(ucfirst($translations["backoffice"]["store_settings_fill_phone"])); ?></label>
                                        <input name="header_phone" data-multi-lang-config-name="header_phone" data-language="` + language.code + `" type="text" class="form-control"/>
                                    </div>
                                    <div class="col-12 col-xl-4 mt-xl-0 mt-4 has-float-label">
                                        <label class="ml-3"><?php echo e(ucfirst($translations["backoffice"]["store_settings_fill_address"])); ?></label>
                                        <input name="header_address" data-multi-lang-config-name="header_address" data-language="` + language.code + `" type="text" class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group mt-4 has-float-label">
                                    <label><?php echo e(ucfirst($translations["backoffice"]["store_settings_fill_text_copyright"])); ?></label>
                                    <input name="copyright" data-multi-lang-config-name="copyright" data-language="` + language.code + `" type="text" class="form-control"/>
                                </div>
                                <div class="form-group mt-4 has-float-label">
                                    <label><?php echo e(ucfirst($translations["backoffice"]["store_settings_fill_text_footer"])); ?></label>
                                    <textarea name="footer" data-multi-lang-config-name="footer" data-language="` + language.code + `" rows="5" class="form-control"></textarea>
                                </div>
                                <div class="form-group mt-3 has-float-label">
                                    <label><?php echo e(ucfirst($translations["backoffice"]["store_settings_fill_text_maintenance"])); ?></label>
                                    <textarea rows="5" data-multi-lang-config-name="maintain_text" data-language="` + language.code + `" class="form-control"></textarea>
                                </div>
                                <div class="input-group mb-3 mt-4">
                                    <label class="form-group has-float-label"><input placeholder="Número de telemóvel" data-language="` + language.code + `" id="whatsapp_number" data-multi-lang-config-name="whatsapp_number" type="text" autocomplete="off" class="form-control"><span>Whatsapp</span> </label>
                                    <div class="input-group-text p-0 pl-1 pr-1">
                                        <span class="custom-switch custom-switch-secondary custom-switch-small vertical-align-center"> 
                                            <input class="custom-switch-input" id="whatsapp_active" name="whatsapp_active" type="checkbox"> <label rel="tooltip" title="Ativar / Desativar" class="custom-switch-btn mt-1" for="whatsapp_active"></label> 
                                        </span>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <label class="form-group has-float-label"> <textarea placeholder="Inserir texto..." data-language="` + language.code + `" id="cookies_value" data-multi-lang-config-name="cookies_value" autocomplete="off" class="form-control" rows="3"></textarea><span>Cookies</span> </label>
                                    <div class="input-group-text p-0 pl-1 pr-1">
                                        <span class="custom-switch custom-switch-secondary custom-switch-small vertical-align-center"> 
                                            <input class="custom-switch-input" name="cookies_active" id="cookies_active" type="checkbox"> <label rel="tooltip" title="Ativar / Desativar" class="custom-switch-btn mt-1" for="cookies_active"></label> 
                                        </span>
                                    </div>
                                </div> 

                                <div class="input-group mb-3">
                                    <label class="form-group has-float-label"> <textarea placeholder="Inserir texto..." data-language="` + language.code + `" id="messenger_value" data-multi-lang-config-name="messenger_value" autocomplete="off" class="form-control" rows="3"></textarea><span>Messenger Facebook</span> </label>
                                    <div class="input-group-text p-0 pl-1 pr-1">
                                        <span class="custom-switch custom-switch-secondary custom-switch-small vertical-align-center"> 
                                            <input class="custom-switch-input" name="messenger_active" id="messenger_active" type="checkbox"> <label rel="tooltip" title="Ativar / Desativar" class="custom-switch-btn mt-1" for="messenger_active"></label> 
                                        </span>
                                    </div>
                                </div> 
                            </div>
                        `);
                    }
                });

                $.each(config_keys, function(key, value) {

                    switch (value) {

                        case 'is_maintain':
                            $("#is_maintain").prop('checked', window.CONFIG[value] == "true");
                            break;

                        case 'can_choose_collaborator_for_contact_page':
                            $("#can_choose_collaborator_for_contact_page").prop('checked', window.CONFIG[value] == "true");
                            break;

                        case 'whatsapp_active':
                            $("#whatsapp_active").prop('checked', window.CONFIG[value] == "true");
                            break;
                        
                        case 'cookies_active':
                            $("#cookies_active").prop('checked', window.CONFIG[value] == "true");
                            break;

                        case 'messenger_active':
                            $("#messenger_active").prop('checked', window.CONFIG[value] == "true");
                            break;

                        case 'is_snowing':
                            $("#is_snowing").prop('checked', window.CONFIG[value] == "true");
                            break;

                        default:
                            try {
                                let json_value = JSON.parse(window.CONFIG[value]);
                                populateMultiLanguageConfig(value, json_value);
                            } catch(error) {
                                $('#' + value).val(window.CONFIG[value]);
                             }
                            break;
                    }
                });
            });
        } 

        function storeListners() {

            //Ao clicar no eliminar
            $(".save-store-settings").off("click");
            $(".save-store-settings").on("click", function() {

                let data = serializeStoreData();

                // Guardar
                // Esta função está em /templates/backoffice/config/index.blade.php
                $.each(data, function(key, value) {
                 
                    if (typeof value !== 'string') {
                        // Transformar em json
                        value = JSON.stringify(value);
                    }
                    
                    saveSetting(key, value);
                });

                // Mostrar mensagem de sucesso
                $.alert({
                    title: '<?php echo e(ucfirst($translations["backoffice"]["success"])); ?>',
                    theme: "supervan",
                    content: '<?php echo e(ucfirst($translations["backoffice"]["success_message_save_store_settings"])); ?>',
                });
            });
        }

        // Vamos juntar todos os valores da página
        function serializeStoreData() {

            let config = {};

            $.each(config_keys, function(key, value) {

                config[value] = {};

                $.each(window.LANGUAGES, function(subkey, language) {

                    config[value][language.code] = $("[data-language='" + language.code + "'][data-multi-lang-config-name='" + value + "']").val();
                })
            });

            config["is_maintain"] = $("#is_maintain").prop('checked');
            config["can_choose_collaborator_for_contact_page"] = $("#can_choose_collaborator_for_contact_page").prop('checked');
            config["whatsapp_active"] = $("#whatsapp_active").prop('checked');
            config["cookies_active"] = $("#cookies_active").prop('checked');
            config["messenger_active"] = $("#messenger_active").prop('checked');
            config["is_snowing"] = $("#is_snowing").prop('checked');

            config['whatsapp_number'] = $("#whatsapp_number").val();
            config['cookies_value']   = $("#cookies_value").val(); 
            config['messenger_value']   = $("#messenger_value").val(); 
            config['recaptcha_site_key'] = $("#recaptcha_site_key").val(); 
            config['recaptcha_secret_key'] = $("#recaptcha_secret_key").val(); 

            return config;
        }

        function populateMultiLanguageConfig(key, languages) {

            $.each(languages, function(language, value) {

                $("[data-language='" + language + "'][data-multi-lang-config-name='" + key + "']").val(value);
            });
        }   

        // O callback serve para ser chamado depois de as linguas carregarem
        function getStoreLanguages(callback) {

            // Vereficar se já carregamos as línguas
            if (window.LANGUAGES !== undefined) {

                callback();

            } else {

                $.ajax({
                    url: "/api/translations/",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {

                        if (!response.success) {

                            // Output do erro
                            console.error(response);

                            $.alert({
                                title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                                theme: "supervan",
                                content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                            });

                            // Não deixar a função executar mais
                            return;
                        }

                        window.LANGUAGES = response.data;

                        // Chamar o callback
                        callback();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                        console.log(textStatus, errorThrown);

                        $.alert({
                            title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                            theme: "supervan",
                            content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                        });
                    }
                });
            }
        }

        function jsonParseError(error) {

            console.error(error);

            $.alert({
                title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                theme: "supervan",
                content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
            });
        }
    }

</script><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\backoffice/pages/config/items/website.blade.php ENDPATH**/ ?>