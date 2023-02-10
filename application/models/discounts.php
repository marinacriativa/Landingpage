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

class discounts extends \Fyre\Core\Model {

    public $table_name  = "discounts";
    public $schema      = array (
        "id",
        "quantity",
        "percentage",
        "id_product",
    );

    public function single($id) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));
        return $query->fetch();
    }

    public function multiple($language, $start = null, $limit = null, $search = null, $order = null) {

        $execute    = array(":language" => $language);
        $query      = "";
        $limiter    = "";
        $order_by   = "id";

        if ($limit !== null && $start !== null) {

            $limiter = " LIMIT " . $start . ", " . $limit;
        }

        if ($search != null) {

            $query              .= " AND (title LIKE :search OR reference LIKE :search OR packing LIKE :search OR technical_piece LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";
        }

        if ($order != null) {

            if (in_array($order, $this->schema)) {

                $order_by = $order;
            }
        }
        if($language != null){
            $query              .= " AND (title LIKE :search OR reference LIKE :search OR packing LIKE :search OR technical_piece LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";
        }

        $sql = "SELECT * FROM " . $this->table_name . " WHERE 1 = 1  " . $query . "ORDER BY " . $order_by . " DESC" . $limiter;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    public function getDiscountByProduct($productId) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id_product = :id_product";

        $query = $this->db->prepare($sql);
        $query->execute(array(":id_product" => $productId));
        return $query->fetchAll();
    }
}
?>