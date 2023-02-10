@extends('layouts.master')
@section('content')
<main class="default-transition pt-5 mb-5 collapsable-main no-load">
	<div class="p-desktop-5" id="printarea">
		<div class="row">
			<div class="col-12 mb-8">
				<div>
					<h1>Encomenda <span class="text-muted h5" id="span_order_number" ></span></h1>
                    <div class="row pl-2">
                        <div class="btn-group mb-5">
                            <div class="btn-add-historic">
                                <button class="btn btn-light default mr-2 print-button">Imprimir</button>
                                <button class="flex-grow-1 btn btn-light default dropdown-toggle mr-2 btn-status-historic" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Selecione Estado
                                </button>
                                <div class="dropdown-menu menu-historic" x-placement="bottom-start">
                                </div>
                                <button class="btn btn-outline-info btn-add-status-historic">Atualizar</button>
                                <button type="button" data-action="delete" class="btn btn-outline-danger ml-2">{{ ucfirst($translations["backoffice"]["edit_news_btn_remove"]) }}</button>
                                <button type="button" href="#" onclick='javascript:window.location.assign("/adm/orders");' class="btn btn-outline-secondary float-right ml-2">{{ ucfirst($translations["backoffice"]["edit_custom_btn_back"]) }}</button>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="row row-flex mb-5">
					<div class="col-xs-12 col-md-6">
						<div class="card mb-4 h-100">
							<div class="card-body card_orders_details">
								<h5 class="card-title"><i class="simple-icon-drawer mr-2"></i>Dados da encomenda</h5>
								<hr>
								<table class="table table-borderless">
									<tbody>
										<tr>
											<th class="p-1" scope="row">Estado da encomenda: </th>
											<td id="span_status" class="text-muted p-1"></td>
										</tr>
										<tr>
											<th class="p-1" scope="row">Email: </th>
											<td id="span_customer_email" class="text-muted p-1"></td>
										</tr>
										<tr>
											<th class="p-1" scope="row">Contacto: </th>
											<td id="span_customer_phone" class="text-muted p-1"></td>
										</tr>
										<tr>
											<th class="p-1" scope="row">Tipo de pagamento: </th>
											<td id="span_method" class="text-muted p-1"></td>
										</tr>
										<tr>
											<th class="p-1" scope="row">Pago:</th>
											<td id="span_payment_status" class="text-muted p-1"></td>
										</tr>
										<tr class="d-none">
											<th class="p-1" scope="row">Código do cupão:</th>
											<td id="span_coupon_code" class="text-muted p-1"></td>
										</tr>
										<tr class="d-none">
											<th class="p-1" scope="row">Valor do cupão:</th>
											<td id="span_coupon_discount" class="text-muted p-1"></td>
										</tr>
										<tr>
											<th class="p-1" scope="row">Data da compra:</th>
											<td id="span_created_at" class="text-muted p-1"></td>
										</tr>
                                        <tr>
											<th class="p-1" scope="row">Nome: </th>
											<td id="span_customer_name" class="text-muted p-1"></td>
										</tr>
										<tr>
											<th class="p-1" scope="row">Número de contribuinte: </th>
											<td id="span_customer_fiscal" class="text-muted p-1"></td>
										</tr>
										<tr>
											<th class="p-1" scope="row">País: </th>
											<td id="span_customer_country" class="text-muted p-1"></td>
										</tr>
										<tr>
											<th class="p-1" scope="row">Morada: </th>
											<td id="span_customer_address" class="text-muted p-1"></td>
										</tr>
										<tr>
											<th class="p-1" scope="row">Cidade:</th>
											<td id="span_customer_city" class="text-muted p-1"></td>
										</tr>
										<tr>
											<th class="p-1" scope="row">Código Postal:</th>
											<td id="span_customer_zip" class="text-muted p-1"></td>
										</tr>
									</tbody>
								</table>
								<hr>
								<div><span>Observações: </span>
									<span id="span_order_note" class="text-muted"></span>
								</div>
								<a id="btn-data-client" class="btn btn-outline-success float-right"><i
									class="simple-icon-user mr-2"></i>Dados do Cliente
								</a>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="card mb-4 h-100">
							<div class="card-body card_orders_details">
								<h5 class="card-title"><i class="simple-icon-doc mr-2"></i>Dados de Faturação</h5>
								<hr>
								<table class="table table-borderless">
									<tbody>
										<tr>
											<th class="p-1" scope="row">Nome: </th>
											<td id="span_billing_name" class="text-muted p-1"></td>
										</tr>
										<tr>
											<th class="p-1" scope="row">Número de contribuinte: </th>
											<td id="span_billing_nif" class="text-muted p-1"></td>
										</tr>
										<tr>
											<th class="p-1" scope="row">País: </th>
											<td id="span_billing_country" class="text-muted p-1"></td>
										</tr>
										<tr>
											<th class="p-1" scope="row">Morada: </th>
											<td id="span_billing_address" class="text-muted p-1"></td>
										</tr>
										<tr>
											<th class="p-1" scope="row">Cidade:</th>
											<td id="span_billing_city" class="text-muted p-1"></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="card mb-4">
							<div class="card-body card_orders_details">
								<div>
									<h5 class="card-title"><i class="simple-icon-basket-loaded mr-2"></i>Lista de
										produtos
									</h5>
									<div class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th class="font-weight-bold" scope="col">Produto</th>
													<th class="font-weight-bold" scope="col">Personalização</th>
													<th class="font-weight-bold" scope="col">Qt</th>
													<th class="font-weight-bold" scope="col">Preço Uni.</th>
													<th class="font-weight-bold" scope="col">Preço Total</th>
												</tr>
											</thead>
											<tbody id="tableBodyProducts">
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="card mb-4">
							<div class="card-body card_orders_details">
								<div>
									<h5 class="card-title mb-2"><i class="simple-icon-book-open mr-2"></i> Histórico</h5>
									<div class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th class=" font-weight-bold scope=" col
														">Estado</th>
													<th class="font-weight-bold scope=" col
														">Data</th>
												</tr>
											</thead>
											<tbody id="historicTableBody">
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection

