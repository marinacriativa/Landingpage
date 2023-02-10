<?php 

/** 
* Controller cart ( Frontoffice ) 
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class cart extends \Fyre\Core\Controller {

    function add() {

        global $app;

        $this->dependencies(array("advanced_products", "products_gallery", "personalization_items"), array());

        if (!isset($_POST["product_id"])) {

            $this->response(false, "Invalid request");
        }

        $added = false;

        $new_product = array("id" => $_POST["product_id"], "quantity" => 1, "type" => $_POST["type"]);

        if (isset($_POST["personalization"]) && !empty($_POST["personalization"])) {

            $new_product['personalization'] = $_POST["personalization"];
        }

        if (isset($_POST["quantity"]) && is_numeric($_POST["quantity"])) {

            $new_product["quantity"] = (int) $_POST["quantity"];
        }
        
        $cart = ((isset($_COOKIE["cart"]) && !empty($_COOKIE["cart"])) ? @json_decode($_COOKIE["cart"], true) : array());

        $advancedProduct = array();

        foreach ($cart as $key => $item) {

            // ID igual, vamos adicionar à quantidade
            if ($item["id"] == $new_product["id"]) {

                if($item["type"] != $new_product["type"]){
                    unset($cart[$key]);
                }

                if ($new_product["type"] == 0) {

                    $added = true;
                    $cart[$key]["quantity"] = $cart[$key]["quantity"] + $new_product["quantity"];
                }
                
                // Vereficar se tem personalizações iguais
                if ($new_product["type"] == 2) {

                    if (isset($new_product['personalization'])) {

                        if (isset($item["personalization"]) && $item["personalization"] == $new_product["personalization"]) {

                            $added = true;
                            $cart[$key]["quantity"] = $cart[$key]["quantity"] + $new_product["quantity"];
                        }
                    }
                }

                // Vereficar se tem produto composto igual
                if ($new_product["type"] == 1) {

                    if (isset($new_product['personalization'])) {

                        if (isset($item["personalization"]) && $item["personalization"] == $new_product["personalization"]) {

                            $added = true;
                            $cart[$key]["quantity"] = $cart[$key]["quantity"] + $new_product["quantity"];
                        }
                    }
                }
            }
        }

        if ($added == false) {

            $cart[] = $new_product;
        }

        // Guardar o carrinho em cookie
        setcookie("cart", json_encode($cart), time() + (86400 * 30 * 14), "/"); // 14 dias

        $this->response(true, "Added to cart successfully", array("cart" => $cart, "count" => count($cart), "advancedProduct" => $advancedProduct));
    }

    function details() {

        global $app;
        
        // Dependencies
        $this->dependencies(array("products", "personalization", "discounts", "personalization_items", "advanced_products", "products_gallery"), array());

        $cart = ((isset($_COOKIE["cart"]) && !empty($_COOKIE["cart"])) ? @json_decode($_COOKIE["cart"], true) : array());

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

        echo $this->template("pages/cart", compact("cart"));
    }

    function get() {

        global $app;
        
        // Dependencies
        $this->dependencies(array("products", "personalization", "discounts", "personalization_items", "advanced_products", "products_gallery"), array());

        $cart = ((isset($_COOKIE["cart"]) && !empty($_COOKIE["cart"])) ? @json_decode($_COOKIE["cart"], true) : array());

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


        echo $this->template("items/cart", compact("cart"));
    }

    function changeQuantity($idProduct){
        $new_quantity = $_POST['quantity'];

        $cart = ((isset($_COOKIE["cart"]) && !empty($_COOKIE["cart"])) ? @json_decode($_COOKIE["cart"], true) : array());

        foreach ($cart as $key => $item) {

            // ID igual, vamos adicionar à quantidade
            if ($item["id"] == $idProduct) {
                $cart[$key]["quantity"] = $new_quantity;
            }

        }

        setcookie("cart", json_encode($cart), time() + (86400 * 30 * 14), "/");
        $this->response(true, "Quantity chaged", array("cart" => $cart, "count" => count($cart)));
    }

    function changeQuantityAdvanced($id_advanced){

        $new_quantity = $_POST['quantity'];

        $cart = ((isset($_COOKIE["cart"]) && !empty($_COOKIE["cart"])) ? @json_decode($_COOKIE["cart"], true) : array());

        foreach ($cart as $key => $item) {          
            // ID igual, vamos adicionar à quantidade
            if ($item["id"] == $_POST['id_product']) {
                if($item["personalization"] == $id_advanced) {             
                    $cart[$key]["quantity"] = $new_quantity;
                }
            }

        }

        setcookie("cart", json_encode($cart), time() + (86400 * 30 * 14), "/");
        $this->response(true, "Quantity chaged", array("cart" => $cart, "count" => count($cart)));
    }

    function removeItem($idProduct){


        $cart = ((isset($_COOKIE["cart"]) && !empty($_COOKIE["cart"])) ? @json_decode($_COOKIE["cart"], true) : array());



        foreach ($cart as $key => $item) {
            if ($item["id"] == $idProduct) {
                unset($cart[$key]);
            }
        }

        setcookie("cart", json_encode($cart), time() + (86400 * 30 * 14), "/");
        $this->response(true, "Quantity chaged", array("cart" => $cart, "count" => count($cart)));
    }

    function removeItemAdvanced($key){


        $cart = ((isset($_COOKIE["cart"]) && !empty($_COOKIE["cart"])) ? @json_decode($_COOKIE["cart"], true) : array());


        unset($cart[$key]);

        setcookie("cart", json_encode($cart), time() + (86400 * 30 * 14), "/");
        $this->response(true, "Quantity chaged", array("cart" => $cart, "count" => count($cart)));
    }

}