@extends('layouts.master')
@section('content')
<main class="default-transition pt-5 mb-5 collapsable-main no-load">
	<div class="p-desktop-5">
		<div class="row">
			<div class="col-12">
				<div class="mb-3">
					<h1>{{ ucfirst($translations["backoffice"]["title_list_blog"]) }}</h1>
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
							<a type="button" class="btn btn-primary top-center-button mr-1" data-action="create" href="javascript:void(0)" style="padding: 9px 34px;">{{ ucfirst($translations["backoffice"]["list_blog_create"]) }}</a>
						</div>
					</div>				
					<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
						<ol class="breadcrumb pt-0">
							<li class="breadcrumb-item">
								<a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">
								{{ ucfirst($translations["backoffice"]["blog"]) }}
							</li>
						</ol>
					</nav>
				</div>
				<div class="mb-2">
{{--					<a class="btn pt-0 pl-0 d-inline-block d-md-none" data-toggle="collapse" href="#displayOptions" role="button" aria-expanded="true" aria-controls="displayOptions">Opções de visualização <i class="simple-icon-arrow-down align-middle"></i></a>--}}
					<div class="collapse d-md-block" id="displayOptions">
						<div class="d-block d-md-inline-block">
							@php 
								$countLangs = 0;
							@endphp
							@if(count($languages) > 1)
								@foreach ($languages as $langs)
									@if($langs->active == 1)
										@php 
											$countLangs ++;
										@endphp
									@endif
								@endforeach
							@endif
							@if($countLangs > 1)
								<div class="btn-group float-md-left mr-1 mb-1">
									<button class="btn btn-outline-dark btn-xs dropdown-toggle"
											type="button" data-toggle="dropdown" aria-haspopup="true"
											aria-expanded="false">
											@if(isset($_GET['lang']))                                                  
												<span id="c_language">{{$_GET['lang']}}</span>
											@else 
												<span id="c_language"></span>
											@endif                                            
									</button>
									<div class="dropdown-menu">
										@foreach ($languages as $language)
											<a class="dropdown-item lang-menu" data-lang="{{ $language->code }}">{{ $language->name }}</a>
										@endforeach
									</div>
								</div>
							@endif
							<div class="btn-group float-md-left mr-1 mb-1">
								<button class="btn btn-outline-dark btn-xs dropdown-toggle news-order-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ ucfirst($translations["backoffice"]["order_by"]) }}</button>
								<div class="dropdown-menu">
									<a class="dropdown-item order-menu" data-order="title">{{ ucfirst($translations["backoffice"]["orderBy_name"]) }}</a>
									<a class="dropdown-item order-menu" data-order="date">{{ ucfirst($translations["backoffice"]["orderBy_date"]) }}</a>
									<a class="dropdown-item order-menu" data-order="status">Estado</a>
								</div>
							</div>
							<div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
								<input placeholder="{{ ucfirst($translations["backoffice"]["search"]) }}">
							</div>
							<a class="search-button"><i class="simple-icon-magnifier"></i></a>
						</div>
						<div class="float-md-right">
							<span class="text-muted text-small mr-1">{{ ucfirst($translations["backoffice"]["items_per_page"]) }}</span><button class="btn btn-outline-dark btn-xs dropdown-toggle news-lenght-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">10</button>
							<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
								<a class="dropdown-item length-link" data-length="10">10</a>
								<a class="dropdown-item length-link" data-length="50">50</a>
								<a class="dropdown-item length-link" data-length="100">100</a>
								<a class="dropdown-item length-link" data-length="150">150</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="sperator mb-5"></div>

		<div class="row">
			<div class="col-12 list p-3 pl-md-5 pr-md-5 sortable" data-check-all="checkAll">
			
			</div>
			<div class="col-12">
				<nav class="mt-4 mb-3">
					<ul class="pagination justify-content-center mb-0">
					
					</ul>
				</nav>
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
		Filtros, página, etc deste index
		Os valores que metemos aqui, são os valores iniciais
	*/

	let query 	= parseQueryString();
        
	var page 	= (query.page       !== undefined) ? query.page      : 1;
	var lang        = (query.lang   !== undefined) ? query.lang     : '';
	var limit   = (query.limit      !== undefined) ? query.limit     : 10;
	var order 	= (query.order      !== undefined) ? query.order     : "order_by";
	var search 	= (query.search     !== undefined) ? query.search    : "";

	// Meter o input search com os valores do GET se tiver
	if (query.search !== undefined && query.search.length > 0) {

		$(".search-sm input").val(query.search);
	}

	if (query.limit !== undefined && query.limit.length > 0) {

		$(".news-lenght-menu").text(limit);
	}

	// Iniciar a página de notícias
	load();

	// Ao clicar no botão criar
	$('[data-action="create"]').on("click", function() {

		create();
	});
	
	function load() {

		// Atualizar o url para ter os novos parametros GET
		window.history.replaceState("", "", '/adm/news?' + $.param( { limit: limit, order: order, page: page, search: search, lang:lang } ));
    
	    $.ajax({
	        url: "/api/news?page=" + page + "&search=" + search + "&length=" + limit + "&order=" + order + "&lang=" + lang,
	        type: "GET",
	        dataType : "json",
	        success: function (response) {

	            if (!response.success) {
	
	                $.alert({
						title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
						theme: "supervan",
						content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });
	
	                // Não deixar a função executar mais
	                return;
	            }
				
				// Inserir as notícias obtidas pela api na listagem
	            populate(response.data);

				if(lang === ""){
					$('#c_language').text("{{ ucfirst($translations["backoffice"]["banner_fill_language"]) }}")
					} else{
						if(lang === "pt"){
						$('#c_language').text("Português")
						}else{
						$('#c_language').text("English")
						}
				};

				// Paginação
				if (response.pagination !== undefined) {

					let pagination 	= response.pagination;
					let page  		= pagination.page;
					let pages 		= Math.ceil(pagination.total / pagination.limit); // Calcular o total de páginas
					
					// Adicionar o html dos botões da paginação debaixo da lista
					$(".pagination").html(pagination_template(page, pages));
				}

				$( ".sortable" ).sortable({                        
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
						var ids = '';
						$('.ui-sortable-handle').each(function () {                                
							id = $(this).attr("data-id");                        
							if(ids == '') {
								ids = id;
							} else {
								ids = ids + ',' + id;
							}
						})
						
						$.ajax({
							url: "/api/news/sortable",
							type: "POST",
							data: {ids: ids},
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
							}
						})
					}
				})
					
				// Ativar os listners
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

	function populate(items) {

		// Limpar a lista de items que temos
		$(".list").html("");

		$.each(items, function(key, item) {

			let status = "";

			// Obter o status da noticia
			switch (item.status) {

				case "0":
					status = '<span class="dot red mr-2"></span> {{ ucfirst($translations["backoffice"]["products_status_draft"]) }}';
                    break;
                
                case "1":
					status = '<span class="dot orange mr-2"></span> {{ ucfirst($translations["backoffice"]["products_status_private"]) }}';
                    break;
                
                case "2":
					status = '<span class="dot green mr-2"></span> {{ ucfirst($translations["backoffice"]["products_status_published"]) }}';
                    break;
			}

			let template = `
			    <div class="card d-flex flex-row mb-3 all-scroll" data-id="` + item.id + `">
                    <a class="d-flex a-index-img" href="/adm/news/` + item.id + `">
                        <div class="background-image" style="background-image: url(`+ item.photo_path +`)"></div>
                    </a>
                    <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                        <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center">
                            <a href="/adm/news/` + item.id + `" class="w-60 w-sm-100 truncate">
                                <p class="list-item-heading mb-0 truncate">` +  item.title + `</p>
                            </a>
							<div class="w-20 w-sm-100">
                                <button id="` + item.id +`" data-idTicket ="` + item.id +`"  class="badge badge-pill btn dropdown-toggle bg-primary" data-toggle="dropdown" aria-expanded="false">` + status + `</button>
                                    <div class="dropdown-menu dropdown-menu-status-index" data-ticketNumber="` + item.id + `" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(97px, 37px, 0px);">
                                        <p class="dropdown-item" onclick="changeStatus(0, ` + item.id +`)"><span class="dot red mr-2"></span> {{ ucfirst($translations["backoffice"]["products_status_draft"]) }}</p>
                                        <p class="dropdown-item" onclick="changeStatus(1, ` + item.id +`)"><span class="dot orange mr-2"></span> {{ ucfirst($translations["backoffice"]["products_status_private"]) }}</p>
                                        <p class="dropdown-item" onclick="changeStatus(2, ` + item.id +`)"><span class="dot green mr-2"></span> {{ ucfirst($translations["backoffice"]["products_status_published"]) }}</p>
                                    </div>
                                </div>
								<p class="mb-0 text-muted text-small w-20 w-sm-100">` + item.date + `</p>
                                <div class="w-40 w-sm-100 ">
							    	<label class="custom-control custom-checkbox align-self-center float-right ml-2 my-1 mr-3">
										<input type="checkbox" name="selected_ids[]" value="` + item.id + `" class="checkbox-allowed custom-control-input">
						            	<span class="custom-control-label"></span>
						        	</label>
									<button class="btn btn-outline-danger mb-1 btn-xs m-1 float-right" name="delte_slide_btn " title="apagar" id="delte_slide_btn" onclick="removeNews(` + item.id + `)"><i class="simple-icon-trash"></i></button>
									<a class="btn btn-outline-secondary mb-1 btn-xs m-1 float-right" name="edit_slide_btn" title="editar" id="edit_slide_btn" href="/adm/news/` + item.id + `"><i class="simple-icon-pencil"></i></a>
									<a class="btn btn-outline-dark mb-1 btn-xs m-1 float-right" title="copiar" onclick="cloneNews(` + item.id + `)" data-id="` + item.id + `"><i class="simple-icon-docs"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>`;

			$(".list").append(template);
		});

		// Caso o items esteja vazio

		if (items === undefined || items.length == 0) {

			// Na listagem meter uma mensagem a dizer que está vazio
			$(".list").html(`
				<h4>{{ ucfirst($translations["backoffice"]["not_found_female"]) }}</h4>
				<p class="text-muted">{{ ucfirst($translations["backoffice"]["try_again_later_empty"]) }}</p>
			`);
		}
	}

	$("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        
        function changeStatus (status, id_new) {            
            $.ajax({
                url: "/api/newsChangeStatus",
                type: "POST",
                data: {id: id_new, status: status},
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
                    load()
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
        }

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
                            url: "/api/news_multiple",
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
                                window.location.replace("/adm/news/");
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

        function removeNews(id) {
            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_product_remove"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/news/" + id,
                            type: "DELETE",
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
                                window.location.replace("/adm/news/");
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
        }

        function cloneNews(id) {
            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: '{{ ucfirst($translations["backoffice"]["confirm_product_clone"]) }}',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/newsClone",
                            type: "POST",
                            data: {id},
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
                                window.location.replace("/adm/news/");
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

		// Dropdown de mudar o numero de items na página
		$(".length-link").off("click");
		$(".length-link").on("click", function() {
        
			limit  = $(this).data("length");
			page   = 1;
			
			$(".news-lenght-menu").text(limit);
			load();
		});
		
		// Dropdown de mudar a ordenação dos items
		$(".order-menu").off("click");
		$(".order-menu").on("click", function() {
			
			order   = $(this).data("order");
			page    = 1;
			
			$(".news-order-menu").text($(this).text());
			load();
		});

		//dropdown de mudar o idioma            
		$(".lang-menu").off("click");
		$(".lang-menu").on("click", function () {

			lang = $(this).data("lang");
			page = 1;

			
			load();
		})
		
		$(".search-button").off("click");
		$(".search-button").on("click", function() {
			
			search = $(".search-sm input").val();
			load();
		});
		
		$('.search-sm input').unbind( "enterKey" );
		$('.search-sm input').bind("enterKey",function(e) {
			
			search = $(".search-sm input").val();
			load();
		});
		
		$('.search-sm input').keyup(function(e) {
			
			if (e.keyCode == 13) {
				
				$(this).trigger("enterKey");
			}
		});
	}

	// Criar uma notícia "rascunho", ou seja é basicamente uma notícia na database vazia que só tem ID
	// Mas se já existir uma, usa essa
	function create() {

		$.ajax({
	        url: "/api/news",
	        type: "POST",
			data : {draft: 1, status: 0},
	        dataType : "json",
	        success: function (response) {

	            if (!response.success) {
	
	                $.alert({
						title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
						theme: "supervan",
						content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });
	
	                // Não deixar a função executar mais
	                return;
	            }
				
				// Rederecionar para a noticia "rascunho"
				window.location.href = "/adm/news/" + response.data.id;
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

	function pagination_template(page, pages) {

		console.log(page);
		console.log(pages);
    
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