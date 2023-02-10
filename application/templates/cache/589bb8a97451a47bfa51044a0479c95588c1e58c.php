
<?php $__env->startSection('content'); ?>
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
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
                                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle dropdown-menu-status-index language-selected" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php if(isset($_GET['langName'])): ?> <?php echo e($_GET['langName']); ?> <?php else: ?> <?php echo e($selected_language->name); ?> <?php endif; ?></button>
                                <div class="dropdown-menu dropdown-menu-right p-3" style="width: max-content;">
                                    <table class="table table-hover borderless">
                                        <tbody class="languages-list">                                            
                                            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $langs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($langs->active == 1): ?>
                                                    <tr>
                                                        <td><a href="?lang=<?php echo e($langs->code); ?>&langName=<?php echo e($langs->name); ?>" class="select-lang"><?php echo e($langs->name); ?></a></td>                                                       
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>	

                        <h1><?php echo e(ucfirst($translations["backoffice"]["menu_manager"])); ?></h1>
                        
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm"><?php echo e(ucfirst($translations["backoffice"]["store"])); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?php echo e(ucfirst($translations["backoffice"]["menu_manager"])); ?>                                    
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <ul class="nav nav-tabs separator-tabs ml-0 mb-5" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="main-menu-tab" data-toggle="tab" href="#main-menu" role="tab" aria-controls="main-menu" aria-selected="true">MENU PRINCIPAL</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="top-menu-tab" data-toggle="tab" href="#top-menu" role="tab" aria-controls="top-menu" aria-selected="false">TOP MENU</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="fast-menu-tab" data-toggle="tab" href="#fast-menu" role="tab" aria-controls="fast-menu" aria-selected="false">MENU RÁPIDO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="footer-menu-tab" data-toggle="tab" href="#footer-menu" role="tab" aria-controls="footer-menu" aria-selected="false">RODAPÉ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="footer-menu-2-tab" data-toggle="tab" href="#footer-menu-2" role="tab" aria-controls="footer-menu-2" aria-selected="false">RODAPÉ 2</a>
                        </li>
                    </ul>

                </div>
            </div>


            <div class="row">
                <div class="col-12 card">
                    <div class="card-body">                  
                        <div class="general_items tab-pane fade active show" role="tabpanel" id="main-menu"></div>
                        <div class="general_items tab-pane fade" role="tabpanel" id="top-menu"></div>
                        <div class="general_items tab-pane fade" role="tabpanel" id="fast-menu"></div>
                        <div class="general_items tab-pane fade" role="tabpanel" id="footer-menu"></div>
                        <div class="general_items tab-pane fade" role="tabpanel" id="footer-menu-2"></div>
                    </div>
                </div>
            </div>

            <div class="modal fade modal-right" id="big-menus-modal" tabindex="-1" role="dialog" aria-labelledby="big-menus-modal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body pt-0">
                            <form>    
                                <div class="row mb-2 mt-4">
                                    <label class="col-form-label col-sm-6 pt-0">Tipo de link</label>
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="url_type"
                                                id="internal_links" value="0">
                                            <label class="form-check-label" for="internal_links">
                                                Link interno
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="url_type"
                                                id="external_links" value="1" checked>
                                            <label class="form-check-label" for="external_links">
                                                Link externo
                                            </label>
                                        </div>
                                    </div>
                                </div>                                                                         
                                <div class="form-group mt-4">
                                    <label class="form-group has-float-label"><input placeholder="<?php echo e(ucfirst($translations["backoffice"]["menus_placeholder_icon"])); ?>" name="icon" class="form-control"><span><?php echo e(ucfirst($translations["backoffice"]["icon_menu"])); ?></span></label>     
                                </div>
                                <div class="form-group">
                                    <label class="form-group has-float-label"><input placeholder="<?php echo e(ucfirst($translations["backoffice"]["menus_fill_name"])); ?>" name="name" class="form-control" autocomplete="off"><span><?php echo e(ucfirst($translations["backoffice"]["menus_fill_name"])); ?></span></label>     
                                </div>
                                <div class="form-group" id="searchitems">
                                    <label class="form-group has-float-label"><input placeholder="<?php echo e(ucfirst($translations["backoffice"]["menus_fill_name"])); ?>" name="search-items" class="form-control" autocomplete="off"><span>Pesquisar</span></label>     
                                    <div id="resultsSearch">                                    
                                    </div>  
                                </div>
                                <div class="form-group" id="url_input">
                                    <label class="form-group has-float-label"><input placeholder="<?php echo e(ucfirst($translations["backoffice"]["url_fill_name"])); ?>" name="url" class="form-control"><span><?php echo e(ucfirst($translations["backoffice"]["url_fill_name"])); ?></span></label> 
                                </div>
                                <fieldset class="form-group">
                                    <div class="row">
                                        <label class="col-form-label col-lg-12 pt-0"><?php echo e(ucfirst($translations["backoffice"]["newtab"])); ?></label>
                                        <div class="col-lg-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="newtab" id="newtab-false" value="false" checked>
                                                <label class="form-check-label" for="newtab-false"><?php echo e(ucfirst($translations["backoffice"]["menu_newtab_false"])); ?></label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="newtab" id="newtab-true" value="true">
                                                <label class="form-check-label" for="newtab-true"><?php echo e(ucfirst($translations["backoffice"]["menu_newtab_true"])); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>    
                                <input type="hidden" name="type">                        
                                <input type="hidden" name="related_id">                        
                                <input type="hidden" name="doc_or_page">                        
                                <input type="hidden" name="lang" value="<?php if(isset($_GET['lang'])): ?><?php echo e($_GET['lang']); ?><?php else: ?><?php echo e($selected_language->code); ?><?php endif; ?>">                        
                                <input type="hidden" name="parent">                        
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light btn-sm" data-dismiss="modal"><?php echo e(ucfirst($translations["backoffice"]["banner_btn_cancel"])); ?></button>
                            <button type="button" class="btn btn-danger remove-menu btn-sm"><?php echo e(ucfirst($translations["backoffice"]["banner_btn_remove"])); ?></button>
                            <button type="button" class="btn btn-primary save-menu btn-sm"><?php echo e(ucfirst($translations["backoffice"]["banner_btn_save"])); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </main>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>       

        let query = parseQueryString();
        var lang        = (query.lang   !== undefined) ? query.lang     : 'pt';

        function initSortable () {
            $( "#menuManagerSortable" ).sortable({
                items: 'li',
                cursor: "move",
                dropOnEmpty: true,
                tolerance: "pointer",
                opacity: 0.7,
                revert: 300,
                delay: 150,
                placeholder: "movable-placeholder",
                start: function(e, ui) {
                    ui.placeholder.height(ui.helper.outerHeight());
                },
                stop:function () {
                    let itemsSortable = [];
                    $('#menuManagerSortable li').not("[data-root='true']").each(function (i, value) {                          
                        itemsSortable.push({
                            id: $(this).data('id'),
                            parent: $(this).parents("[data-id]") ? $(this).parents("[data-id]").first().data('id') : null,      
                            order_by: i                                   
                        })                                    
                    })
                    $.ajax({
                        url: "/api/order_menus/",
                        type: "POST",
                        data: {ids: itemsSortable},
                        dataType: "json",
                        success: function (response) {
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
                        }
                    })
                }
            }).disableSelection();
        }

        

        menu_manager();

       function menu_manager() {
            
            var default_language = null;

            menusInit();

            function menusInit() {         
                
                // Temos de obter as línguas primeiro
                getLanguages(function() {

                    // Limpar linguas do modal de editar
                    $("#big-menus-modal select").html("");

                    // Por cada lingua que tivermos temos de adicionar uma tab
                    $.each(window.LANGUAGES, function(key, language) {

                        // Introduzir as linguas no modal de editar
                        $("#big-menus-modal select").append(`<option value="` + language.code + `">` + language.name + `</option>`);

                        // Verificar se é a lingua default ou não
                        (language.default === "1") ? default_language = language.code: null;

                    });
                });

                window.history.replaceState("", "", '/adm/menus?' + $.param( { lang:lang } ));

                $.ajax({
                    url: "/api/menus?lang=" + lang + "",
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

                        // Vamos transformar a lista de menus numa lista estruturada ( tipo um arvore )
                        let menus = response.data;         
                       
                        // main menu
                        let main_menu = [];
                        menus.filter(function(currentValue){                                 
                            if(currentValue.type == 0 && currentValue.root == 0) {
                                main_menu.push(currentValue);
                            } else if (currentValue.root == 1) {
                                currentValue.type = 0;
                                main_menu.push(currentValue);
                            }
                        })  
                        
                        let main_menu_list= listToTree(main_menu);       
                        $("#main-menu").html(populateMenus(main_menu_list))
                 
                        //top menu                      
                        let top_menu = [];
                        menus.filter(function(currentValue){                                 
                            if(currentValue.type == 1 && currentValue.root == 0) {
                                top_menu.push(currentValue);
                            } else if (currentValue.root == 1) {
                                currentValue.type = 1;
                                top_menu.push(currentValue);
                            }
                        })                      
                 
                        let top_menu_list = listToTree(top_menu);       
                        $("#top-menu").html(populateMenus(top_menu_list))

                        //fast menu                      
                        let fast_menu = [];
                        menus.filter(function(currentValue){                                 
                            if(currentValue.type == 2 && currentValue.root == 0) {
                                fast_menu.push(currentValue);
                            } else if (currentValue.root == 1) {
                                currentValue.type = 2;
                                fast_menu.push(currentValue);
                            }
                        })                      
                 
                        let fast_menu_list = listToTree(fast_menu);       
                        $("#fast-menu").html(populateMenus(fast_menu_list))

                        //footer menu                      
                        let footer_menu = [];
                        menus.filter(function(currentValue){                                 
                            if(currentValue.type == 3 && currentValue.root == 0) {
                                footer_menu.push(currentValue);
                            } else if (currentValue.root == 1) {
                                currentValue.type = 3;
                                footer_menu.push(currentValue);
                            }
                        })                      
                 
                        let footer_menu_list = listToTree(footer_menu);       
                        $("#footer-menu").html(populateMenus(footer_menu_list))


                        //footer menu 2                     
                        let footer_menu_2 = [];
                        menus.filter(function(currentValue){                                 
                            if(currentValue.type == 4 && currentValue.root == 0) {
                                footer_menu_2.push(currentValue);
                            } else if (currentValue.root == 1) {
                                currentValue.type = 4;
                                footer_menu_2.push(currentValue);
                            }
                        })                      
                 
                        let footer_menu_2_list = listToTree(footer_menu_2);       
                        $("#footer-menu-2").html(populateMenus(footer_menu_2_list))

                        hideMenusList () ;
                        // Ativar os listners 
                        menusListners();                        

                        //iniciar ordenação
                        initSortable();
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
           

            function hideMenusList () {
                $(".general_items").find('ul').each(function() {
                    if($(this).parents('ul').length > 2) {
                        $(this).find('.menuListLimit').remove();
                    }
            
                    if($(this).parents('ul').length > 0) {
                        $(this).find('.menuListLimitType').remove();
                    }
                    //console.log($(this).parents('ul'));
                });
                
            }

            function populateMenus(menus, count = 0) {

                let startId = '';
                if(count == 0) {
                    startId = 'id="menuManagerSortable"';
                } 
                let template = $("<ul class='p-0 sortable' " + startId + "></ul>");
                
                $.each(menus, function(key, menu) {
                    let btnEditPage = '';
         
                    if(menu.root != "1" && menu.doc_or_page == "1") {
                        btnEditPage = "<a class='menu-action' target='_blank' href='/adm/pages/"+ menu.related_id +"'><i class='fa fa-share-square float-right mr-3 mt-1'></i></a>";
                    }
                    let menu_template = $(`
                        <li data-id="` + menu.id + `"  class='` + ((menu.root == "1") ? "mb-5" : "pl-5") + `' data-root="` + ((menu.root == "1") ? "true" : "false") + `">
                            <div data-id="` + menu.id + `" data-type="` + menu.type + `" class='menu-block' data-active="` + menu.active + `">
                                <input type="hidden" id="icon" value='` + menu.icon + `'>
                                <span>` + menu.name + ` </span> <em>` + menu.url + `</em>
                                <input type="hidden" name="newtab2" id="newtab2" value="`+ menu.newtab +`">
                                <a class="menu-action add `+ ((menu.type == "0") ? "menuListLimit" : "menuListLimitType") +`"><i class='simple-icon-plus float-right mr-3 mt-1'></i></a>
                                ` + ((menu.root == "1") ? "" : "<a class='menu-action edit'><i class='simple-icon-pencil float-right mr-3 mt-1'></i></a>") + `
                                ` + ((menu.root == "1") ? "" : "<a class='menu-action remove'><i class='simple-icon-close float-right mr-3 mt-1'></i></a>") + `
                                ` + ((menu.root == "1") ? "" : "<a class='menu-action changeActive text-gray'><i class='"+ ((menu.active == '0') ? 'fa fa-eye-slash' : 'fa fa-eye') +" float-right mr-3 mt-1'></i></a>") + `
                                ` + btnEditPage + `
                            </div>
                        </li>
                    `);
                    
                    if (menu.children.length > 0) {

                        // Temos filhos na menu, vamos chamar a função para adicionar o html
                        // Isto chama-se uma função recursiva ou algo parecido, idk, não andei na uni :)

                        menu_template.append(populateMenus(menu.children, count++));
                    }

                    template.append(menu_template[0].outerHTML);                    
                });

                return template[0].outerHTML;
            }

            
            function doneTyping() {
                $.ajax({
                    url: "/api/searchAjax?search=" + $('[name="search-items"]').val(),
                    type: "GET",
                    success: function (response) {
        
                        $('#resultsSearch').html(``);
                        if(response.data == undefined ) {
            
                            let template =`
                                <div>
                                    <p style="color: black;">
                                        Nenhum resultado encontrado.
                                    </p>                               
                                </div>`;
                            $("#resultsSearch").append(template);
                            $('#resultsSearch').attr('style','overflow: auto; height: 300px; padding: 10px; border: 1px solid #ccc;');
                            return false;
                        }
                        $.each(response.data, function (key, item) {
                            let template =`
                                <div>
                                    <p style="color: black;">` + item.type + `<strong class="name-page" data-id="`+ item.id +`" data-related="`+ item.related +`" data-url="`+ item.url +`"> <a href="javascript:void(0);">` + item.name + `</a></strong> </p>                               
                                </div>`;
                            $("#resultsSearch").append(template);
                            $('#resultsSearch').attr('style','overflow: auto; height: 300px; padding: 10px; border: 1px solid #ccc;');
                        });               
                        
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
            
                        console.log(textStatus, errorThrown);
                    }
                });
            }
      
            function checkTheTypeOfUrl (inputElement) {   
                $('#resultsSearch').html('');
                $type_url = false;         
                $.each(inputElement, function(index, value) {
                    if(value.checked == true) {
                        let id = $(value).attr("id");
                        if(id == 'external_links') {     
                            $("[name='related_id']").val('');                              
                            $("[name='doc_or_page']").val('');                              
                            $("#url_input").show();    
                            $('#searchitems').hide();                                                      
                        } else {    
                            $("#url_input").hide();       
                            $('#searchitems').show();                         
                        }
                        $type_url = id;
                    }
                })  

                return $type_url;
            }

            function menusListners() {

                // Ao clicar no botão remover
                $(".menu-action.remove i").off("click");
                $(".menu-action.remove i").on("click", function() {
                    let id = $(this).closest(".menu-block").data("id");

                    deleteMenu(id);

                    $("#big-menus-modal").modal("hide");
                });

                $(".remove-menu").off("click");
                $(".remove-menu").on("click", function() {

                    let id = $(".save-menu").data("id");

                    deleteMenu(id);

                    $("#big-menus-modal").modal("hide");
                });

                $("body").off("click", ".select-lang");
                $("body").on("click", ".select-lang", function() {     
                    $(".language-selected").html('')       ;
                    $(".language-selected").append(`
                        ` + $(this).text() + `
                    `);                   
                });

               $("body").off("click", ".name-page");
               $("body").on("click", ".name-page", function() {

                    let name = $(this).text();
                    let id = $(this).data('id');
                    let related = $(this).data('related');
                    let urlItem = $(this).data('url');

                    $("[name='search-items']").val(name);

                    $("[name='name']").val(name);

                    $("[name='url']").val(urlItem);

                    $("[name='related_id']").val(id);

                    $("[name='doc_or_page']").val(related);

                    $('#resultsSearch').html('');
                    
                    $('#resultsSearch').attr('style','');
                });

                $("body").off("change", "[name='url_type']");
                $("body").on("change", "[name='url_type']", function() {                    
                    let resultType =  checkTheTypeOfUrl($(this));                   
                    if(resultType == 'external_links') {
                        $("[name='name']").val();
                        $('#resultsSearch').attr('style','');
                    } 
                });


                var typingTimer;
                var doneTypingInterval = 1000;
                $('[name="search-items"]').keyup(function(e) {
                    if($("[name='url_type']:checked").attr('id') == 'internal_links') {
                        clearTimeout(typingTimer);
                        if ($('[name="search-items"]').val) {
                            typingTimer = setTimeout(doneTyping, doneTypingInterval);
                        }  
                    }                               
                })

                // Ao clicar no botão editar
                $(".menu-action.edit i").off("click");
                $(".menu-action.edit i").on("click", function() {

                    cleanEditor();

                    let id = $(this).closest(".menu-block").data("id");

                    // Adicionar o id ao botao de salvar
                    $(".save-menu").data("id", id);

                    $(".remove-menus").show();

                     // Introduzir os dados no modal
                    $.get("/api/menus/" + id, function(response) {


                        console.log(response);

                        $("[name='align']").prop('checked', false);

                        let menu_data = response.data;

                        $.each(menu_data, function(key, value) {

                            if (key == "newtab" ) {
                                if(value == "true") {
                                    $('#newtab-true').prop('checked', true);
                                } else {
                                    $('#newtab-false').prop('checked', true);
                                }
                            } else if (key == "url_type" ) {
                                if(value == "0") {
                                    $('#internal_links').prop('checked', true);
                                    $('#url_input').hide();
                                    $('#searchitems').show(); 
                                } else {
                                    $('#external_links').prop('checked', true);
                                    $('#url_input').show();
                                    $('#searchitems').hide(); 
                                }
                            } else if (key == "related_id") {
                                if(value != "0" && value != undefined && value != null && value != "") {                                  
                                    $('[name="search-items"]').val('Página / documento anexado.'); 
                                } 
                            } else {

                                $("#big-menus-modal [name='" + key + "']").val(value);
                            }
                        });


                        // Abrir o modal de editar
                        $("#big-menus-modal").modal("show");

                    });

                });


                // Ao clicar no botão change Active
                $(".menu-action.changeActive i").off("click");
                $(".menu-action.changeActive i").on("click", function() {                   

                    let id = $(this).closest(".menu-block").data("id");
                    let active = $(this).closest(".menu-block").data("active");

                    if(active == 0) {
                        active = 1;
                    } else {
                        active = 0;
                    }

                    changeActiveMenu(id, active);

                });

                // Ao clicar no botão search
                $("[name='search-items']").off("click");
                $("[name='search-items']").on("click", function() {                   

                    if($('[name="url_type"').attr('id') == 'internal_links') {
                        checkTheTypeOfUrl($('[name="url_type"'));
                    }

                });

                // Ao clicar no botão adicionar
                $(".menu-action.add i").off("click");
                $(".menu-action.add i").on("click", function() {                 

                    cleanEditor();

                    $(".remove-menus").hide();

                    $("[name='newtab']").prop('checked', false);

                    // Retirar id do botao
                    $(".save-menu").data("id", "");

                    let type = $(this).closest(".menu-block").data("type");
                    let parent_id = $(this).closest(".menu-block").data("id");
                    $('input[name="type"]').val(type);
                    $('input[name="parent"]').val(parent_id);
                    
                    $("#big-menus-modal").modal("show");

                });

            }

            function cleanEditor() {              
                $("#big-menus-modal form").trigger("reset");
                checkTheTypeOfUrl($('[name="url_type"]'));  
                $('#resultsSearch').attr('style','');
            }

            // Guardar o método de envio
            $(".save-menu").off("click");
            $(".save-menu").on("click", function() {

                // Vereficar se vamos guardar ou editar
                let id = $(this).data("id");               

                let data = $("#big-menus-modal form").serialize();

                if(id == "") {                    
                    addMenu(data);
                } else {
                    editMenu(id, data);
                }
                

                cleanEditor();

                $("#big-menus-modal").modal("hide");

                // Retirar o id do data-id para uma proxima ação
                $(this).data("id", "");
            });

            function changeActiveMenu (id, active) {
                $.ajax({
                    url: "/api/menus/changeActive",
                    type: "POST",
                    data: {id: id, active: active},
                    dataType: "json",
                    success: function (response) {

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

                        // Recarregar as menus atraves da database
                        menusInit();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                        console.log(textStatus, errorThrown);

                        $.alert({
                            title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                            theme: "supervan",
                            content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                        });
                    }
                });
            }

            

            function addMenu(data) {
                $.ajax({
                    url: "/api/menus/",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    success: function (response) {

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

                        // Recarregar as menus atraves da database
                        menusInit();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                        console.log(textStatus, errorThrown);

                        $.alert({
                            title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                            theme: "supervan",
                            content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                        });
                    }
                });
            }

            function editMenu(id, data) {

                $.ajax({
                    url: "/api/menus_update/" + id,
                    data: data,
                    type: "POST",
                    dataType: "json",
                    success: function (response) {

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

                        // Recarregar as menus atraves da database
                        menusInit();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                        console.log(textStatus, errorThrown);

                        $.alert({
                            title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                            theme: "supervan",
                            content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                        });
                    }
                });
            }

            function deleteMenu(id) {

                $.confirm({
                    title: "<?php echo e(ucfirst($translations["backoffice"]["confirm"])); ?>",
                    theme: "supervan",
                    content: '<?php echo e(ucfirst($translations["backoffice"]["confirm_message_menu_remove"])); ?>',
                    buttons: {

                        Sim: function () {
                            $.ajax({
                                url: "/api/menus/" + id,
                                type: "DELETE",
                                dataType: "json",
                                success: function (response) {

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

                                    // Recarregar as menus atraves da database
                                    menusInit();
                                },
                                error: function (jqXHR, textStatus, errorThrown) {

                                    console.log(textStatus, errorThrown);

                                    $.alert({
                                        title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                                        theme: "supervan",
                                        content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                                    });
                                }
                            });

                        },
                        Não: {}
                    }
                });
            }

            function listToTree(data) {

                const ID_KEY          = "id";
                const PARENT_KEY      = "parent";
                const CHILDREN_KEY    = "children";

                let item, id, parentId;
                let map = {};

                for (var i = 0; i < data.length; i++ ) {

                    if (data[i][ID_KEY]) {

                        map[data[i][ID_KEY]]    = data[i];
                        data[i][CHILDREN_KEY]   = [];
                    }
                }

                for (var i = 0; i < data.length; i++) {

                    if (data[i][PARENT_KEY]) { 

                        if (map[data[i][PARENT_KEY]]) {

                            map[data[i][PARENT_KEY]][CHILDREN_KEY].push(data[i]);   // Adicionar o filho ao pai
                            data.splice( i, 1 );                                    // Remover a menu do root
                            i--;                                                    // Corrigir a iteração

                        } else {

                            data[i][PARENT_KEY] = 0;
                        }
                    }
                };
                
                return data;
            }

            // O callback serve para ser chamado depois de as linguas carregarem
            function getLanguages(callback) {

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
        }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\backoffice/pages/menus/index.blade.php ENDPATH**/ ?>