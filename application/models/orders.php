<?php

/**
 *   Model products
 *
 *   Extends: core/Model.php
 *   Author: Vlad
 *
 *   Insert, edit, delete extends from /application/core/model.php
 **/

namespace Fyre\Model;

class orders extends \Fyre\Core\Model
{

    public $table_name = "orders";
    public $order_products_table_name = "orders_products";
    public $historic_table_name = "historic";
    public $order_status_table_name = "order_status";
    public $products_table_name = "products";
    public $schema = array(
        "id",
        "user_id",
        "method",
        "shipping",
        "pay_amount",
        "payment_info",
        "order_number",
        "payment_status",
        "customer_email",
        "customer_name",
        "customer_country",
        "customer_phone",
        "customer_address",
        "customer_fiscal",
        "customer_city",
        "customer_zip",
        "billing_name",
        "billing_nif",
        "billing_phone",
        "billing_address",
        "billing_city",
        "billing_country",
        "order_note",
        "coupon_code",
        "coupon_discount",
        "created_at",
        "shipping_cost",
        "tax",
        "lang",
        "status"
    );

    public function singleByOrderNumber($order_number) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE order_number = :order_number";
        $query = $this->db->prepare($sql);
        $query->execute(array(":order_number" => $order_number));

        return $query->fetch();
    }

    public function single($id)
    {

        $order_sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $order_query = $this->db->prepare($order_sql);
        $order_query->execute(array(":id" => $id));

        return $order_data = $order_query->fetch();
    }

    public function getByCoupon($coupon_code)
    {

        $order_sql = "SELECT * FROM " . $this->table_name . " WHERE coupon_code = :coupon_code";
        $order_query = $this->db->prepare($order_sql);
        $order_query->execute(array(":coupon_code" => $coupon_code));

        return $order_data = $order_query->fetch();
    }

    public function getCouponByUser($user_id, $coupon_code)
    {

        $order_sql = "SELECT * FROM " . $this->table_name . " WHERE coupon_code = :coupon_code AND user_id = " . $user_id;
        $order_query = $this->db->prepare($order_sql);
        $order_query->execute(array(":coupon_code" => $coupon_code));

        return $order_data = $order_query->fetch();
    }

    function randomOrderNumber() {

        $string = $this->random();

        // Vereficação para ver se nao repetimos o order number
        $sql   = "SELECT COUNT(id) FROM " . $this->table_name . " WHERE order_number = :order_number";
        $query = $this->db->prepare($sql);
        $query->execute(array(":order_number" => $string));

        $count = $query->fetchColumn();

        if ($count == 0) {

            return $string;
        }

        // Já existe um igual, vamos buscar outro
        return $this->randomOrderNumber();
    }

    function getOrderByTransactionID($payment_info) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE payment_info = :payment_info";
        $query = $this->db->prepare($sql);
        $query->execute(array(":payment_info" => $payment_info));

        return $query->fetch();
    }

    function random($lenght = 6) {

        $characters = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $randstring = array();

        for ($i = 0; $i <= $lenght; $i++) {

            $randstring[] = $characters[rand(0, (count($characters) - 1))];
        }

        return "E-" . implode("", $randstring);
    }

    public function singleAll($id)
    {

        $order_sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $order_query = $this->db->prepare($order_sql);
        $order_query->execute(array(":id" => $id));

        $order_products_sql = "SELECt p.name, p.id, p.photo, p.sku, p.price, p.slug, op.qty_product, op.type, op.personalization FROM " . $this->products_table_name. " p, " . $this->order_products_table_name. " op WHERE p.id = op.idProduct AND op.idOrder = :id";
        $order_products_query = $this->db->prepare($order_products_sql);
        $order_products_query->execute(array(":id" => $id));

        $historic_sql = "SELECT * FROM " . $this->historic_table_name . " WHERE idOrder = :id";
        $historic_query = $this->db->prepare($historic_sql);
        $historic_query->execute(array(":id" => $id));


        $order_data = $order_query->fetch();
        $order_products_data = $order_products_query->fetchAll();
        $historic_data = $historic_query->fetchAll();

        return (object) ['order_data' => $order_data, 'order_products_data' => $order_products_data, 'historic_date' => $historic_data];
    }

    public function multiple($language, $start = null, $limit = null, $search = null, $order = null)
    {

        $execute = array(":language" => $language);
        $query = "";
        $limiter = "";
        $order_by = "id";

        if ($limit !== null && $start !== null) {

            $limiter = " LIMIT " . $start . ", " . $limit;
        }

        if ($search != null) {

            $query .= " AND (order_number LIKE :search OR customer_name LIKE :search OR pay_amount LIKE :search OR payment_status LIKE :search) ";
            $execute[":search"] = "%" . $search . "%";
        }

        if ($order != null) {

            if (in_array($order, $this->schema)) {

                $order_by = $order;
            }
        }
        if ($language != null) {
            $query .= " AND (order_number LIKE :search OR customer_name LIKE :search OR pay_amount LIKE :search OR payment_status LIKE :search) ";
            $execute[":search"] = "%" . $search . "%";
        }

        $sql = "SELECT * FROM " . $this->table_name . " WHERE 1 = 1  " . $query . "ORDER BY " . $order_by . " DESC" . $limiter;
        $query = $this->db->prepare($sql);
        $query->execute($execute);


        $orders_data = $query->fetchAll();

        return (object) ['orders_data' => $orders_data];
    }

    public function getOrdersByClient( $clientId)
    {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE user_id = :id ORDER BY id DESC";

        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $clientId));
        return $query->fetchAll();
    }

    function total()
    {

        $sql = "SELECT COUNT(*) FROM " . $this->table_name;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchColumn();
    }
}

?>