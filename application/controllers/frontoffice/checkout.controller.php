<?php

/**
* Controller cart ( Frontoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class checkout extends \Fyre\Core\Controller {

    function get() {

        global $app;

        // Dependencies
        $this->dependencies(array("products", "users", "coupons", "personalization", "discounts", "countries", "shipping", "payment", "personalization_items", "advanced_products", "products_gallery"), array());

        $cart       = ((isset($_COOKIE["cart"]) && !empty($_COOKIE["cart"])) ? @json_decode($_COOKIE["cart"], true) : array());
        $coupon     = ((isset($_COOKIE["coupon"]) && !empty($_COOKIE["coupon"])) ? @json_decode($_COOKIE["coupon"], true) : array());

        foreach ($cart as $key => $item) {

            $product_info = $this->dependencies->products->single($item["id"]);

            if (!empty($product_info)) {

                $cart[$key]["product"] = $product_info;

                // Vereficar se é produto composto
                if ($product_info->type === "1") {

                    $cart[$key]["advanced"] = $this->dependencies->advanced_products->single($item["personalization"]);
                    $gallery                = $this->dependencies->products_gallery->multiple($item["id"]);

                    $imagesId               = explode(",", $cart[$key]["advanced"]->gallery);

                    $filteredGallery = array_filter($gallery, function ($image) use ($imagesId) {

                        return in_array($image->id, $imagesId);
                    });

                    $cart[$key]["advanced"]->gallery = $filteredGallery;
                    $cart[$key]["advanced"]->quantity = $item['quantity'];

                }

                // Vereficar se é produto personalizado
                if ($product_info->type == 2) {

                    $cart[$key]["personalizations"]             = array();
                    $cart[$key]["personalizations"]["items"]    = array();
                    $cart[$key]["personalizations"]["groups"]   = array();

                    foreach ($item['personalization'] as $personalization_group => $personalization) {

                        // Obter os grupos se ja nao os fomos buscar
                        // Não sei porque é que fiz isto mas yah :l, nem era preciso meter este check
                        if (!isset($cart[$key]["personalizations"]["groups"][$personalization_group])) {

                            $cart[$key]["personalizations"]["groups"][$personalization_group] = $this->dependencies->personalization->single($personalization_group);
                        }

                        // Obter os items da personalização
                        $cart[$key]["personalizations"]["items"][] = $this->dependencies->personalization_items->single($personalization);
                    }
                }

            } else {

                unset($cart[$key]);
            }
        }

        foreach ($coupon as $key => $item) {

            $coupon_info = $this->dependencies->coupons->singleByCode($item["code"]);

            if (!empty($coupon_info)) {

                $coupon[$key]["coupon"] = $coupon_info;

            } else {

                unset($coupon[$key]);
            }
        }

        if (empty($cart)) {

            header("Location: /");
            exit();
        }

        // Obter lista de todos os paises
        $countries = $this->dependencies->countries->multiple();

        // Obter a lista dos metodos de envio
        $shipping = $this->dependencies->shipping->multiple($app->selected_language->code);

        // Obter a lista de pagamentos
        $payment_gateways = $this->dependencies->payment->multiple(true);

        // Obter dados do cliente usuario)
        $user = false;
        if($this->user != null) {
            $user = $this->dependencies->users->single($this->user['id']);
        }

        echo $this->template("pages/checkout", compact("cart", "countries", "shipping", "payment_gateways", "coupon", "user"));
    }

    function pay($order_number) {

        global $app;

        // Dependencies
        $this->dependencies(array("orders", "products", "shipping", "payment"), array());

        // Ir buscar a encomenda pela string order_number
        $order = $this->dependencies->orders->singleByOrderNumber($order_number);

        if (empty($order)) {
            // A encomenda não foi encontrada, rederecionar para a página inicial
            header("Location: /" . $app->selected_language->code . "/?msg=Pedido realizado com sucesso, confira seu e-mail para finalizar o pagamento.");
            exit();
        }

        // Se a encomenda tiver um utilizador associado e o utilizador que está logado não é o mesmo, rederecionar
        if ($this->user !== null) {

            if ($order->user_id !== null && $order->user_id !== $this->user["id"]) {

                header("Location: /");
                exit();
            }
        }

        // Vereficar se já está paga
        if ($order->payment_status == true) {

            // Já foi paga, mostrar página de obrigado

        } else {

            // Obter método de pagamento
            $payment_method = $this->dependencies->payment->single($order->method);

            if (empty($payment_method)) {

                header("Location: /");
                exit();
            }

            // Abrir a página do metodo de pagamento /application/templates/frontoffice/payments/

            $APP = APP;
            $orders_object = $this->dependencies->orders;

            echo $this->template("payments/" . $payment_method->checkout_page, compact("order", "payment_method", "APP", "orders_object"));
        }
    }

    function pay_status($order_number) {

        // Dependencies
        $this->dependencies(array("orders"), array());

        // Ir buscar a encomenda pela string order_number
        $order = $this->dependencies->orders->singleByOrderNumber($order_number);

        if (empty($order)) {

            echo "false";

        } elseif ($order->payment_status == "1") {

            echo "true";

        } else {

            echo "false";
        }
    }

    function checkout() {

        global $app;

        // Dependencies
        $this->dependencies(array("orders", "users", "products", "shipping", "payment", "orders_products", "advanced_products", "translation", "notifications", "historic", "coupons"), array("email"));

        // Vereficar se o carrinho não está vazio
        $cart       = ((isset($_COOKIE["cart"]) && !empty($_COOKIE["cart"])) ? @json_decode($_COOKIE["cart"], true) : array());
        $total      = 0;

        if (empty($cart)) {

            // Erro que tem o carrinho vazio
            header("Location: /cart/details?error=1");
            exit();
        }

        // Info do utilizador
        $keys = array(
            "customer_name",
            "customer_email",
            "customer_country",
            "customer_address",
            "customer_city",
            "customer_zip",
            "customer_phone",
            "customer_fiscal",
            "method",
            "shipping"
        );

        // Vereficar se temos todas as informações que necessitamos
        foreach ($keys as $key) {

            if (!isset($_POST[$key]) && !empty($_POST[$key])) {

                // Rederecionar para o checkout e indicar que tem um erro
                header("Location: /checkout?error=1");
                exit();
            }
        }

        // Loop de todos os produtos e adicionar ao total
        foreach ($cart as $key => $item) {

            $product_info           = $this->dependencies->products->single($item["id"]);
            $cart[$key]["product"]  = $product_info;

            if (!empty($product_info)) {

                if ($product_info->type === "1") {

                    $advanced    = $this->dependencies->advanced_products->single($item["personalization"]);
                    $total      += ($advanced->current_price * $item["quantity"]);

                } else {

                    $total += ($product_info->price * $item["quantity"]);
                }
            }
        }

        // Meter tudo numa array
        $order = $_POST;
        $subtotal = $total;


        // Vereficar se o shipping e metodo de pagamento são válidos
        $shipping_method = $this->dependencies->shipping->single($order["shipping"]);

        if (empty($shipping_method)) {

            // O método de envio selecionado não existe
            header("Location: /checkout?error=2");
            exit();
        }

        // Remove all illegal characters from email
        $order["customer_email"] = filter_var($order["customer_email"], FILTER_SANITIZE_EMAIL);

        // Validar e-mail
        if (!filter_var($order["customer_email"], FILTER_VALIDATE_EMAIL)) {

            // Email inválido
            header("Location: /checkout?error=3");
            exit();
        }

        // Selecionar o metodo de envio e adicionar o custo ao total
        $order["shipping_cost"]  = $shipping_method->price;
        $total                  += $shipping_method->price;
        $coupon_type = false;

        if(!empty($order["coupon_code"])) {
            $db_coupon = $this->dependencies->coupons->singleByCode($order["coupon_code"]);

            if($db_coupon === false || empty($db_coupon) || $db_coupon == null) {
                // O coupon selecionado não existe
                header("Location: /checkout?error=001");
                exit();
            }

            $coupon_type = $db_coupon->type;
            switch($db_coupon->apply_discount) {
                case 0:
                    if($db_coupon->type == 0) {
                        $percentage 	= $total * $db_coupon->discount / 100;
						$result 		= $total - $percentage;
						$final_total 	= round($total - $result, 2);
                        $total -= $final_total ;
                    } else {
                        $total -= $db_coupon->discount;
                    }
                    break;
                case 1:
                    if($db_coupon->type == 0) {
                        $percentage 	= $subtotal * $db_coupon->discount / 100;
						$result 		= $subtotal - $percentage;
						$final_total 	= round($subtotal - $result, 2);
                        $total -= $final_total ;
                    } else {
                        $total -= $db_coupon->discount;
                    }
                    break;
                case 2:
                    if($db_coupon->type == 0) {
                        $percentage 	= intval($order["shipping_cost"]) * $db_coupon->discount / 100;
						$result 		= intval($order["shipping_cost"]) - $percentage;
						$final_total 	= round(intval($order["shipping_cost"]) - $result, 2);
                        $total          -= $final_total;
                    } else {
                        $total                  -= $db_coupon->discount;
                    }
                    break;
            }
        }

        // Método de pagamento
        $payment_method = $this->dependencies->payment->single($order["method"]);

        if (empty($payment_method)) {

            // O método de pagamento selecionado não existe
            header("Location: /checkout?error=4");
            exit();
        }

        // Taxas
        if ($app->config->tax != 0) {

            $order["tax"] = ($total / 100) * $app->config->tax;
            $total = $total + $order["tax"];
        }

        // Inserir o total na encomenda
        $order["pay_amount"]        = $total;
        $order["payment_status"]    = 0;

        // Gerar order key
        $order["order_number"] = $this->dependencies->orders->randomOrderNumber();

        $order["lang"] = $app->selected_language->code;
        $lang = $this->dependencies->translation->singleByCode($order["lang"]);

        $order["status"] = $lang->default_state1;

        // Inserir user id se tiver login
        if ($this->user !== null) {

            $order["user_id"] = $this->user["id"];
        }


        // Inserir a encomenda na database
        $status = $this->dependencies->orders->insert($order);

        // Limpar carrinho
        setcookie("cart", json_encode(array()), time() + 1, "/"); // 1 segundo

        // Limpar coupons
        setcookie("coupon", json_encode(array()), time() + 1, "/"); // 1 segundo

        if ($status["success"]) {

            $this->dependencies->orders->edit(["id" => $status["data"], "order_number" => 100 . $status["data"]]);

            $listProducts = array();

            foreach ($cart as $key => $item) {
                $type = 'Simples';

                if($item["type"] == '1'){
                    $type = "Composto";
                }elseif ($item["type"] == '2'){
                    $type = "personalizado";
                }

                $cart[$key]["product"]->product_name    = $item["product"]->name;
                $cart[$key]["product"]->qty_product     = $item["quantity"];

                $product =array(
                    "product_name"       => $item["product"]->name,
                    "photo"     => $item["product"]->photo,
                    "qty_product"   => $item["quantity"],
                    "sku"   => $item["product"]->sku,
                    "price"   => $item["product"]->price,
                    "type"   => $type,
                );


                if (isset($item["personalization"])) {

                    $personalization = json_encode($item["personalization"]);

                } else {

                    $personalization = json_encode(array());
                }

//                if(!empty($item["personalization"])){
//                    $personalization = json_encode($item["personalization"]);
//                }

                // Adicionar os produtos comprados
                $this->dependencies->orders_products->insert(array(
                    "idOrder"       => $status["data"],
                    "idProduct"     => $item["product"]->id,
                    "qty_product"   => $item["quantity"],
                    "type"          => $item["type"],
                    "personalization" => $personalization
                ));

                //insere na lista de produtos

                array_push($listProducts, $product);
            }

            //Adicionar status de pagamento ao historico
            $this->dependencies->historic->insert(array(
                "idOrder" => $status["data"],
                "status" => $lang->default_state1
            ));


            $order_email    = $this->dependencies->orders->single($status["data"]);
            $email          = $order_email->customer_email;

            $data_email = array(
                "order_number"      => $order_email->order_number,
                "products"          => $listProducts,
                "pay_amount"        => $order_email->pay_amount,
                "name"              => $order_email->customer_name,
                "nif"               => $order_email->customer_fiscal,
                "phone"             => $order_email->customer_phone,
                "address"           => $order_email->customer_address,
                "city"              => $order_email->customer_city,
                "zip"               => $order_email->customer_zip,
                "country"           => $order_email->customer_country,
                "order_note"        => $order_email->order_note,
                "coupon_code"       => $order_email->coupon_code,
                "coupon_discount"   => $order_email->coupon_discount,
                "coupon_type"       => $coupon_type,
                "shipping_cost"     => $order_email->shipping_cost,
                "payment_method"    => $payment_method->name,
                "subtotal"          => $subtotal,
                "tax"               => $order_email->tax,
                "date"              => $order_email->created_at,
                "link"              => URL . "orders/" . $order_email->id,
                "linkContact"       => URL . $app->selected_language->code . "/contact",
                "other"             => $app->config,
                "billing_name"      => $order_email->billing_name,
                "billing_nif"       => $order_email->billing_nif,
                "billing_address"   => $order_email->billing_address,
                "billing_city"      => $order_email->billing_city,
                "cart"              => $cart
            );

            if ($payment_method->checkout_page == "bank_transfer") {

                $pay_settings = json_decode($payment_method->settings);

                $data_email_bank_transfer = array(
                    "order_number"      => $order_email->order_number,
                    "products"          => $listProducts,
                    "pay_amount"        => $order_email->pay_amount,
                    "name"              => $order_email->customer_name,
                    "nif"               => $order_email->customer_fiscal,
                    "phone"             => $order_email->customer_phone,
                    "address"           => $order_email->customer_address,
                    "city"              => $order_email->customer_city,
                    "zip"               => $order_email->customer_zip,
                    "country"           => $order_email->customer_country,
                    "order_note"        => $order_email->order_note,
                    "coupon_code"       => $order_email->coupon_code,
                    "coupon_discount"   => $order_email->coupon_discount,
                    "shipping_cost"     => $order_email->shipping_cost,
                    "payment_method"    => $payment_method->name,
                    "pay_settings"      => $pay_settings,
                    "subtotal"          => $subtotal,
                    "tax"               => $order_email->tax,
                    "date"              => $order_email->created_at,
                    "link"              => URL . "orders/" . $order_email->id,
                    "linkContact"       => URL . $app->selected_language->code . "/contact",
                    "other"             => $app->config,
                    "billing_name"      => $order_email->billing_name,
                    "billing_nif"       => $order_email->billing_nif,
                    "billing_address"   => $order_email->billing_address,
                    "billing_city"      => $order_email->billing_city,
                    "cart"              => $cart
                );

                $this->dependencies->library->email->send($email, "Dados para pagamento", "emailBankTransfer", $data_email_bank_transfer);
            }

            if ($payment_method->checkout_page == "mbway_manual") {

                $pay_settings = json_decode($payment_method->settings);

                $data_email_bank_transfer = array(
                    "order_number"      => $order_email->order_number,
                    "products"          => $listProducts,
                    "pay_amount"        => $order_email->pay_amount,
                    "name"              => $order_email->customer_name,
                    "nif"               => $order_email->customer_fiscal,
                    "phone"             => $order_email->customer_phone,
                    "address"           => $order_email->customer_address,
                    "city"              => $order_email->customer_city,
                    "zip"               => $order_email->customer_zip,
                    "country"           => $order_email->customer_country,
                    "order_note"        => $order_email->order_note,
                    "coupon_code"       => $order_email->coupon_code,
                    "coupon_discount"   => $order_email->coupon_discount,
                    "shipping_cost"     => $order_email->shipping_cost,
                    "payment_method"    => $payment_method->name,
                    "pay_settings"      => $pay_settings,
                    "subtotal"          => $subtotal,
                    "tax"               => $order_email->tax,
                    "date"              => $order_email->created_at,
                    "link"              => URL . "orders/" . $order_email->id,
                    "linkContact"       => URL . $app->selected_language->code . "/contact",
                    "other"             => $app->config,
                    "billing_name"      => $order_email->billing_name,
                    "billing_nif"       => $order_email->billing_nif,
                    "billing_address"   => $order_email->billing_address,
                    "billing_city"      => $order_email->billing_city,
                    "cart"              => $cart
                );

                $this->dependencies->library->email->send($email, "Dados para pagamento", "emailMbwayManual", $data_email_bank_transfer);
            }

            // Obter os administradores que recebem pedidos de contacto
            $emails = $this->dependencies->users->getEmailsForNotifications("notification_new_order");

            // Enviar os email
            $this->dependencies->library->email->send($email, "Nova Encomenda", "emailConfirmationOrder", $data_email);
            $this->dependencies->library->email->send($emails, "Nova Encomenda", "emailConfirmationOrderAdm", $data_email);

            //Criar notificação de nova Order
            $admins = $this->dependencies->users->getAdmins();

            foreach ($admins as $idAdmin) {

                $data_notification = array(
                    "id_user" => $idAdmin,
                    "type" => "order",
                    "identifier" => $order_email->order_number,
                    "link" => URL . "adm/orders/show/" . $order_email->id,
                );

                $this->dependencies->notifications->insert($data_notification);
            }

            if ($payment_method->checkout_page == "vivawallet") {

                $order_email->payment_method = json_decode($payment_method->settings);

                $orders_object = new \Fyre\Model\orders();
                //$this->sendNotificationToAdmins($order_email, $data_email);

                echo $this->template("payments/vivawallet", compact("order_email", "orders_object"));

                exit();
            }


        } else {

            // Erro no checkout
            header("Location: /checkout?error=5");
            exit();
        }

        // Rederecionar para a página de pagamento
        header("Location: /checkout/" . $order["order_number"]);
    }
}
