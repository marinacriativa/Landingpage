@extends('layouts.master')
@section('content')

<style>
	.ps__rail-x,
	.ps__rail-y {   opacity: 0.6 !important; display: block !important; }
</style>

<main class="default-transition pt-5 mb-5 collapsable-main no-load">
	<div class="p-desktop-5">
		<div class="row">
			<div class="col-12">
				<h1>{{ ucfirst($translations["backoffice"]["control_panel"]) }}</h1>
				<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
					<ol class="breadcrumb pt-0">
						<li class="breadcrumb-item">
							<a href="/adm">{{ ucfirst($translations["backoffice"]["store"]) }}</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">{{ ucfirst($translations["backoffice"]["control_panel"]) }}</li>
					</ol>
				</nav>
				<div class="separator mb-5"></div>
			</div>
			<div class="col-lg-12 col-xl-6">
				<div class="icon-cards-row">
					<div class="glide dashboard-numbers">
                        <ul class="col-12">
                            <div class="col-12">
                                <div class="row">
                                    @if(MODULES_PRODUCTS)
                                    <div class="col-xs-3 col-md-3 mt-2">
                                        <a href="/adm/products" class="card">
                                            <div class="card-body text-center">
                                                <i class="iconsmind-Shopping-Bag"></i>
                                                <p class="card-text mb-0">{{ ucfirst($translations["backoffice"]["products"]) }}</p>
                                                <p class="lead text-center" id="productsCount">-</p>
                                            </div>
                                        </a>
                                    </div>
                                    @endif
                                    @if(MODULES_PORTFOLIO)
                                    <div class="col-xs-3 col-md-3 mt-2">
                                        <a href="/adm/constructions" class="card">
                                            <div class="card-body text-center">
                                                <i class="iconsmind-wheelbarrow"></i>
                                                <p class="card-text mb-0">{{ ucfirst($translations["backoffice"]["constructions"]) }}</p>
                                                <p class="lead text-center" id="constructionsCount">-</p>
                                            </div>
                                        </a>
                                    </div>
                                    @endif
                                    @if(MODULES_ORDERS)
                                    <div class="col-xs-3 col-md-3 mt-2">
                                        <a href="/adm/orders" class="card">
                                            <div class="card-body text-center">
                                                <i class="iconsmind-Box-Close"></i>
                                                <p class="card-text mb-0">{{ ucfirst($translations["backoffice"]["orders"]) }}</p>
                                                <p class="lead text-center" id="ordersCount">-</p>
                                            </div>
                                        </a>
                                    </div>
                                    @endif
                                    @if(MODULES_TICKETS)
                                    <div class="col-xs-3 col-md-3 mt-2">
                                        <a href="/adm/tickets" class="card">
                                            <div class="card-body text-center">
                                                <i class="iconsmind-Envelope-2"></i>
                                                <p class="card-text mb-0">{{ ucfirst($translations["backoffice"]["messages"]) }}</p>
                                                <p class="lead text-center" id="ticketsCount">-</p>
                                            </div>
                                        </a>
                                    </div>
                                    @endif
                                    @if(MODULES_CLIENTS)
                                    <div class="col-xs-3 col-md-3 mt-2">
                                        <a href="/adm/clients" class="card">
                                            <div class="card-body text-center">
                                                <i class="iconsmind-Administrator"></i>
                                                <p class="card-text mb-0">{{ ucfirst($translations["backoffice"]["clients"]) }}</p>
                                                <p class="lead text-center" id="clientsCount">-</p>
                                            </div>
                                        </a>
                                    </div>
                                    @endif
                                    @if(MODULES_OBITUARIES)
                                    <div class="col-xs-3 col-md-3 mt-2">
                                        <a href="/adm/obituaries" class="card">
                                            <div class="card-body text-center">
                                                <i class="iconsmind-conference"></i>
                                                <p class="card-text mb-0">{{ ucfirst($translations["backoffice"]["obituaries"]) }}</p>
                                                <p class="lead text-center" id="obituariesCount">-</p>
                                            </div>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </ul>
					</div>
				</div>
                @if(MODULES_ORDERS)
				<div class="row">
					<div class="col-md-12 mb-4">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">{{ ucfirst($translations["backoffice"]["orders"]) }}</h5>
								<div class="dashboard-line-chart chart">
									<canvas id="salesChart"></canvas>
								</div>
							</div>
						</div>
					</div>
				</div>
                @endif
			</div>
            @if(MODULES_ORDERS)
			<div class="col-xl-6 col-lg-12 mb-4">
				<div class="card">
					<div class="position-absolute card-top-buttons">
						<a class="btn btn-outline-primary btn-xs" href="/adm/orders">{{ ucfirst($translations["backoffice"]["see_all_female"]) }}</a> 
					</div>
					<div class="card-body">
						<h5 class="card-title">{{ ucfirst($translations["backoffice"]["latest_female"]) }} {{ $translations["backoffice"]["orders"] }}</h5>
						<div id="ordersList" class="scroll dashboard-list-with-thumbs"></div>
					</div>
				</div>
			</div>
            @endif
		</div>
		<div class="row">
            @if(MODULES_PRODUCTS)
			<div class="col-md-6 col-lg-4 mb-4">
				<div class="card">
					<div class="position-absolute card-top-buttons">
						<a class="btn btn-outline-primary btn-xs" href="/adm/products">{{ ucfirst($translations["backoffice"]["see_all_male"]) }}</a> 
					</div>
					<div class="card-body">
						<h5 class="card-title">{{ ucfirst($translations["backoffice"]["latest_male"]) }} {{ $translations["backoffice"]["products"] }}</h5>
						<div id="productsList" class="scroll dashboard-list-with-user">
						</div>
					</div>
				</div>
			</div>            
            @endif
            @if(MODULES_TICKETS)
			<div class="col-md-6 col-lg-4 mb-4">
				<div class="card">
					<div class="position-absolute card-top-buttons">
						<a class="btn btn-outline-primary btn-xs" href="/adm/tickets">{{ ucfirst($translations["backoffice"]["see_all_male"]) }}</a> 
					</div>
					<div class="card-body">
						<h5 class="card-title">{{ ucfirst($translations["backoffice"]["latest_male"]) }} {{ $translations["backoffice"]["tickets"] }}</h5>
						<div id="ticketsList" class="scroll dashboard-list-with-user">
						</div>
					</div>
				</div>
			</div>
            @endif
            @if(MODULES_CLIENTS)
			<div class="col-md-12 col-sm-12 col-lg-4 mb-4">
				<div class="card">
					<div class="position-absolute card-top-buttons">
						<a class="btn btn-outline-primary btn-xs" href="/adm/clients">{{ ucfirst($translations["backoffice"]["see_all_male"]) }}</a> 
					</div>
					<div class="card-body">
						<h5 class="card-title">{{ ucfirst($translations["backoffice"]["latest_male"]) }} {{ $translations["backoffice"]["clients"] }}</h5>
						<div id="clientsList" class="scroll dashboard-list-with-user">
						</div>
					</div>
				</div>
			</div>
            @endif
		</div>
		<div class="row">
            @if(MODULES_PORTFOLIO)
            <div class="col-lg-4 col-sm-12 mb-4">
				<div class="card">
					<div class="position-absolute card-top-buttons">
						<a class="btn btn-outline-primary btn-xs" href="/adm/constructions">{{ ucfirst($translations["backoffice"]["see_all_male"]) }}</a> 
					</div>
					<div class="card-body">
						<h5 class="card-title">{{ ucfirst($translations["backoffice"]["latest_female"]) }} {{ $translations["backoffice"]["constructions"] }}</h5>
						<div id="constructionsList" class="scroll dashboard-list-with-user">
						</div>
					</div>
				</div>
			</div>
            @endif
            @if(MODULES_PRODUCTS)
			<div class="col-lg-4 col-sm-12 mb-4">
				<div class="card dashboard-progress">
					<div class="position-absolute card-top-buttons">
						<button class="btn btn-header-light icon-button">
						<i class="simple-icon-refresh"></i>
						</button>
					</div>
					<div class="card-body">
						<h5 class="card-title">{{ ucfirst($translations["backoffice"]["highlighted_products"]) }}</h5>
						<div id="featuredProductsList" class="scroll dashboard-list-with-user">
						</div>
					</div>
				</div>
			</div>
            @endif
            @if(MODULES_MESSAGES)
			<div class="col-lg-8 mb-4">
				<div class="card">
					<div class="position-absolute card-top-buttons">
						<a class="btn btn-outline-primary btn-xs" href="/adm/contacts">{{ ucfirst($translations["backoffice"]["see_all_male"]) }}</a> 
					</div>
					<div class="card-body">
						<h5 class="card-title">{{ ucfirst($translations["backoffice"]["latest_male"]) }} {{ $translations["backoffice"]["contact_requests"] }}</h5>
						<div id="contactsList" class="scroll dashboard-list-with-user">
						</div>
					</div>
				</div>
			</div>
            @endif
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 mb-4">
				<div class="card dashboard-filled-line-chart">
					<div class="card-body ">
						<div class="float-left float-none-xs">
							<div class="d-inline-block">
								<h5 class="d-inline">{{ ucfirst($translations["backoffice"]["views"]) }}</h5>
								<span class="text-muted text-small d-block">{{ ucfirst($translations["backoffice"]["unique_visitors"]) }}</span>
							</div>
						</div>
					</div>
					<div class="chart card-body pt-0">
						<canvas id="visitChart"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection
