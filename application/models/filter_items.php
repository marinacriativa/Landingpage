<?php 

/** 
*   Model filter_items 
* 
*   Extends: core/Model.php
*   Author: Vlad
**/

namespace Fyre\Model;

class filter_items extends \Fyre\Core\Model {

    public $table_name  = "filters_items"; 
    public $schema      = array (
                            "id",
                            "filter_id",
                            "name",
                            "order_by",
                            "has_associate_product",
                        );
    
    /*
        Insert, edit, delete extends from /application/core/model.php
    */

    public function single($id) {
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        
        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));
        return $query->fetch();
    }

    public function all() {
        
        $sql = "SELECT * FROM " . $this->table_name."";
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public function multiple($filter_id) {
        
        $sql = "SELECT * FROM " . $this->table_name." WHERE filter_id = ". $filter_id ." ORDER BY order_by ASC";
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function orderASC() {
        
        $sql = "SELECT * FROM " . $this->table_name." ORDER BY name ASC";
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function associateProduct ($id, $v) {
        
        $sql = "UPDATE " . $this->table_name . " SET has_associate_product = ".$v." WHERE id = ".$id."";
        
        $query = $this->db->prepare($sql);
        
        return $query->execute();
    }

    function listing($filter_id) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE filter_id = ". $filter_id ." AND has_associate_product = 1 ORDER BY order_by ASC";
      
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getLanguageByLang($language) {

        $execute    = array(":language" => $language);

        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :language AND root = 1" ;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }
}
?>