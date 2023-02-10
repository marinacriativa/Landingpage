<h4>{{ ucfirst($translations["backoffice"]["design_title"]) }}</h4>
<hr>
<div id="design_settings">
    <div class="row mt-4">
        <div class="col-6 col-xl-3">
            <label>{{ ucfirst($translations["backoffice"]["design_main_color"]) }}</label><br>
                <input style="margin-b" name="colors" data-config-name="colors" type="color" class="w-100"/>
        </div>
        <div class="col-6 col-xl-3">
            <label>{{ ucfirst($translations["backoffice"]["design_header_color"]) }}</label><br>
            <input name="header_color" data-config-name="header_color" type="color" class="w-100"/>
        </div>
        <div class="col-6 col-xl-3">
            <label>{{ ucfirst($translations["backoffice"]["design_footer_color"]) }}</label><br>
            <input name="footer_color" data-config-name="footer_color" type="color" class="w-100"/>
        </div>
        <div class="col-6 col-xl-3">
            <label>{{ ucfirst($translations["backoffice"]["design_copyright_color"]) }}</label><br>
            <input name="copyright_color" data-config-name="copyright_color" type="color" class="w-100"/>
        </div>
        
    </div>
    <div class="w-100 mb-5 mt-3">
        <button type="button" class="btn btn-outline-primary btn-xs" data-settings="colors,header_color,footer_color,copyright_color">{{ ucfirst($translations["backoffice"]["design_btn_save"]) }}</button>
    </div>
    <div class="form-group mt-4 w-50">
        <label>{{ ucfirst($translations["backoffice"]["design_logo"]) }}</label>
        <div id="logo-image"></div>
    </div>

    <div class="form-group mt-4 w-50">
        <label>{{ ucfirst($translations["backoffice"]["design_footer_logo"]) }}</label>
        <div id="footer-image"></div>
    </div>

    <div class="form-group mt-4 w-10">
        <label>{{ ucfirst($translations["backoffice"]["design_favicon"]) }}</label>
        <div id="favicon-image"></div>
    </div>
</div>
<script>

    function design() {

        // Botão de guardar
        $("#design_settings [data-settings]").off("click");
        $("#design_settings [data-settings]").on("click", function() {

            let settings_to_save = $(this).data("settings").split(",");

            $.each(settings_to_save, function(id, key) {

                // Vamos buscar cada name e mandar um request de update
                let value = $("#design_settings [name='" + key + "']").val();

                // Esta função está em /templates/backoffice/config/index.blade.php
                saveSetting(key, value);
            });

            // Imagem do logotipo
            let slim_data_logo = $("#logo-image").slim('data')[0];

            if (slim_data_logo.server) {
                
                saveSetting("logo", slim_data_logo.server);
            }

            // Imagem do footer
            let slim_data_footer_logo = $("#footer-image").slim('data')[0];

            if (slim_data_footer_logo.server) {
                
                saveSetting("footer_logo", slim_data_footer_logo.server);
            }

            // Imagem do favicon
            let slim_data_favicon = $("#favicon-image").slim('data')[0];

            if (slim_data_favicon.server) {
                
                saveSetting("favicon", slim_data_favicon.server);
            }

            $.alert({
                title: '{{ ucfirst($translations["backoffice"]["success"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["success_message_colors_save"]) }}',
            });
        });

        // Slim images
        $("#logo-image").slim(slimDefaultConfig( { folder: 'logo' } ));
        $("#footer-image").slim(slimDefaultConfig( { folder: 'logo' } ));
        $("#favicon-image").slim(slimDefaultConfig( { folder: 'logo' } ));

        // Carregar imagens guardadas
        $("#logo-image").slim('load',       window.CONFIG.logo + "?cache=" + new Date().getTime(),          { blockPush : true }, function(error, data) { });
        $("#footer-image").slim('load',     window.CONFIG.footer_logo + "?cache=" + new Date().getTime(),   { blockPush : true }, function(error, data) { });
        $("#favicon-image").slim('load',    window.CONFIG.favicon + "?cache=" + new Date().getTime(),       { blockPush : true }, function(error, data) { });    }

</script>