@section('scripts')
<script src="/static/backoffice/javascript/vendor/progressbar.min.js"></script>
<script src="/static/backoffice/javascript/vendor/Chart.bundle.min.js"></script>
<script src="/static/backoffice/javascript/vendor/chartjs-plugin-datalabels.js"></script>
<script src="/static/backoffice/javascript/chart.js"></script>
<script>

init();

    function init() {

        // Carregar as ultimas encomendas
        orders();

        //Carregar os tickets
        tickets();

        //Carregar os obituários
        obituaries();

        //Carregar os Produtos
        products();

        //Carregar as obras
        constructions();

        //Carregar os clientes
        clients();

        //Carregar os contactos
        contacts();

        // Carregar produtos destacados
        featured();
    }   

    function orders() {

        $.ajax({
            url: "/api/orders?page=1&length=10&order=id",
            type: "GET",
            dataType: "json",
            success: function(response) {

                if (!response.success) {

                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });

                    console.error(response);

                    // Não deixar a função executar mais
                    return;
                }

                // Inserir as encomendas obtidas pela api na listagem
                populateOrders(response.data.orders_data);

                // Total de encomendas
                $("#ordersCount").text(response.pagination.total);
            },
            error: function(jqXHR, textStatus, errorThrown) {

                $.alert({
                    title: 'Erro!',
                    theme: "supervan",
                    content: 'Ocorreu algum erro ao processar o pedido, mais informações na consola do navegador!',
                });
            }
        });
    }

    function populateOrders(orders) {

        $("#ordersList").html("");

        $.each(orders, function(key, item) {

            $("#ordersList").append(`
                <div class="d-flex flex-row mb-3">
                    <a class="d-block position-relative" href="#">
                    </a>
                    <div class="pl-3 pt-2 pr-2 pb-2">
                        <a href="/adm/orders/show/` + item.id + `">
                            <p class="list-item-heading">{{ ucfirst($translations["backoffice"]["order"]) }}: ` + item.order_number + `</p>
                            <div class="pr-4 d-none d-sm-block">
                            <p class=" mb-1 text-small">Nome: ` + item.customer_name + `</p>
                            </div>
                            <div class="text-primary text-small font-weight-medium d-none d-sm-block">` + item.created_at + `</div>
                        </a>
                    </div>
                    <div class="float-right ml-auto mt-auto mb-auto">
                        <p class="badge badge-pill badge-info mb-1 text-small mr-5">Total: ` + item.pay_amount + `€</p>
                    </div>
                </div><hr>
            `);
        });

        //Caso a lista esteja vazia
        if (orders === undefined || orders.length == 0) {

            $("#ordersList").html(`
                <h4>{{ ucfirst($translations["backoffice"]["not_found_female"]) }} {{ $translations["backoffice"]["orders"] }}</h4>
                <p class="text-muted">{{ ucfirst($translations["backoffice"]["try_again_later_empty"]) }}</p>
            `);
        }
    }

    function tickets() {

        $.ajax({
            url: "/api/tickets?page=1&length=10&order=id",
            type: "GET",
            dataType: "json",
            success: function(response) {

                if (!response.success) {

                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });

                    console.error(response);

                    // Não deixar a função executar mais
                    return;
                }

                // Inserir as mensagens obtidas pela api na listagem
                populateTickets(response.data);

                // Total de Produtos
                if (response.pagination !== undefined) {

                    $("#ticketsCount").text(response.pagination.total);

                } else {

                    $("#ticketsCount").text("0");

                } 
            },
            error: function(jqXHR, textStatus, errorThrown) {

                console.error(textStatus, errorThrown);

                $.alert({
                    title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                    theme: "supervan",
                    content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                });
            }
        });
    }

    function populateTickets(tickets) {

        $("#ticketsList").html("");

        $.each(tickets, function(key, item) {
        
            let status = "";
            let icon = "";

            switch (item.status) {
                case "0":
                    icon = '<i class="mr-1 iconsmind-envelope" style="font-size: 30px"></i>';
                    status = ' <span class="badge badge-pill tickets_pending">{{ ucfirst($translations["backoffice"]["ticket_pending"]) }}</span>';
                    break;

                case "1":
                    icon = '<i class="mr-1 simple-icon-check" style="font-size: 30px"></i>';
                    status = ' <span class="badge badge-pill tickets_close">{{ ucfirst($translations["backoffice"]["ticket_closed"]) }}</span>';
                    break;

                case "2":
                    icon = '<i class="mr-1 iconsmind-speach-bubble" style="font-size: 30px"></i>';
                    status = '<span class="badge badge-pill tickets_open">{{ ucfirst($translations["backoffice"]["ticket_open"]) }}</span>';
                    break;
            }

            $("#ticketsList").append(`
            <div class="d-flex flex-row mb-3 pb-3 border-bottom">
                <a href="/adm/tickets/` + item.id +`">` + icon + `</a>
                <div class="pl-3">
                    <a href="/adm/tickets/` + item.id +`">
                        <p class="font-weight-medium mb-0 ">` + item.subject + `</p>
                        <p class="text-muted mb-0 text-small">` + item.ticket_number + `</p>
                    </a>
                </div>
            </div>`);

        });

        //Caso a lista esteja vazia
        if (tickets === undefined || tickets.length == 0) {

            $("#ticketsList").html(`
                <h4>{{ ucfirst($translations["backoffice"]["not_found_male"]) }} {{ $translations["backoffice"]["tickets"] }}</h4>
                <p class="text-muted">{{ ucfirst($translations["backoffice"]["try_again_later_empty"]) }}</p>
            `);
        }
    }

    function featured() {

        $.ajax({
            url: "/api/products/featured",
            type: "GET",
            dataType: "json",
            success: function (response) {
                
                if (!response.success) {

                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });

                    console.error(response);

                    // Não deixar a função executar mais
                    return;
                }

                // Inserir os produtos obtidas pela api na listagem
                populateFeatured(response.data);
            },
            error: function (jqXHR, textStatus, errorThrown) {

                console.error(textStatus, errorThrown);

                $.alert({
                    title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                    theme: "supervan",
                    content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                });
            }
        });
    }

    function populateFeatured(products) {

        $("#featuredProductsList").html("");

        $.each(products, function(key, item) {

            if (item.sku == null) {

                item.sku = "";
            }

            $("#featuredProductsList").append(`
            <div class="d-flex flex-row mb-3">
                    <a class="d-block position-relative" href="/adm/products/` + item.id + `">
                        <div class="background-image" style="background-image: url(`+ item.photo +`)"></div>
                        <span class="badge badge-pill badge-theme-2 position-absolute badge-top-right">` + item.price + `€</span>
                    </a>
                    <div class="pl-3 pt-2 pr-2 pb-2">
                        <a href="/adm/products/` + item.id + `">
                            <p class="list-item-heading">` + item.name + `</p>
                            <div class="pr-4 d-none d-sm-block ">
                                <p class="text-muted mb-1 text-small">` + item.sku + `</p>
                            </div>
                        </a>
                    </div>
                </div>
            `);
        });

        //Caso a lista esteja vazia
        if (products === undefined || products.length == 0) {

            $("#featuredProductsList").html(`
                <h4>{{ ucfirst($translations["backoffice"]["not_found_male"]) }} {{ $translations["backoffice"]["highlighted_products"] }}</h4>
                <p class="text-muted">{{ ucfirst($translations["backoffice"]["try_again_later_empty"]) }}</p>
            `);
        }
    }

    function obituaries() {
        
        $.ajax({
            url: "/api/obituaries?page=1&length=10&order=id",
            type: "GET",
            dataType: "json",
            success: function (response) {

                if (!response.success) {

                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });

                    console.error(response);

                    // Não deixar a função executar mais
                    return;
                }
                
                // Total de Produtos
                if (response.pagination !== undefined) {

                    $("#obituariesCount").text(response.pagination.total);

                } else {

                    $("#obituariesCount").text("0");
                }              
            
            },
            error: function (jqXHR, textStatus, errorThrown) {

                console.error(textStatus, errorThrown);

                $.alert({
                    title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                    theme: "supervan",
                    content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                });
            }
        });
    }
    
    function products() {
        
        $.ajax({
            url: "/api/products?page=1&length=10&order=id",
            type: "GET",
            dataType: "json",
            success: function (response) {

                if (!response.success) {

                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });

                    console.error(response);

                    // Não deixar a função executar mais
                    return;
                }

                // Inserir os produtos obtidas pela api na listagem
                populateProducts(response.data);
                
                // Total de Produtos
                if (response.pagination !== undefined) {

                    $("#productsCount").text(response.pagination.total);

                } else {

                    $("#productsCount").text("0");
                }              
            
            },
            error: function (jqXHR, textStatus, errorThrown) {

                console.error(textStatus, errorThrown);

                $.alert({
                    title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                    theme: "supervan",
                    content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                });
            }
        });
    }

    function populateProducts(products) {
        
        $("#productsList").html("");

        $.each(products, function(key, item) {

            if (item.sku == null) {

                item.sku = "";
            }
                {{--<div class="background-image" style="background-image: url('{{ $product->photo }}')"></div> --}}
                {{--<img onerror="this.onerror=null;this.src='/static/backoffice/images/placeholder.png'" src="` + item.photo + `" alt="` + item.name + `" class="list-thumbnail border-0">--}}


                $("#productsList").append(`
            <div class="d-flex flex-row mb-3">
                    <a class="d-block position-relative" href="/adm/products/` + item.id + `">
                        <div class="background-image" style="background-image: url(`+ item.photo +`)"></div>
                        <span class="badge badge-pill badge-theme-2 position-absolute badge-top-right">` + item.price + `€</span>
                    </a>
                    <div class="pl-3 pt-2 pr-2 pb-2">
                        <a href="/adm/products/` + item.id + `">
                            <p class="list-item-heading">` + item.name + `</p>
                            <div class="pr-4 d-none d-sm-block">
                                <p class="text-muted mb-1 text-small">` + item.sku + `</p>
                            </div>
                        </a>
                    </div>
                </div>
            `);

        });

        //Caso a lista esteja vazia
        if (products === undefined || products.length == 0) {

            $("#productsList").html(`
                <h4>{{ ucfirst($translations["backoffice"]["not_found_male"]) }} {{ $translations["backoffice"]["products"] }}</h4>
                <p class="text-muted">{{ ucfirst($translations["backoffice"]["try_again_later_empty"]) }}</p>
            `);
        }
    }

    function constructions () {
        $.ajax({
            url: "/api/constructions?page=1&length=10&order=id",
            type: "GET",
            dataType: "json",
            success: function (response) {

                if (!response.success) {

                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });

                    console.error(response);

                    // Não deixar a função executar mais
                    return;
                }

                // Inserir os produtos obtidas pela api na listagem
                populateConstructions(response.data);
                
                // Total de Produtos
                if (response.pagination !== undefined) {

                    $("#constructionsCount").text(response.pagination.total);

                } else {

                    $("#constructionsCount").text("0");
                }              
            
            },
            error: function (jqXHR, textStatus, errorThrown) {

                console.error(textStatus, errorThrown);

                $.alert({
                    title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                    theme: "supervan",
                    content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                });
            }
        });    
    }

    function populateConstructions(constructions) {
        
        $("#constructionsList").html("");

        $.each(constructions, function(key, item) {

                {{--<div class="background-image" style="background-image: url('{{ $product->photo }}')"></div> --}}
                {{--<img onerror="this.onerror=null;this.src='/static/backoffice/images/placeholder.png'" src="` + item.photo + `" alt="` + item.name + `" class="list-thumbnail border-0">--}}


                $("#constructionsList").append(`
                <div class="d-flex flex-row mb-3">
                    <a class="d-block position-relative" href="/adm/constructions/` + item.id + `">
                        <div class="background-image" style="background-image: url(`+ item.photo +`)"></div>
                    </a>
                    <div class="pl-3 pt-2 pr-2 pb-2">
                        <a href="/adm/constructions/` + item.id + `">
                            <p class="list-item-heading">` + item.name + `</p>                            
                        </a>
                    </div>
                </div>
            `);

        });

        //Caso a lista esteja vazia
        if (constructions === undefined || constructions.length == 0) {

            $("#constructionsList").html(`
                <h4>{{ ucfirst($translations["backoffice"]["not_found_male"]) }} {{ $translations["backoffice"]["constructions"] }}</h4>
                <p class="text-muted">{{ ucfirst($translations["backoffice"]["try_again_later_empty"]) }}</p>
            `);
        }
    }

    function clients() {

        $.ajax({
            url: "/api/clients?page=1&length=10&order=id",
            type: "GET",
            dataType: "json",
            success: function (response) {

                if (!response.success) {

                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });

                    console.error(response);

                    // Não deixar a função executar mais
                    return;
                }

                // Inserir os clients obtidas pela api na listagem
                populateClients(response.data);

                // Total de Clientes
                if (response.pagination !== undefined) {

                    $("#clientsCount").text(response.pagination.total);

                } else {

                    $("#clientsCount").text("0");
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {

                console.error(textStatus, errorThrown);

                $.alert({
                    title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                    theme: "supervan",
                    content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                });
            }
        });
    }

    function populateClients(clients) {

        $("#clientsList").html("");

        $.each(clients, function(key, item) {

            let isactive = "";
            let iconUser = "";

            switch(item.isactive) {

                case "0":
                    iconUser = '<i class="simple-icon-user-unfollow iconsListIndex mr-2"></i>'
                    isactive = '<span class="dot red mr-2"></span>{{ ucfirst($translations["backoffice"]["inactive"]) }}';
                    break;

                case "1":
                    iconUser = '<i class="simple-icon-user-following iconsListIndex mr-2"></i>'
                    isactive =  '<span class="dot green mr-2"></span>{{ ucfirst($translations["backoffice"]["active"]) }}';
                    break;
            }

            $("#clientsList").append(`
            <div class="d-flex flex-row mb-3 pb-3 border-bottom">
                <a href="/adm/clients/` + item.id + `">` + iconUser + `</a>
                <div class="pl-3">
                    <a href="/adm/clients/` + item.id + `">
                        <p class="font-weight-medium mb-0 ">` + item.name + `</p> 
                        <p class="text-muted mb-0 text-small">Email:` + item.email + ` Tel.` + item.phone + `</p>
                    </a>
                </div>
            </div>
            `);
        });

        //Caso a lista esteja vazia
        if (clients === undefined || clients.length == 0) {

            $("#clientsList").html(`
                <h4>{{ ucfirst($translations["backoffice"]["not_found_male"]) }} {{ $translations["backoffice"]["clients"] }}</h4>
                <p class="text-muted">{{ ucfirst($translations["backoffice"]["try_again_later_empty"]) }}</p>
            `);
        }
    }

    function contacts() {

        $.ajax({
            url: "/api/contacts?page=1",
            type: "GET",
            dataType: "json",
            success: function(response) {

                if (!response.success) {

                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });

                    console.error(response);

                    // Não deixar a função executar mais
                    return;
                }

                populateContacts(response.data);

                // Total de Contactos
                $("#contactsCount").text(response.pagination.total);
            },
            error: function(jqXHR, textStatus, errorThrown) {

                console.error(textStatus, errorThrown);

                $.alert({
                    title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                    theme: "supervan",
                    content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                });
            }
        });
    }


    function populateContacts(contacts) {

        $("#contactsList").html("");

        $.each(contacts, function(key, item) {

            let seen = "";

            if (item.seen == "1") {
                
                seen = `<span class="badge badge-light text-uppercase text-bold w-100">{{ ucfirst($translations["backoffice"]["seen"]) }}</span>`;

            } else {

                seen = `<span class="badge badge-success text-uppercase text-bold w-100">{{ ucfirst($translations["backoffice"]["new"]) }}</span>`;
            }

            $("#contactsList").append(`
            <div class="d-flex flex-row mb-3 border-bottom">
                <a href="/adm/contacts/` + item.id + `">
                </a>
                <div class="pl-3">
                    <a href="/adm/contacts/` + item.id + `">
                        <span class="font-weight-medium mb-0 ">` + item.name + ` ` + item.surname + `</span><br>
                        <span class="text-muted mb-0 text-small">` + item.contact + `</span><br>
                        <span class="text-muted mb-0 text-small">` + item.email + `</span><br>
                        <span class="text-muted mb-0 text-small">` + item.subject + `</span><br><br>
                    </a>
                </div>
                <div class="ml-auto mt-auto mb-auto w-20">
                    <p class="text-muted text-small mr-5">` + seen + `</p>
                </div>
            </div>`);
        });

        //Caso a lista esteja vazia
        if (contacts === undefined || contacts.length == 0) {

            $("#contactsList").html(`
                <h4>{{ ucfirst($translations["backoffice"]["not_found_male"]) }} {{ $translations["backoffice"]["contact_requests"] }}</h4>
                <p class="text-muted">{{ ucfirst($translations["backoffice"]["try_again_later_empty"]) }}</p>
            `);
        }
    }

    salesChart();

    function salesChart() {

        if (document.getElementById("salesChart")) {

            Chart.defaults.LineWithShadow       = Chart.defaults.line;
            Chart.controllers.LineWithShadow    = Chart.controllers.line.extend({
                draw: function(ease) {
                    Chart.controllers.line.prototype.draw.call(this, ease);
                    var ctx = this.chart.ctx;
                    ctx.save();
                    ctx.shadowColor = "rgba(0,0,0,0.15)";
                    ctx.shadowBlur = 10;
                    ctx.shadowOffsetX = 0;
                    ctx.shadowOffsetY = 10;
                    ctx.responsive = true;
                    ctx.stroke();
                    Chart.controllers.line.prototype.draw.apply(this, arguments);
                    ctx.restore();
                }
            });

            $.ajax({
                url: "/api/graph/sales",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    
                    if (!response.success) {

                        $.alert({
                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                            theme: "supervan",
                            content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                        });

                        console.error(response);

                        // Não deixar a função executar mais
                        return;
                    }

                    var dateNow     = new Date();  
                    var lastDate    = new Date(dateNow.getFullYear(), dateNow.getMonth() + 1, 0).getDate();

                    // Criar uma array com dias  ( 1 - 31 )
                    var sales_labels = [...Array(lastDate).keys()].map(a=>a+1);
                    var sales_data   = {};
                   
                    var max_sales_data = 0;
                    var min_sales_data = 0;

                    $.each(response.data, function(key, data) {

                        if (data.count > max_sales_data) {

                            max_sales_data = data.count;
                        }

                        sales_data[data.day] = parseInt(data.count);
                    });

                    $.each(sales_labels, function(key, data) {

                        if (sales_data[data] == undefined) {

                            sales_data[data] = 0;
                            sales_labels[key] = "";
                        }
                    });

                    var visitChart = document.getElementById("salesChart").getContext("2d");
                    var myChart = new Chart(visitChart, {
                        type: "LineWithShadow",
                        options: {
                            plugins: {
                                datalabels: {
                                    display: false
                                }
                            },
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                yAxes: [{
                                    gridLines: {
                                        display: true,
                                        lineWidth: 1,
                                        color: "rgba(0,0,0,0.1)",
                                        drawBorder: false
                                    },
                                    ticks: {
                                        beginAtZero: true,
                                        stepSize: 5,
                                        min: 0,
                                        max: parseInt(max_sales_data) + 5, 
                                        padding: 0
                                    }
                                }],
                                xAxes: [{
                                    gridLines: {
                                        display: false
                                    }
                                }]
                            },
                            legend: {
                                display: false
                            },
                            tooltips: chartTooltip
                        },
                        data: {
                            labels: sales_labels,
                            datasets: [{
                                label: "Vendas",
                                data: Object.values(sales_data),
                                borderColor: "#00365a",
                                pointBackgroundColor: "#fff",
                                pointBorderColor: "#00365a",
                                pointHoverBackgroundColor: "#fff",
                                pointHoverBorderColor: "#fff",
                                pointRadius: 4,
                                pointBorderWidth: 2,
                                pointHoverRadius: 5,
                                fill: true,
                                borderWidth: 2,
                                backgroundColor: "#e5ebee"
                            }]
                        }
                    });

                },
                error: function(jqXHR, textStatus, errorThrown) {

                    console.error(textStatus, errorThrown);

                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });
                }
            });
        }
    }

    visitsChart();

    function visitsChart() {

        if (document.getElementById("visitChart")) {

            Chart.defaults.LineWithShadow = Chart.defaults.line;
            Chart.controllers.LineWithShadow = Chart.controllers.line.extend({
                draw: function(ease) {
                    Chart.controllers.line.prototype.draw.call(this, ease);
                    var ctx = this.chart.ctx;
                    ctx.save();
                    ctx.shadowColor = "rgba(0,0,0,0.15)";
                    ctx.shadowBlur = 10;
                    ctx.shadowOffsetX = 0;
                    ctx.shadowOffsetY = 10;
                    ctx.responsive = true;
                    ctx.stroke();
                    Chart.controllers.line.prototype.draw.apply(this, arguments);
                    ctx.restore();
                }
            });

            $.ajax({
                url: "/api/graph/views",
                type: "GET",
                dataType: "json",
                success: function(response) {

                    removeTemplateLoader();
                    
                    if (!response.success) {

                        $.alert({
                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                            theme: "supervan",
                            content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                        });

                        console.error(response);

                        // Não deixar a função executar mais
                        return;
                    }

                    var dateNow     = new Date();  
                    var lastDate    = new Date(dateNow.getFullYear(), dateNow.getMonth() + 1, 0).getDate();

                    // Criar uma array com dias  ( 1 - 31 )
                    var views_labels = [...Array(lastDate).keys()].map(a=>a+1);
                    var views_data   = {};

                    

                    var max_views_data = 0;
                    var min_views_data = 0;

                    $.each(response.data, function(key, data) {
                        if (data.count > max_views_data) {

                            max_views_data += parseInt(data.count);
                        }

                        views_data[data.day] = parseInt(data.count);
                    });

                    $.each(views_labels, function(key, data) {

                        if (views_data[data] == undefined) {

                            views_data[data] = 0;
                            views_labels[key] = "";
                        }
                    });

                    var visitChart = document.getElementById("visitChart").getContext("2d");
                    var myChart = new Chart(visitChart, {
                        type: "LineWithShadow",
                        options: {
                            plugins: {
                                datalabels: {
                                    display: false
                                }
                            },
                            responsive: true,                           
                            maintainAspectRatio: false,
                            scales: {
                                yAxes: [{
                                    gridLines: {
                                        display: true,
                                        lineWidth: 1,
                                        color: "rgba(0,0,0,0.1)",
                                        drawBorder: false
                                    },
                                    ticks: {
                                        beginAtZero: true,
                                        stepSize: 5,
                                        min: 0,
                                        max: parseInt(max_views_data) + 5, 
                                        padding: 0
                                    }
                                }],
                                xAxes: [{
                                    gridLines: {
                                        display: false
                                    }
                                }]
                            },
                            legend: {
                                display: false
                            },
                            tooltips: chartTooltip
                        },
                        data: {
                            labels: views_labels,
                            datasets: [{
                                label: "Visitas",
                                data: Object.values(views_data),
                                borderColor: "#00365a",
                                pointBackgroundColor: "#fff",
                                pointBorderColor: "#00365a",
                                pointHoverBackgroundColor: "#fff",
                                pointHoverBorderColor: "#fff",
                                pointRadius: 4,
                                pointBorderWidth: 2,
                                pointHoverRadius: 5,
                                fill: true,
                                borderWidth: 2,
                                backgroundColor: "#e5ebee"
                            }]
                        }
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {

                    console.log(textStatus, errorThrown);

                    $.alert({
                        title: '{{ ucfirst($translations["backoffice"]["error"]) }}!',
                        theme: "supervan",
                        content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                    });
                }
            });
        }
    }

</script>
@endsection