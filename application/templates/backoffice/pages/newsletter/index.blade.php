@extends('layouts.master')
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <h1>{{ ucfirst($translations["backoffice"]["title_list_newsletter"]) }}</h1>
                        <div class="btn-group top-right-button-container">
                            <div class="btn btn-primary btn-lg pl-4 pr-0 check-button">
                                <label class="custom-control custom-checkbox mb-0 d-inline-block">
                                    <input type="checkbox" class="custom-control-input" id="checkAll">
                                    <span class="custom-control-label">&nbsp;</span>
                                </label>
                            </div>
                            <button type="button" class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split botaodrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" onclick="deleteMultiple()"> Eliminar Selecionados <i class="simple-icon-trash btn-outline-danger"></i></a>
                                <a href="/api/newsletter/export" target="_blank" class="dropdown-item">Exportar CSV</a>
                            </div>
                        </div>
                        <div class="float-sm-right text-zero">
                            {{-- <button type="button" class="btn btn-outline-primary top-center-button mr-1" data-toggle="modal" data-backdrop="static" data-target="#new-newsletter-modal">Adicionar newsletter</button> --}}
                        </div>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ ucfirst($translations["backoffice"]["newsletter"]) }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="separator mb-5"></div>
                </div>
            </div>       
            <div class="row">
                <!--<div class="col-12">                 
                    <a href="/api/newsletter/export" target="_blank" class="btn btn-success">Exportar CSV</a>
                </div>
                <div class="card col-12 p-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ ucfirst($translations["backoffice"]["newsletter_email"]) }}</th>
                                        <th scope="col">{{ ucfirst($translations["backoffice"]["newsletter_ip"]) }}</th>
                                        <th scope="col">{{ ucfirst($translations["backoffice"]["newsletter_language"]) }}</th>
                                        <th scope="col">{{ ucfirst($translations["backoffice"]["newsletter_date"]) }}</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div> -->
                    <div class="col-12">                 
                        <a href="/api/newsletter/export" target="_blank" class="btn btn-success">Exportar CSV</a>
                    </div>
                    <div class="card col-12 p-0">
                        <div class="card-body">
                            <div class="table-responsive">
                                <h4 class="inline">{{ ucfirst($translations["backoffice"]["newsletter"]) }}</h4> 
                                <hr>
                                <div class="table-responsive">
                                    <table id="thetable2" class="dt-responsive stripe languages-table dataTable no-footer dtr-inline" >
                                        <thead>
                                            <tr role="row">
                                                <th class="pl-0">#</th>
                                                <th class="pl-0">{{ ucfirst($translations["backoffice"]["newsletter_email"]) }}</th>
                                                <th class="pl-0">{{ ucfirst($translations["backoffice"]["newsletter_ip"]) }}</th>
                                                <th class="pl-0">{{ ucfirst($translations["backoffice"]["newsletter_language"]) }}</th>
                                                <th class="pl-0">{{ ucfirst($translations["backoffice"]["newsletter_date"]) }}</th>
                                                <th class="pl-0"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="newsletter-table">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <nav class="mt-4 mb-3">
                        <ul class="pagination justify-content-center mb-0">
                        </ul>
                    </nav>
                </div>
            </div> 
        </div>
        	<!-- NOVO NEWSLETTER MODAL -->
{{--	<div class="modal fade modal-right" id="new-newsletter-modal" tabindex="-1" role="dialog" aria-labelledby="new-newsletter-modal" aria-hidden="true">--}}
{{--		<div class="modal-dialog" role="document">--}}
{{--			<div class="modal-content">--}}
{{--				<div class="modal-body">--}}
{{--					<form>--}}
{{--						<div class="form-group">--}}
{{--							<label>Email</label>--}}
{{--							<input id="newsletter_email" placeholder="exemple@gmail.com" class="form-control"></input>--}}
{{--						</div>--}}
{{--						<div class="form-group">--}}
{{--							<label>Nome</label>--}}
{{--							<input id="newsletter_name" placeholder="Charlie" class="form-control"></input>--}}
{{--						</div>--}}
{{--					</form>--}}
{{--				</div>--}}
{{--				<div class="modal-footer">--}}
{{--					<button type="button" class="btn btn-outline-primary" data-dismiss="modal">Anular</button>--}}
{{--					<button type="button" class="btn btn-primary" id="insert-new-modal-button">Create</button>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--		</div>--}}
{{--	</div>--}}
    </main>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@section('scripts')
    <script>

        /*
            Filtros, página, etc deste index
            Os valores que metemos aqui, são os valores iniciais
        */

	    let query 	= parseQueryString();

        var page = (query.page !== undefined) ? query.page : 1;

        load();
        
        function load() {

            $.ajax({
                url: "/api/newsletter?page=" + page,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (!response.success) {

                        $.alert({
                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                            theme: "supervan",
                            content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                        });

                        // Não deixar a função executar mais
                        return;
                    }

                    populate(response.data);

                    // Paginação
                    if (response.pagination !== undefined) {

                        let pagination 	= response.pagination;
                        let page  		= pagination.page;
                        let pages 		= Math.ceil(pagination.total / pagination.limit); // Calcular o total de páginas

                        // Adicionar o html dos botões da paginação debaixo da lista
                        $(".pagination").html(pagination_template(page, pages));
                    }

                    // Carregar os listners, outra vez se for preciso
                    listners();

                },
                error: function(jqXHR, textStatus, errorThrown) {

                    console.log(textStatus, errorThrown);

                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });
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
                window.scroll({top: 0, behavior: "smooth"})

                // Recarregar os dados da API
                load();
            });            

            //Ao clicar no eliminar
            $(".remove-newsletter").off("click");
            $(".remove-newsletter").on("click", function() {

                let id = $(this).closest("tr").data("id");

                removeNewsletter(id);
            });
        }
    // Eliminar a newsletter
    function removeNewsletter(id) {

    $.confirm({
        title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
        theme: "supervan",
        content: '{{ ucfirst($translations["backoffice"]["confirm_message_remove_newsletter"]) }}',
        buttons: {

            Sim: function() {
                $.ajax({
                    url: "/api/newsletter/" + id,
                    // Usamos POST em vez de PUT por causa que algumas vezes os clientes metem milhares de linhas
                    // De texto, etc e em alguns servidores pode dar erro
                    type: "DELETE",
                    dataType: "json",
                    success: function(response) {

                        if (!response.success) {

                            // Output do erro
                            console.error(response);

                            $.alert({
                                title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                theme: "supervan",
                                content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                            });

                            // Não deixar a função executar mais
                            return;
                        }

                        // Obter dados novos do servidor
                        load();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                        console.log(textStatus, errorThrown);

                        $.alert({
                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                            theme: "supervan",
                            content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                        });
                    }
                });

            },
            Não: {}
        }
    });
}
        function populate(items) {

            // Limpar a lista de items que temos
            $("tbody").html("");

            $.each(items, function(key, item) {

                let template = `
                    <tr class="text-muted" id="tblData"  data-id="`+ item.id + `">
                        <th scope="row">` + item.id + `</th>
                        <td class="pr-3">` + item.email + `</td>
                        <td class="pr-3"><span class="badge badge-light w-100">` + item.ip + `</span></td>
                        <td class="pr-3"><span class="badge badge-secondary text-uppercase w-100">` + item.lang + `</span></td>
                        <td class="pr-3"><span class="badge badge-primary">` + item.date + `</span></td>
                        <td>
                        <label class="custom-control custom-checkbox align-self-center float-right ml-2">
										<input type="checkbox" name="selected_ids[]" value="` + item.id + `" class="checkbox-allowed custom-control-input">
						            	<span class="custom-control-label"></span>
						        	</label>
                            <a href="javascript:void(0)" style="margin-left: 4px;" class="btn btn-xs btn-danger float-right remove-newsletter"><i class="simple-icon-trash"></i></a>
                        </td>
                    </tr>
                                `;


                $("tbody").append(template);
            });

            // Caso o items esteja vazio

            if (items === undefined || items.length == 0) {

                // Na listagem meter uma mensagem a dizer que está vazio
                $("tbody").html(`
                <br><br>
                    <h4>{{ ucfirst($translations["backoffice"]["not_found_female"]) }} {{ ucfirst($translations["backoffice"]["newsletter"]) }}</h4>
                    <p class="text-muted">{{ ucfirst($translations["backoffice"]["try_again_later_empty"]) }}</p>
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
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_many_product_remove"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/newsletter_multiple",
                            type: "POST",
                            data: {selected},
                            dataType: "json",
                            success: function (response) {

                                if (!response.success) {

                                    // Output do erro
                                    console.error(response);

                                    $.alert({
                                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                        theme: "supervan",
                                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                                    });

                                    // Não deixar a função executar mais
                                    return;
                                }

                                // Rederecionar para a página de index das notícias
                                window.location.replace("/adm/newsletter/");
                            },
                            error: function (jqXHR, textStatus, errorThrown) {

                                console.log(textStatus, errorThrown);

                                $.alert({
                                    title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                    theme: "supervan",
                                    content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                                });
                            }
                        });

                    },
                    Não: {}
                }
            });
         
            console.log(selected);
        }

        $("#insert-new-modal-button").on( "click", function() {

        var email = $("#newsletter_email").val();
        var name  = $("#newsletter_name").val();

        $.ajax({
            url: '/api/newsletter',
            type: 'PUT',
            dataType: 'json',
            success: function(data) {

                if (data.success) {

                    success('{{ ucfirst($translations["backoffice"]["newsletter_authorization_create"]) }}');

                    setTimeout(function() {

                        location.reload();

                    }, 2000);

                } else {

                    error("{{ ucfirst($translations["backoffice"]["newsletter_authorization_error"]) }}.");
                }
            },

        error: function() {

            error("{{ ucfirst($translations["backoffice"]["newsletter_authorization_uncreated"]) }}");
        }
    });
});
        function pagination_template(page, pages) {

            // Nav template
            let nav = "";
            let number_of_extra_pagination_button = 4;
            
            if (page != 1) {
                
                nav += '<li class="page-item"><a class="page-link" data-page="' +  1 + '"><i class="simple-icon-control-start"></i></a></li>';
                nav += '<li class="page-item"><a class="page-link" data-page="' +  (page - 1) + '"><i class="simple-icon-arrow-left"></i></a></li>';
            }
            
            let start_loop = page - number_of_extra_pagination_button;
                start_loop = (start_loop <= 0) ? 1 : start_loop;
            
            let end_loop   = page + number_of_extra_pagination_button;
                end_loop   = (end_loop > pages) ? pages : end_loop;
            
            for (let i = start_loop; i <= end_loop; i++) {
                
                let pageActive = "";
                if (i == page) { pageActive = "active"; }
                
                nav += '<li class="page-item ' + pageActive + '"><a class="page-link" data-page="' +  i + '">' + i + '</a></li>';
            }

            if (page < pages) {
                
                nav += '<li class="page-item"><a class="page-link" data-page="' +  (page + 1) + '"><i class="simple-icon-arrow-right"></i></a></li>';
                nav += '<li class="page-item"><a class="page-link" data-page="' +  pages + '"><i class="simple-icon-control-end"></i></a></li>';
            }

            return nav;
        }

    </script>
@endsection
