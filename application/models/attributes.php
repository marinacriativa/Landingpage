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

class attributes extends \Fyre\Core\Model {

    public $table_name  = "attributes";
    public $schema      = array (
        "id",
        "value",
        "attribute_key",
        "id_product",
        "order_by",
    );

    public function single($id) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));
        return $query->fetch();
    }

    public function ordenation ($i, $id) {
        
        $sql = "UPDATE " . $this->table_name . " SET order_by = ".$i." WHERE id = ".$id."";
        
        $query = $this->db->prepare($sql);
        
        return $query->execute();
    }

    public function getAttributesByProduct($productId) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id_product = :id_product ORDER BY order_by ASC";

        $query = $this->db->prepare($sql);
        $query->execute(array(":id_product" => $productId));
        return $query->fetchAll();
    }
}
