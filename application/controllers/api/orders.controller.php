<?php

/**
 *   Controller products ( API )
 *
 *   Extends: core/Controller.php
 *   Author: Vlad
 **/

namespace Fyre\Controller;

class orders extends \Fyre\Core\Controller
{

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("orders", "orderStatus", "translation"), array());

        $page   = (isset($_GET["page"]))    ? intval($_GET["page"])     : 1;
        $limit  = (isset($_GET["length"]))  ? intval($_GET["length"])   : 5;
        $search = (isset($_GET["search"]))  ? $_GET["search"]           : null;
        $order  = (isset($_GET["order"]))   ? $_GET["order"]            : "id";

        $start  = ($page - 1) * $limit;

        $orders = $this->dependencies->orders->multiple(null, $start, $limit, $search, $order);
        $total  = $this->dependencies->orders->total(null, $search);

        $pagination = array(

            "page"  => (int) $page,
            "limit" => (int) $limit,
            "total" => (int) $total,
            "start" => (int) $start,
        );

        if (empty($orders)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        foreach ($orders->orders_data as $order) {

            $status             = $this->dependencies->orderStatus->byLang($order->lang);
            $order->status_data = $status;
        }

        $this->response(true, "API REQUEST SUCCESS", $orders, $pagination);
    }

    function singleAll($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("orders", "coupons", "orderStatus", "personalization_items", "advanced_products", "personalization", "payment", "translation", "shipping"), array());

        // Product array
        $order = $this->dependencies->orders->singleAll($id);

        foreach ($order->order_products_data as $product) {

            $personalization            = json_decode($product->personalization);
            $personalization_item_array = array();

            if ($product->type == 2) {

                foreach ($personalization as $key => $item_personalization) {

                    $item   = $this->dependencies->personalization_items->single($item_personalization);
                    $group  = $this->dependencies->personalization->single($key);

                    $personalization_item = (object) array(
                        'item' => $item,
                        "group" => $group,
                    );

                    array_push($personalization_item_array, $personalization_item);

                    $product->personalization = $personalization_item_array;
                }
            }

            if ($product->type == 1){

                $item = $this->dependencies->advanced_products->single($personalization);
                $product->personalization = $item;
            }
        }

        if (empty($order)) {

            $this->response(false, "API REQUEST EMPTY");
        }
        
        $status                      = $this->dependencies->orderStatus->byLang($order->order_data->lang);
        $order->order_status_data    = $status;
        $payment_method              = $this->dependencies->payment->single($order->order_data->method);
        $order->order_data->method   = $payment_method->name;
        $order->order_data->shipping = $this->dependencies->shipping->single($order->order_data->shipping)->title;
        if($order->order_data->coupon_code != null) {
            $order->order_data->coupon = $this->dependencies->coupons->singleByCode($order->order_data->coupon_code);
        }

        $lang   = $this->dependencies->translation->singleByCode($order->order_data->lang);

        $this->response(true, "API REQUEST SUCCESS", $order);
    }

    function single($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("orders"), array());

        // Product array
        $order = $this->dependencies->orders->single($id);

        if (empty($order)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $order);
    }

    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("orders"));

        // Data handling
        $data = $_POST;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->orders->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->orders->single($id));
    }

    function ordersByClient($clientId)
    {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("orders"), array());

        $orders = $this->dependencies->orders->getOrdersByClient($clientId);
        if (empty($orders)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $orders);
    }

    function insertStatusInHistoric()
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("historic", "orders", "products", "orderStatus"), array("email"));

        if (isset($_POST["categories"]) && is_array($_POST["categories"])) {

            $_POST["categories"] = json_encode($_POST["categories"]);
        }

        // Insert the data
        $status = $this->dependencies->historic->insert($_POST);

        if ($status["success"]) {
          
            $order = $this->dependencies->orders->single($_POST["idOrder"]);    

            // Obter as info do estado novo
            $historic_info = $this->dependencies->orderStatus->single($_POST["status"]);

            if (!empty($order)) {

                // Mandar email para o cliente
                $data_email = array(
                    "name" => $order->customer_name,
                    "link" => "Link para confirmação do email",
                    "linkContact" => URL . $app->selected_language->code . "/contact",
                    "newOrderStatus" => $historic_info->name,
                    "newOrderText" => $historic_info->email,
                    'order' => $order,
                    "other" => $app->config,
                );

                // Enviar os email
                $this->dependencies->library->email->send($order->customer_email, $historic_info->name , "orderstatus", $data_email);

                //dar baixa no stock caso o id do status for pagamento concluído
                if($historic_info->id == 2) {

                    $products = $this->dependencies->orders->singleAll($order->id);                
              
                    foreach($products->order_products_data as $product) {                        
                        
                        if(isset($product->personalization) && !empty($product->personalization)){                            
                            $this->newStockFromAdvancedProduct($product);
                        } else {                            
                            $get_product = $this->dependencies->products->single($product->id);     
                                   
                            $new_stock = $get_product->stock - $product->qty_product;
                            if($new_stock <= 0) {
                                $new_stock = 0;
                            }
                            $arr_product = ['id' => $product->id, "stock" => $new_stock];                        
                            $this->dependencies->products->edit($arr_product);  
                        }

                    }

                }         
                
            }

            $this->response(true, "API REQUEST SUCCESS", $historic_info);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function newStockFromAdvancedProduct ($product) {      

             
        if (strpos($product->personalization, ":") !== false) {
            $id_advanced = preg_replace("/[^a-zA-Z0-9]+/", ",", $product->personalization);
            $ids_advanced = explode(",", $id_advanced);
            foreach ($ids_advanced as $id){
                if(!empty($id)) {                  
                    $this->setNewStockForProductAdvanced($product, $id);
                }
            }
        } else {
            $id_advanced = trim($product->personalization, '"');
            $this->setNewStockForProductAdvanced($product, $id_advanced);
        }


        $this->changeInfoFromMainProduct($product->id); 
    }


    function setNewStockForProductAdvanced($product, $id_advanced) {
        // Dependencies
        $this->dependencies(array("advanced_products"));


        $get_product = $this->dependencies->advanced_products->single(intval($id_advanced));     
        if($get_product == false) {
            return true;
        } 
        $new_stock = $get_product->stock - $product->qty_product;
        

        if($new_stock <= 0) {
            $new_stock = 0;
        }
        
        $arr_product = ['id' => $get_product->id, "stock" => $new_stock];                      
        $this->dependencies->advanced_products->edit($arr_product);                             

    }

    function changeInfoFromMainProduct($product_id) {
        
        // Dependencies
        $this->dependencies(array("advanced_products", "products"));

        $all = $this->dependencies->advanced_products->all($product_id);
        if(count($all) > 0) {
            $edit_product = ['id' => $all[0]->id_product, 'price' => $all[0]->current_price, 'stock' => $all[0]->stock, 'price_request' => $all[0]->price_request];                
            $all = $this->dependencies->products->edit($edit_product);
        }
        return $all;
    }

    function delete($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("orders"));

        // Delete the data
        $status = $this->dependencies->orders->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->orders->single($id));
        }

        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

}