<h4>Scripts</h4>
<hr>

<div class="row">
    <div class="col-12">
        <label class="form-group has-float-label">
            <textarea class="form-control" type="text" rows="13"  wrap="soft" style="white-space: nowrap;  overflow: auto;" id="google_analytics_service_account" name="google_analytics_service_account"></textarea>
            <span>Google analytics service account JSON</span>
        </label>
    </div>
    <div class="col-12">
        <label class="form-group has-float-label">
            <textarea class="form-control" type="text" rows="13"  wrap="soft" style="white-space: nowrap;  overflow: auto;" id="header_scripts" name="header_scripts"></textarea>
            <span>Header scripts</span>
        </label>
    </div>
    <div class="col-12">
        <label class="form-group has-float-label">
            <textarea class="form-control" type="text" rows="13"  wrap="soft" style="white-space: nowrap;  overflow: auto;" id="body_scripts" name="body_scripts"></textarea>
            <span>Body Scripts</span>
        </label>
    </div>
</div>
<div class="row">
    <div class="col-12 mt-4">
        <button type="button" class="btn btn-outline-primary btn-xs float-right save-scripts-settings">{{ ucfirst($translations["backoffice"]["store_settings_btn_save"]) }}</button>
    </div>
</div>


<script>
    
    initScriptsSettings ()

    function initScriptsSettings () {   
        setTimeout (function () {
            $("#header_scripts").val(window.CONFIG.header_scripts);
            $("#body_scripts").val(window.CONFIG.body_scripts); 
            $("#google_analytics_service_account").val(window.CONFIG.google_analytics_service_account);          
        }, 1000)    
    
    }

    //Ao clicar no eliminar
    $(".save-scripts-settings").off("click");
    $(".save-scripts-settings").on("click", function() {

        let data = serializeScriptsData();

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
            title: '{{ ucfirst($translations["backoffice"]["success"]) }}',
            theme: "supervan",
            content: '{{ ucfirst($translations["backoffice"]["success_message_save_store_settings"]) }}',
        });
    });

    // Vamos juntar todos os valores da página
    function serializeScriptsData() {

        let config = {};

        config['header_scripts'] = $("#header_scripts").val();
        config['body_scripts']   = $("#body_scripts").val(); 
        config['google_analytics_service_account']   = $("#google_analytics_service_account").val(); 

        return config;
    }


</script>