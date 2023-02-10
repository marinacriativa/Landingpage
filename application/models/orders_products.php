<?php 

/** 
*   Model orders_products 
* 
*   Extends: core/Model.php
*   Author: Vlad
* 
*   Insert, edit, delete extends from /application/core/model.php
**/

namespace Fyre\Model;

class orders_products extends \Fyre\Core\Model {

    public $table_name  = "orders_products"; 
    public $schema      = array (
                            "idOrder",
                            "idProduct",
                            "qty_product",
                            "type",
                            "personalization"
                        );
    
    public function single($id) {
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        
        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));
        return $query->fetch();
    }
}
?>