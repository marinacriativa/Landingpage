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

class advanced_products extends \Fyre\Core\Model {

    public $table_name  = "products_advanced";
    public $schema      = array (
                            "id",
                            "id_product",
                            "name",
                            "stock",
                            "current_price",
                            "gallery",
                            "weight",
                            "height",
                            "width",
                            "depth",
                            "price_request",
                            "order_by",
                            "ref"
                        );
    
    
    public function single($id) {
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        
        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));


        return $query->fetch();
    }
    

    public function all($id_product) {
        
        $execute    = array(":id_product" => $id_product);

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id_product = :id_product ORDER BY order_by ASC";

        $query = $this->db->prepare($sql);

        $query->execute($execute);

        return $query->fetchAll();
    }

    public function advancedProductsByProduct($idProduct){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id_product = :id_product ORDER BY order_by ASC";
        $query = $this->db->prepare($sql);
        $query->execute(array(":id_product" => $idProduct));

        return $query->fetchAll();
    }   
}
