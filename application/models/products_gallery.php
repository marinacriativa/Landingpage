<?php

/**
 *   Model products_gallery
 *
 *   Extends: core/Model.php
 *   Author: Vlad
 *
 *   Insert, edit, delete extends from /application/core/model.php
 **/

namespace Fyre\Model;

class products_gallery extends \Fyre\Core\Model {

    public $table_name  = "products_gallery";
    public $schema      = array (
        "id",
        "product_id",
        "path",
        "name",
        "size",
        "date",
        "order_key",
        "isvideo",
    );

    public function single($id) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));
        return $query->fetch();
    }

    public function multiple($product_id) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE product_id = :product_id ORDER BY order_key ASC";
        $query = $this->db->prepare($sql);     
        $query->execute(array(":product_id" => $product_id));
        return $query->fetchAll();
    }

    public function order($ids) {
        
        if (empty($ids)) {
            
            return array("success" => false, "message" => "Empty data");
        }
        
        $sql = "";
        $ids = explode(",", $ids);
        
        foreach ($ids as $key => $id) {
            
            $sql .= "UPDATE " . $this->table_name . " SET `order_key` = " . $key . " WHERE id = " . $id . ";";
        }

        // Definir a foto principal na coluna photo do produto
        // Obter o caminho da foto
        $main_foto = $this->single($ids[0]);

        if (!empty($main_foto)) {

            $photo      = $main_foto->path;
            $product_id = $main_foto->product_id;
           
            $sql .= "UPDATE products SET `photo` = '" . $photo . "' WHERE id = " . $product_id . ";";
        }
        
        return $this->execute($sql, array());
    }
}
?>