@section('scripts')
    <script>
        init();

        async function init() {

            // Vamos buscar o url pretendido para ver se a página vai editar ou adicionar novo produto
            var page = new RegExp('^/adm/orders/.*');

            // Vamos buscar o link do site
            var path = window.location.pathname.replace(/\/+$/, '');

            // Predefinir a variavel do wildcard
            var wildcard = null;

            // Definir a wildcard como o último valor do URL /valor1/valor2/valor3 ( nest caso vamos buscar o valor 3)
            wildcard = path.split("/");
            wildcard = wildcard[wildcard.length - 1];

            $(".btn-add-status-historic").attr("data-idorder", wildcard);

            listeners();

            const {data: orderData} = await loadOrder(wildcard);

            populateOrder(orderData.order_data, orderData.order_status_data);
            populateProductsByOrder(orderData.order_products_data, orderData.order_data);
            populateOrderHistory(orderData.historic_date, orderData.order_status_data);
            populateOrderStatus(orderData.order_status_data, orderData.order_data.status);
        }

        function loadOrder(id) {

            return $.ajax({

                url: "/api/orders/" + id,
                type: "GET",
                dataType: "json",
                success: function (response) {
                    if (!response.success) {
                        // Output do erro
                        console.error(response);
                        $.alert({
                            title: 'Erro!',
                            theme: "supervan",
                            content: 'Ocorreu algum erro ao processar o pedido, mais informações na consola do navegador!',
                        });
                        // Não deixar a função executar mais
                        return;
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {

                    console.log(textStatus, errorThrown);
                    $.alert({
                        title: 'Erro!',
                        theme: "supervan",
                        content: 'Ocorreu algum erro ao processar o pedido, mais informações na consola do navegador!',
                    });
                }
            });
        }

        function populateOrder(item, items_status) {

            // Procurar todos os elementos por name="" e meter os dados da api
            $.each(item, function (key, value) {

                if (value === null || value === "") {

                    $(`#span_${key}`).html("Sem informação").css({
                        color: "#b3b3b3"
                    });

                } else {

                    $(`#span_${key}`).prepend(value);

                    if (key === "status") {

                        $.each(items_status, function (key, item_status) {

                            if (value === item_status.id) {

                                $(`#span_status`).html(item_status.name);
                            }
                        })
                    }
                }

                if (item.user_id !== null && item.user_id > 0) {

                    $("#btn-data-client").attr("href", `/adm/clients/` + item.user_id);

                } else {

                    $("#btn-data-client").hide();
                }
            })
        }

        function populateProductsByOrder(items, order) {

            $("#tableBodyProducts").html("");

            let count   = 0
            let app_tax = parseInt("{{ $website_config->tax }}");

            $.each(items, function (key, product) {

                count++

                let total = 0
                if (product.type === "1") {

                    total = product.personalization.current_price * product.qty_product

                } else {

                    total = product.price * product.qty_product
                }

                let personalization = ""
                let templateRow     = `
                <tr>
                    <td class="text-muted vertical-align-center"><a target="_blank" href="/adm/products/` + product.id + `" class="btn-link">` + product.name + `</a></td>
                    <td class="text-muted vertical-align-center"><div class="row" id="personalization` + count + `"></div></td>
                    <td class="text-muted vertical-align-center">` + product.qty_product + `x</td>
                    <td class="text-muted vertical-align-center">` + product.price + `€</td>
                    <td class="text-muted vertical-align-center">` + Number(total).toFixed(2) + `€</td>
                </tr>`;

                $("#tableBodyProducts").append(templateRow);

                if (product.type === "2") {

                    $.each(product.personalization, function (key, item_personalization) {

                        personalization = 
                        `<div class="mr-4 text-center">
                            <p>`        + item_personalization.group.name + `</p>
                            <img src='` + item_personalization.item.photo + `' class="responsive border-0 img-personalization-order">
                        <div>`;

                        $(`#personalization${count}`).append(personalization);
                    });

                } else if (product.type === "1") {

                    personalization = `<p>` + product.personalization.name + `</p>`;
                    $(`#personalization${count}`).append(personalization);
                }
            });

            // Adicionar o custo de envio
            $("#tableBodyProducts").append(`
                <tr>
                    <td class="text-muted vertical-align-center">Método de envio - `+ order.shipping + `</td>
                    <td class="text-muted vertical-align-center">-</td>
                    <td class="text-muted vertical-align-center">-</td>
                    <td class="text-muted vertical-align-center">-</td>
                    <td class="text-muted vertical-align-center">` + order.shipping_cost + `€</td>
                </tr>`);

            // Adicionar as taxas
            if (order.tax !== 0 && order.tax !== null) {

                $("#tableBodyProducts").append(`
                    <tr>
                        <td class="text-muted vertical-align-center">Taxas da encomenda - ` + app_tax + `%</td>
                        <td class="text-muted vertical-align-center">-</td>
                        <td class="text-muted vertical-align-center">-</td>
                        <td class="text-muted vertical-align-center">-</td>
                        <td class="text-muted vertical-align-center">` + order.tax + `€</td>
                    </tr>`);
            }

            // Adicionar coupon
            if (order.coupon != null) {
                let typeDiscount    = order.coupon.type == 0 ? '%' : '€';
                let applyDiscount   = '';
                console.log(order.coupon)
                switch (order.coupon.apply_discount) {
                    case "0":
                        applyDiscount = '(Produto + Frete)';
                        break;
                    
                    case "1":
                        applyDiscount = '(Somente no produto)';                        
                        break;
                
                    default:
                        applyDiscount = '(Somente no frete)';                       
                        break;
                }
                $("#tableBodyProducts").append(`
                    <tr>
                        <td class="text-muted vertical-align-center">Desconto - ` + order.coupon_code + ` `+ applyDiscount +`</td>
                        <td class="text-muted vertical-align-center">-</td>
                        <td class="text-muted vertical-align-center">-</td>
                        <td class="text-muted vertical-align-center">-</td>
                        <td class="text-muted vertical-align-center">` + order.coupon_discount + typeDiscount +`</td>
                    </tr>`);
            }

            // Adicionar o total
            $("#tableBodyProducts").append(`
                <tr>
                    <td class="text-muted vertical-align-center">Total</td>
                    <td class="text-muted vertical-align-center">-</td>
                    <td class="text-muted vertical-align-center">-</td>
                    <td class="text-muted vertical-align-center">-</td>
                    <td class="text-bold vertical-align-center">` + order.pay_amount + `€</td>
                </tr>`);
        }

        function populateOrderHistory(items, items_status) {

            $("#historicTableBody").html("");
            let objStatus = {};

            $.each(items, function (key, item, index) {

                $.each(items_status, function (key, item_status) {

                    if (item.status === item_status.id) {

                        objStatus = item_status;
                    }
                });

                let templateRow = `
                <tr>
                    <td>` + objStatus.name + `</td>
                    <td class="text-muted"><div class="badge badge-light truncate mb-0 text-muted text-small">` + item.date + `</div></td>
                </tr>`;

                $("#historicTableBody").append(templateRow)
            });
        }

        function printPage() {

            // Esconder elementos da página que nao precisamos de imprimir
            $("nav").hide();
            $(".sidebar").hide();
            $(".btn-group").hide();
            $(".btn-success").hide();

            window.print();

            // Voltar a mostrar os elementos
            $(".sidebar").show();
            $(".btn-success").show();
            $("nav").show();
            $(".btn-group").show();
        }

        function populateOrderStatus(items, status) {

            $(".menu-historic").html("");

            $.each(items, function (key, item) {

                // Vamos definir o status no botao de dropdown se for o atual
                if (item.id == status) {

                    $(".btn-status-historic").text(item.name);
                }

                let templateRow = `<p class="dropdown-item" data-id = ` + item.id + `>` + item.name + `</p>`;

                $(".menu-historic").append(templateRow)
            });

            
        }

        function listeners() {

            // Ao carregar no botao imprimir
            $("body").on("click", ".print-button", function() {

                printPage();
            }); 

            // Ao clicar no botao de eliminar
            $("[data-action='delete']").on("click", function() {

                // Vamos buscar o ID ao botão de guardar
                let id = $(".btn-add-status-historic").data("idorder");

                remove(id);
            });

            //Ao carregar em qualquer item da dropDown
            $(".menu-historic").on("click", ".dropdown-item", function () {

                //Guarda o texto do item selecionado
                let selectStatus = $(this).text();
                //guarda o id do status selecionado atravez do data-id
                let selectStatusId = $(this).data("id");
                //Apresenta o texto selecionado
                $(".btn-status-historic").html(selectStatus)
                //Atribui o id do estado ao elemento para ser usado mais tarde
                $(".btn-status-historic").attr("data-idStatus", selectStatusId)
            })

            $(".btn-add-status-historic").on("click", function () {

                //vai buscar e guarda o id do estado que foi guardado no data-idStatus
                let status = $(".btn-status-historic").attr("data-idstatus")
                //Vai buscar e guarda o nome do estado escolhido
                let nameStatus = $(".btn-status-historic").text()
                $(`#span_status`).html(nameStatus);
                //Vai buscar o idOrder atravez do data
                let idOrder = $(".btn-add-status-historic").data("idorder")

                let dataOrder = {
                    "status": status
                }
                let data = {
                    "idOrder": idOrder,
                    "status": status,
                }

                editStatusOrder(idOrder, dataOrder)
                saveNewStatusHistoric(data, nameStatus)
            });
        }

        function remove(id) {

            $.confirm({
                title: '{{ ucfirst($translations["backoffice"]["confirm"]) }}',
                theme: "supervan",
                content: 'Tem a certeza que deseja eliminar a encomenda?',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/orders/" + id,
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
                                window.location.replace("/adm/orders/");
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

        function editStatusOrder(idOrder, dataOrder) {

            $.ajax({
                url: "/api/orders/" + idOrder,
                // Usamos POST em vez de PUT por causa que algumas vezes os clientes metem milhares de linhas
                // De texto, etc e em alguns servidores pode dar erro
                type: "POST",
                data: dataOrder,
                dataType: "json",
                success: function (response) {

                    if (!response.success) {

                        // Output do erro
                        console.error(response);

                        $.alert({
                            title: 'Erro!',
                            theme: "supervan",
                            content: 'Ocorreu algum erro ao processar o pedido, mais informações na consola do navegador!',
                        });
                        // Não deixar a função executar mais
                        return;
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {

                    console.log(textStatus, errorThrown);
                    // @TODO:
                    // Mostar mensagem de erro
                }
            });
        }

        function saveNewStatusHistoric(data, nameStatus) {

            $.confirm({
                title: 'Confirmar!',
                theme: "supervan",
                content: 'Tem a certeza que deseja adicionar um novo estado a encomenda?',
                buttons: {

                    Sim: function () {
                        $.ajax({
                            url: "/api/orders/historic",
                            // Usamos POST em vez de PUT por causa que algumas vezes os clientes metem milhares de linhas
                            // De texto, etc e em alguns servidores pode dar erro
                            type: "POST",
                            data: data,
                            dataType: "json",
                            success: function (response) {

                                if (!response.success) {

                                    // Output do erro
                                    console.error(response);

                                    $.alert({
                                        title: 'Erro!',
                                        theme: "supervan",
                                        content: 'Ocorreu algum erro ao processar o pedido, mais informações na consola do navegador!',
                                    });
                                    // Não deixar a função executar mais
                                    return;
                                }

                                populateNewStatus(response.data, nameStatus)
                            },
                            error: function (jqXHR, textStatus, errorThrown) {

                                console.log(textStatus, errorThrown);
                                // @TODO:
                                // Mostar mensagem de erro
                            }
                        });

                    },
                    Não: {}
                }
            });
        }

        function populateNewStatus(item, nameStatus) {

            let templateRow = `
                <tr>
                    <td>` + nameStatus + `</td>
                    <td class="text-muted"><div class="badge badge-light truncate mb-0 text-muted text-small">` + item.date + `</div></td>
                </tr>`;

            $("#historicTableBody").append(templateRow)
        }

    </script>
@endsection
