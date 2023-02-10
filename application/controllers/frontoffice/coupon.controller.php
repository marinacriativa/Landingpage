<?php 

/** 
* Controller coupon ( Frontoffice ) 
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class coupon extends \Fyre\Core\Controller {

    function add() {

        global $app;

        $this->dependencies(array("coupons", "orders", "users", "products"), array());

        if(!isset($_POST["code"])) {

            $this->response(false, "Insira um código de cupom válido.");
        }

        $added = false;
        $new_coupon = array("code" => $_POST["code"]);

        if(isset($_POST["code"])) {    

            $coupon = ((isset($_COOKIE["coupon"]) && !empty($_COOKIE["coupon"])) ? @json_decode($_COOKIE["coupon"], true) : array());
            
            if(!empty($coupon))
                $this->response(false, "Não é possível usar mais de um coupon por vez");

            $db_coupon = $this->dependencies->coupons->singleByCode($new_coupon["code"]);

            if($db_coupon === false || empty($db_coupon) || $db_coupon == null) 
                $this->response(false, "Coupon inválido");
            
            foreach($db_coupon as $key => $value) {

                switch($key) {
                    case 'first_purchase':

                        if($value == 1) {
                            $already_used = $this->dependencies->orders->getByCoupon($new_coupon["code"]);

                            if($already_used != false && !empty($already_used) && $already_used != null) 
                                $this->response(false, "Este coupon não pode ser usado mais de uma vez.");   
                        }                        
                        break;

                    case 'reused':

                        if($value == 1) {
                            $reused_by_user = $this->dependencies->orders->getCouponByUser($this->user["id"], $new_coupon["code"]);

                            if($reused_by_user != false && !empty($reused_by_user) && $reused_by_user != null) 
                                $this->response(false, "Este coupon não pode ser usado mais de uma vez pelo mesmo usuário.");     
                        }                        
                        break;

                    case 'start_date':

                        if($value != null) {
                            if(date('Y-m-d') < $value)                 
                                $this->response(false, "Este coupon só poderá ser utilizado a partir de ". implode("/",array_reverse(explode("-",$value))));    
                        }                        
                        break;

                    case 'end_date':

                        if($value != null) {
                            if(date('Y-m-d') > $value)               
                                $this->response(false, "Este coupon só poderia ser utilizado até ". implode("/",array_reverse(explode("-",$value))));     
                        }                        
                        break;

                    case 'start_price':

                        if($value > $_POST["total"]) {
                            $this->response(false, "Este coupon só pode ser aplicado em compras a partir de " . $value . '');     
                        }                        
                        break;

                    case 'customer_group':

                        if($value != null) {
                            $group = $this->dependencies->users->getGroup($this->user["id"], $value);                            
                            if($group == false) 
                                $this->response(false, "Este coupon só pode ser aplicado para os clientes: " . $value . '');
                        }                        
                        break;

                    case 'products_group':

                        if($value != null) {                              
                            $ids_products = explode(",", $_POST['products_id']);
                            foreach($ids_products as $id) {
                                $group_p = $this->dependencies->products->getGroup($id, $value);                                   
                                if($group_p == false) {
                                    $product        = $this->dependencies->products->single($id);                                   
                                    $this->response(false, "O cupom não pode ser aplicado ao produto: " . $product->name . ", pois não faz parte do(s) grupo(s): " . $value . "");
                                }                                   
                            }        
                        }                        
                        break;
                }

            }               

            if($added == false)          
                $coupon[] = $new_coupon;            

            // Guardar o coupon em cookie
            setcookie("coupon", json_encode($coupon), time() + (60 * 60 * 24), "/"); // 14 dias

            $this->response(true, "Added coupon successfully", $coupon);
        }
    }

    function get() {

        global $app;

        $this->dependencies(array("coupons"), array());

        $coupon = ((isset($_COOKIE["coupon"]) && !empty($_COOKIE["coupon"])) ? @json_decode($_COOKIE["coupon"], true) : array());

        foreach ($coupon as $key => $item) {

            $coupon_info = $this->dependencies->coupons->singleByCode($item["code"]);
            
            if (!empty($coupon_info)) {

                $coupon[$key]["coupon"] = $coupon_info;

            } else {

                unset($coupon[$key]);
            }
        }


        echo $this->template("items/coupon", compact("coupon"));
    }

    function removeItem($code){


        $coupon = ((isset($_COOKIE["coupon"]) && !empty($_COOKIE["coupon"])) ? @json_decode($_COOKIE["coupon"], true) : array());

        foreach ($coupon as $key => $item) {
            if ($item["code"] == $code) {
                unset($coupon[$key]);
            }
        }

        setcookie("coupon", json_encode($coupon), time() + (60 * 60 * 24), "/");
        $this->response(true, "Coupon removido.", array("coupon" => $coupon, "count" => count($coupon)));
    }

}