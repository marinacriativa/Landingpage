
<?php $__env->startSection('content'); ?>
    <main class="listing-page collapsable-main no-load" data-type="clients">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <h1><?php echo e(ucfirst($translations["backoffice"]["title_list_team"])); ?></h1>
                        <?php if($user['role'] == '0'): ?>
                            <div class="btn-group top-right-button-container">
                                <div class="btn btn-primary btn-lg pl-4 pr-0 check-button">
                                    <label class="custom-control custom-checkbox mb-0 d-inline-block">
                                        <input type="checkbox" class="custom-control-input" id="checkAll">
                                        <span class="custom-control-label">&nbsp;</span>
                                    </label>
                                </div>
                                <button type="button" class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split botaodrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" onclick="deleteMultiple()"> Eliminar Selecionados <i class="simple-icon-trash btn-outline-danger"></i></a>
                                </div>
                            </div>
                        
                            <div class="text-zero top-right-button-container">
                                <div class="btn-group">
                                    <a href="javascript:void(0)" type="button"
                                    class="btn btn-primary top-center-button mr-1 new-item-button"
                                    style="padding: 9px 34px;"><?php echo e(ucfirst($translations["backoffice"]["team_btn_new_member"])); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm"><?php echo e(ucfirst($translations["backoffice"]["store"])); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?php echo e(ucfirst($translations["backoffice"]["team"])); ?>

                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="mb-2">



                        <?php if($user['role'] == '0'): ?>
                            <div class="collapse d-md-block" id="displayOptions">
                                <div class="d-block d-md-inline-block">
                                    <div class="btn-group float-md-left mr-1 mb-1">
                                        <button class="btn btn-outline-dark btn-xs dropdown-toggle users-order-menu"
                                            type="button" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false"><?php echo e(ucfirst($translations["backoffice"]["order_by"])); ?></button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item order-menu" data-order="name"><?php echo e(ucfirst($translations["backoffice"]["orderBy_name"])); ?></a>
                                            <a class="dropdown-item order-menu" data-order="dt"><?php echo e(ucfirst($translations["backoffice"]["orderBy_date"])); ?></a>
                                        </div>
                                    </div>
                                    <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                                        <input placeholder="Procurar...">
                                    </div>
                                    <a class="search-button"><i class="simple-icon-magnifier"></i></a>
                                </div>
                                <div class="float-md-right">
                                    <span class="text-muted text-small mr-1"><?php echo e(ucfirst($translations["backoffice"]["items_per_page"])); ?> </span><button
                                        class="btn btn-outline-dark btn-xs dropdown-toggle users-lenght-menu" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">10</button>
                                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                                        <a class="dropdown-item length-link" data-length="10">10</a>
                                        <a class="dropdown-item length-link" data-length="50">50</a>
                                        <a class="dropdown-item length-link" data-length="100">100</a>
                                        <a class="dropdown-item length-link" data-length="150">150</a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 list" data-check-all="checkAll">
                </div>
                <div class="col-12">
                    <nav class="mt-4 mb-3">
                        <ul class="pagination justify-content-center mb-0">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </main>

    <div class="modal modal-fullscreen fade" id="teamModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-fullscreen" role="document">
            <div class="modal-content modal-content-fullscreen">
                <div class="modal-body modal-body-fullscreen">
                    <div class="container">
                        <div class="mb-2">
                            <h1 id="teamModalTitleMain"></h1>
                            <div class="text-zero top-right-button-container">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                                <ol class="breadcrumb pt-0">
                                    <li class="breadcrumb-item"><a data-dismiss="modal" href="javascript:void(0)"><?php echo e(ucfirst($translations["backoffice"]["team"])); ?></a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?php echo e(ucfirst($translations["backoffice"]["title_edit_member"])); ?></li>
                                </ol>
                            </nav>
                        </div>
                        <form>
                            <div class="card unset-shadow">
                                <ul class="nav nav-tabs separator-tabs ml-0 mb-5" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active pl-2 pr-2" data-toggle="tab" href="#personal-info-user" role="tab" aria-controls="personal-info-user" aria-selected="true"><?php echo e(ucfirst($translations["backoffice"]["team_member_information"])); ?></a>
                                    </li>
                                    <?php if($user['role'] == '0'): ?>
                                        <li class="nav-item">
                                            <a class="nav-link pl-2 pr-2" data-toggle="tab" href="#notification-config-user" role="tab" aria-controls="notification-config-user" aria-selected="true"><?php echo e(ucfirst($translations["backoffice"]["team_member_notifications"])); ?></a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="personal-info-user" role="tabpanel" aria-labelledby="personal-info">
                                        <div class="row">
                                            <div class="col-xs-12 col-lg-6 col-xl-6">
                                                <h4><?php echo e(ucfirst($translations["backoffice"]["team_member_credentials"])); ?></h4>
                                                <div class="separator mb-3"></div>
                                                <div class="form-group position-relative error-l-100">
                                                    <label><?php echo e(ucfirst($translations["backoffice"]["team_member_fill_email"])); ?> *</label>
                                                    <input type="email" class="form-control" name="email" placeholder="Endereço de email" autocomplete="off">
                                                </div>
                                                <div class="form-group position-relative error-l-100">
                                                    <label><?php echo e(ucfirst($translations["backoffice"]["team_member_fill_password"])); ?> *</label>
                                                    <input type="text" class="form-control" name="password" placeholder="Única e segura" autocomplete="off">
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-12 ">
                                                        <label><?php echo e(ucfirst($translations["backoffice"]["team_member_status"])); ?></label>
                                                        <select class="form-control" name="isactive">
                                                            <option value="1"><?php echo e(ucfirst($translations["backoffice"]["team_member_status_active"])); ?></option>
                                                            <option value="0"><?php echo e(ucfirst($translations["backoffice"]["team_member_status_inactive"])); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-lg-6 col-xl-6">
                                                <h4><?php echo e(ucfirst($translations["backoffice"]["team_member_personal_info"])); ?></h4>
                                                <div class="separator mb-3"></div>
                                                <div class="form-row">
                                                    <div class="form-group error-l-100 col">
                                                        <label><?php echo e(ucfirst($translations["backoffice"]["team_member_fill_name"])); ?></label>
                                                        <input type="text" name="name" id="addNewMemberName" class="form-control" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col">
                                                        <label><?php echo e(ucfirst($translations["backoffice"]["team_member_fill_phone"])); ?></label>
                                                        <input type="number" name="phone" class="form-control" autocomplete="off" placeholder="">
                                                    </div>
                                                </div>
                                                <?php if($user['role'] == '0'): ?>
                                                    <div class="form-row">
                                                        <div class="form-group col-12 ">
                                                            <label><?php echo e(ucfirst($translations["backoffice"]["team_member_role"])); ?></label>
                                                            <select class="form-control" name="role">
                                                                <option value="0"><?php echo e(ucfirst($translations["backoffice"]["team_member_admin"])); ?></option>
                                                                <option value="1"><?php echo e(ucfirst($translations["backoffice"]["team_member_teacher"])); ?></option>
                                                                <option value="2"><?php echo e(ucfirst($translations["backoffice"]["team_member_student"])); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="w-100 row m-0">
                                            <div class="default pull-left-margin ">
                                                <a type="button" class="btn btn-outline-info btn-xs m-1 ml-2 save-button" href="javascript:void(0)"><?php echo e(ucfirst($translations["backoffice"]["team_member_btn_save"])); ?></a>
                                                <a type="button" class="btn btn-outline-danger btn-xs m-1 ml-2 delete-button" href="javascript:void(0)"><?php echo e(ucfirst($translations["backoffice"]["team_member_btn_remove"])); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="notification-config-user" role="tabpanel" aria-labelledby="notification-config-user">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4><?php echo e(ucfirst($translations["backoffice"]["team_member_permissions_notifications"])); ?></h4>
                                                <div class="separator mb-3"></div>
                                                <div class="form-row">
                                                    <div class="form-group col-12">
                                                        <label><?php echo e(ucfirst($translations["backoffice"]["member_notifications_clients"])); ?></label>
                                                        <select class="form-control" name="notification_new_client">
                                                            <option value="1"><?php echo e(ucfirst($translations["backoffice"]["member_notifications_active"])); ?></option>
                                                            <option value="0"><?php echo e(ucfirst($translations["backoffice"]["member_notifications_inactive"])); ?></option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-12">
                                                        <label><?php echo e(ucfirst($translations["backoffice"]["member_notifications_order"])); ?></label>
                                                        <select class="form-control" name="notification_new_order">
                                                            <option value="1"><?php echo e(ucfirst($translations["backoffice"]["member_notifications_active"])); ?></option>
                                                            <option value="0"><?php echo e(ucfirst($translations["backoffice"]["member_notifications_inactive"])); ?></option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-12">
                                                        <label><?php echo e(ucfirst($translations["backoffice"]["member_notifications_ticket"])); ?></label>
                                                        <select class="form-control" name="notification_new_ticket">
                                                            <option value="1"><?php echo e(ucfirst($translations["backoffice"]["member_notifications_active"])); ?></option>
                                                            <option value="0"><?php echo e(ucfirst($translations["backoffice"]["member_notifications_inactive"])); ?></option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-12">
                                                        <label><?php echo e(ucfirst($translations["backoffice"]["member_notifications_contact"])); ?></label>
                                                        <select class="form-control" name="notification_new_contact">
                                                            <option value="1"><?php echo e(ucfirst($translations["backoffice"]["member_notifications_active"])); ?></option>
                                                            <option value="0"><?php echo e(ucfirst($translations["backoffice"]["member_notifications_inactive"])); ?></option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-12">
                                                        <label><?php echo e(ucfirst($translations["backoffice"]["member_notifications_stock"])); ?></label>
                                                        <select class="form-control" name="notification_empty_stock">
                                                            <option value="1"><?php echo e(ucfirst($translations["backoffice"]["member_notifications_active"])); ?></option>
                                                            <option value="0"><?php echo e(ucfirst($translations["backoffice"]["member_notifications_inactive"])); ?></option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-12">
                                                        <label>Poder ser selecionado por clientes na página de contactos</label>
                                                        <select class="form-control" name="can_be_selected_contact_form">
                                                            <option value="1"><?php echo e(ucfirst($translations["backoffice"]["member_notifications_active"])); ?></option>
                                                            <option value="0"><?php echo e(ucfirst($translations["backoffice"]["member_notifications_inactive"])); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="w-100 row m-0">
                                            <div class="default pull-left-margin ">
                                                <a type="button" class="btn btn-outline-info btn-xs m-1 ml-2 save-button" href="javascript:void(0)"><?php echo e(ucfirst($translations["backoffice"]["member_notifications_save"])); ?></a>
                                                <a type="button" class="btn btn-outline-danger btn-xs m-1 ml-2 delete-button" href="javascript:void(0)"><?php echo e(ucfirst($translations["backoffice"]["member_notifications_remove"])); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<?php $__env->startSection('scripts'); ?>
    <script>

        /*
        Filtros, página, etc deste index
        Os valores que metemos aqui, são os valores iniciais
        */

        let query = parseQueryString();

        var page = (query.page !== undefined) ? query.page : 1;
        var limit = (query.limit !== undefined) ? query.limit : 10;
        var order = (query.order !== undefined) ? query.order : "id";
        var search = (query.search !== undefined) ? query.search : "";

        // Meter o input search com os valores do GET se tiver
        if (query.search !== undefined && query.search.length > 0) {

            $(".search-sm input").val(query.search);
        }

        if (query.limit !== undefined && query.limit.length > 0) {

            $(".users-lenght-menu").text(limit);
        }

        //Iniciar a página dos Tickes
        load();

        function load() {

            // Atualizar o url para ter os novos parametros GET
            window.history.replaceState("", "", '/adm/team?' + $.param({
                limit: limit,
                order: order,
                page: page,
                search: search,
            }));

            $.ajax({
                url: "/api/users?page=" + page + "&search=" + search + "&length=" + limit + "&order=" + order + "&type=2",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (!response.success) {

                        $.alert({
                            title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                            theme: "supervan",
                            content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                        });
                        // Não deixar a função executar mais
                        return;
                    }
                    // Inserir as mensagens obtidas pela api na listagem
                    populate(response.data);
                    // Paginação
                    if (response.pagination !== undefined) {

                        let pagination = response.pagination;
                        let page = pagination.page;
                        let pages = Math.ceil(pagination.total / pagination
                            .limit); // Calcular o total de páginas

                        // Adicionar o html dos botões da paginação debaixo da lista
                        $(".pagination").html(pagination_template(page, pages));
                    }
                    // Ativar os listners
                    listners();
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
       
        function populate(items) {

            // Limpar a lista de items que temos
            $(".list").html("");
            
            $.each(items, function(key, item) {
                let template =
                    `
                    <div id="cardRowContainer">
                        <div class="card d-flex flex-row mb-3">
                            <a class="d-flex a-index-img align-self-center mx-2" data-edit-id="` + item.id + `" href="javascript:void(0)">
                                <i class="simple-icon-user" style="font-size:30px;"></i>
                            </a>
                            <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                                <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center">
                                    <a  data-edit-id="` + item.id + `" href="javascript:void(0)" class="w-60 w-sm-100 truncate">
                                        <p class="list-item-heading mb-0 truncate">` +  item.name + `</p>
                                    </a>
                                    <p class="mb-0 text-muted text-small w-20 w-sm-100">` + item.email + `</p>
                                    <p class="mb-0 text-muted text-small w-20 w-sm-100">` + item.phone + `</p>
                                    <div class="w-40 w-sm-100 ">
								        <label class="custom-control custom-checkbox align-self-center float-right ml-2 my-1 mr-3">
                                            <input type="checkbox" name="selected_ids[]" value="` + item.id + `" class="checkbox-allowed custom-control-input">
						                 	<span class="custom-control-label"></span>
						            	</label>
								    	<button class="btn btn-outline-danger mb-1 btn-xs m-1 float-right" name="delte_slide_btn " title="apagar" id="delte_slide_btn" onclick="removeUser(` + item.id + `)"><i class="simple-icon-trash"></i></button>
                                        <a class="btn btn-outline-secondary mb-1 btn-xs m-1 float-right" name="edit_slide_btn" title="editar" id="edit_slide_btn" data-edit-id="` + item.id + `" href="javascript:void(0)"><i class="simple-icon-pencil"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                  
                    `;

                $(".list").append(template);
            });

            // Caso o items esteja vazio

            if (items === undefined || items.length == 0) {

                // Na listagem meter uma mensagem a dizer que está vazio
                $(".list").html(`
                            <h4><?php echo e(ucfirst($translations["backoffice"]["team_empty"])); ?></h4>
                        `);
            }
        }

        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        function deleteMultiple () {
            var selected = [];

            $('.checkbox-allowed:checked').each(function(){
                selected.push($(this).val());
            });

            $.confirm({
                title: '<?php echo e(ucfirst($translations["backoffice"]["confirm"])); ?>',
                theme: "supervan",
                content: '<?php echo e(ucfirst($translations["backoffice"]["confirm_many_product_remove"])); ?>',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/users_multiple",
                            type: "POST",
                            data: {selected},
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

                                // Redirecionar para a página de index das notícias
                                window.location.replace("/adm/team/");
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
         
            console.log(selected);
        }

        function removeUser(id) {
            $.confirm({
                title: '<?php echo e(ucfirst($translations["backoffice"]["confirm"])); ?>',
                theme: "supervan",
                content: '<?php echo e(ucfirst($translations["backoffice"]["confirm_product_remove"])); ?>',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/users/" + id,
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

                                // Redirecionar para a página de index dos teams
                                window.location.replace("/adm/team/");
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

        function listners() {

            // Ao clicar na paginação
            $("body").off("click", ".page-link");
            $("body").on("click", ".page-link", function() {

                // Definir a nova página
                page = $(this).data("page");

                // Fazer scroll para cima, mas smoooooth
                window.scroll({
                    top: 0,
                    behavior: "smooth"
                })

                // Recarregar os dados da API
                load();
            });

            // Dropdown de mudar o numero de items na página
            $(".length-link").off("click");
            $(".length-link").on("click", function() {

                limit = $(this).data("length");
                page = 1;

                $(".users-lenght-menu").text(limit);
                load();
            });

            // Dropdown de mudar a ordenação dos items
            $(".order-menu").off("click");
            $(".order-menu").on("click", function() {

                order = $(this).data("order");
                page = 1;

                $(".users-order-menu").text($(this).text());
                load();
            });

            $(".search-button").off("click");
            $(".search-button").on("click", function() {

                search = $(".search-sm input").val();
                load();
            });

            $('.search-sm input').unbind("enterKey");
            $('.search-sm input').bind("enterKey", function(e) {

                search = $(".search-sm input").val();
                load();
            });

            $('.search-sm input').keyup(function(e) {

                if (e.keyCode == 13) {

                    $(this).trigger("enterKey");
                }
            });

            $(".new-item-button").off("click");
            $(".new-item-button").on("click", function() {

                // Limpar editor
                $("#teamModal input").val("");

                // Eliminar o id do botao de guardar
                $(".save-button").data("id", "");

                $("#teamModalTitleMain").text("Novo membro");

                // Abrir o modal de editar
                $("#teamModal").modal("show");
            });

            $(".delete-button").off("click");
            $(".delete-button").on("click", function() {

                let id = $(".save-button").data("id");

                $.confirm({
                    title: '<?php echo e(ucfirst($translations["backoffice"]["confirm"])); ?>',
                    theme: "supervan",
                    content: '<?php echo e(ucfirst($translations["backoffice"]["confirm_message_remove_member"])); ?>',
                    buttons: {

                        Sim: function () {
                            $.ajax({
                                url: "/api/users/" + id,
                                // Usamos POST em vez de PUT por causa que algumas vezes os clientes metem milhares de linhas
                                // De texto, etc e em alguns servidores pode dar erro
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
                                    $("#teamModal").modal("hide");
                                    load();
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
            });

            $(".save-button").off("click");
            $(".save-button").on("click", function() {

                let id = $(this).data("id");

                if (id == null || id == false || id == undefined) {

                    id = "";
                }

                let data = $("#teamModal form").serialize();
                console.log(data);

                $.ajax({
                    url: "/api/users/" + id,
                    type: "POST",
                    data: data,
                    dataType: "json",
                    success: function(response) {

                        if (!response.success) {

                            $.alert({
                                title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                                theme: "supervan",
                                content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                            });

                            // Não deixar a função executar mais
                            return;
                        }

                        $("#teamModal").modal("hide");

                        load();
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
            });

            // Ao clicar em editar
            $("[data-edit-id]").off("click");
            $("[data-edit-id]").on("click", function() {

                $("#teamModalTitleMain").text("Editar membro");

                // Limpar editor
                $("#teamModal input").val("");

                let id = $(this).data("edit-id");

                // Introduzir o id do botao de guardar
                $(".save-button").data("id", id);

                $.ajax({
                    url: "/api/users/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {

                        if (!response.success) {

                            $.alert({
                                title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                                theme: "supervan",
                                content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                            });

                            // Não deixar a função executar mais
                            return;
                        }

                        delete response.data.client_data.password;

                        $.each(response.data.client_data, function(key, value) {

                            $("#teamModal [name='" + key + "']").val(value);
                        });

                        // Abrir o modal de editar
                        $("#teamModal").modal("show");
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
            });
        }

        function pagination_template(page, pages) {

            // Nav template
            let nav = "";
            let number_of_extra_pagination_button = 4;

            if (page != 1) {

                nav += '<li class="page-item"><a class="page-link" data-page="' + 1 +
                    '"><i class="simple-icon-control-start"></i></a></li>';
                nav += '<li class="page-item"><a class="page-link" data-page="' + (page - 1) +
                    '"><i class="simple-icon-arrow-left"></i></a></li>';
            }

            let start_loop = page - number_of_extra_pagination_button;
            start_loop = (start_loop <= 0) ? 1 : start_loop;

            let end_loop = page + number_of_extra_pagination_button;
            end_loop = (end_loop > pages) ? pages : end_loop;

            for (let i = start_loop; i <= end_loop; i++) {

                let pageActive = "";
                if (i == page) {
                    pageActive = "active";
                }

                nav += '<li class="page-item ' + pageActive + '"><a class="page-link" data-page="' + i + '">' + i +
                    '</a></li>';
            }

            if (page < pages) {

                nav += '<li class="page-item"><a class="page-link" data-page="' + (page + 1) +
                    '"><i class="simple-icon-arrow-right"></i></a></li>';
                nav += '<li class="page-item"><a class="page-link" data-page="' + pages +
                    '"><i class="simple-icon-control-end"></i></a></li>';
            }

            return nav;
        }

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\backoffice/pages/team/index.blade.php ENDPATH**/ ?>