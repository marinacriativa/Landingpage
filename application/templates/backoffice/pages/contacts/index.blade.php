@extends('layouts.master')
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <h1>{{ ucfirst($translations["backoffice"]["title_list_contacts"]) }}</h1>
                        <div class="text-zero top-right-button-container">
                        </div>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ ucfirst($translations["backoffice"]["contact_requests"]) }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="separator mb-5"></div>
                </div>
            </div>

            <div class="row">
                <div class="card col-12 p-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">{{ ucfirst($translations["backoffice"]["contact_name"]) }}</th>
                                        <th scope="col">{{ ucfirst($translations["backoffice"]["contact_subject"]) }}</th>
                                        <th scope="col">{{ ucfirst($translations["backoffice"]["contact_phone"]) }}</th>
                                        <th scope="col">{{ ucfirst($translations["backoffice"]["contact_email"]) }}</th>
                                        <th scope="col">{{ ucfirst($translations["backoffice"]["contact_date"]) }}</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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
    </main>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@section('scripts')
    <script>

        /*
            Filtros, p??gina, etc deste index
            Os valores que metemos aqui, s??o os valores iniciais
        */

	    let query 	= parseQueryString();

        var page = (query.page !== undefined) ? query.page : 1;

        load();

        function load() {

            $.ajax({
                url: "/api/contacts?page=" + page,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (!response.success) {

                        $.alert({
                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                            theme: "supervan",
                            content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                        });

                        // N??o deixar a fun????o executar mais
                        return;
                    }

                    populate(response.data);

                    // Pagina????o
                    if (response.pagination !== undefined) {

                        let pagination 	= response.pagination;
                        let page  		= pagination.page;
                        let pages 		= Math.ceil(pagination.total / pagination.limit); // Calcular o total de p??ginas

                        // Adicionar o html dos bot??es da pagina????o debaixo da lista
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

            // Ao clicar na pagina????o
            $("body").off("click", ".page-link");
            $("body").on("click", ".page-link", function() {

                // Definir a nova p??gina
                page = $(this).data("page");

                // Fazer scroll para cima, mas smoooooth
                window.scroll({top: 0, behavior: "smooth"})

                // Recarregar os dados da API
                load();
            });

                //Ao clicar no eliminar
                $(".remove-contacts").off("click");
                $(".remove-contacts").on("click", function() {

                let id = $(this).closest("tr").data("id");

                removeContacts(id);

            });

        }
    // Eliminar a contacto
    function removeContacts(id) {

    $.confirm({
        title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}!',
        theme: "supervan",
        content: '{{ ucfirst($translations["backoffice"]["confirm_message_remove_contact"]) }}',
        buttons: {

            Sim: function() {
                $.ajax({
                    url: "/api/contacts/" + id,
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

                            // N??o deixar a fun????o executar mais
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
            N??o: {}
        }
    });
}

        function populate(items) {

            // Limpar a lista de items que temos
            $("tbody").html("");

            $.each(items, function(key, item) {

                let seen = "";

                if (item.seen != "1") {
                    
                    seen = `<span class="badge badge-light text-uppercase text-bold w-100">{{ ucfirst($translations["backoffice"]["contact_status_new"]) }}</span>`;

                } else {

                    seen = `<span class="badge badge-success text-uppercase text-bold w-100">{{ ucfirst($translations["backoffice"]["contact_status_seen"]) }}</span>`;
                }

                let template = `
                    <tr class="text-muted" data-id="`+ item.id + `">
                        <th>` + seen + `</th>
                        <th class="font-weight-bold">` + item.name + ` ` + item.surname + `</th>
                        <td>` + item.subject + `</td>
                        <td><span class="badge badge-light w-100">` + item.contact + `</span></td>
                        <td><span class="badge badge-light w-100">` + item.email + `</span></td>
                        <td><span class="badge badge-secondary text-uppercase">` + item.date + `</span></td>
                        <td class="d-flex">
                           <a href="/adm/contacts/` + item.id + `"> <button  class="btn btn-outline-primary btn-xs float-right mr-2 ml-2" ><i class="simple-icon-eye"></i></button></a>
                           <a href="javascript:void(0)" style="margin-left: 4px;" class="btn btn-xs btn-danger float-right remove-contacts"><i class="simple-icon-trash"></i></a>    
                        </td>
                    </tr>`;


                $("tbody").append(template);
            });

            // Caso o items esteja vazio

            if (items === undefined || items.length == 0) {

                // Na listagem meter uma mensagem a dizer que est?? vazio
                $("tbody").html(`
                    <td>
                        <td>{{ ucfirst($translations["backoffice"]["empty_contact_request"]) }}</td>
                    </td>
                `);
            }
        }

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
