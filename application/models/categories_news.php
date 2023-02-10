<?php 

/** 
*   Model categories_news 
* 
*   Extends: core/Model.php
*   Author: Vlad
**/

namespace Fyre\Model;

class categories_news extends \Fyre\Core\Model {

    public $table_name  = "categories_news"; 
    public $schema      = array (
                            "id",
                            "name",
                            "lang",
                            "parent",
                            "root",
                            "order_by",
                            "has_associate_new",
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
    
    public function multiple() {
        
        $sql = "SELECT * FROM " . $this->table_name." ORDER BY order_by ASC";
        
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

    public function ordenation ($i, $id) {
        
        $sql = "UPDATE " . $this->table_name . " SET order_by = ".$i." WHERE id = ".$id."";
        
        $query = $this->db->prepare($sql);
        
        return $query->execute();
    }

    public function associateProduct ($id, $v) {
        
        $sql = "UPDATE " . $this->table_name . " SET has_associate_new = ".$v." WHERE id = ".$id."";
        
        $query = $this->db->prepare($sql);
        
        return $query->execute();
    }

    function listing($parent = null, $lang) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :lang ORDER BY order_by ASC";
       
        $query = $this->db->prepare($sql);
        $query->execute(array(":lang" => $lang));
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