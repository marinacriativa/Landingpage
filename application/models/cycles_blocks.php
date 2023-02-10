<?php 

/** 
*   Model cycles_blocks 
* 
*   Extends: core/Model.php
*   Author: Vlad
**/

namespace Fyre\Model;

class cycles_blocks extends \Fyre\Core\Model {

    public $table_name  = "cycles_blocks"; 
    public $schema      = array (
                            "id",
                            "name",
                            "title",
                            "subtitle",
                            "icon",
                            "lang",
                            "active",
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
    
    public function multiple($lang) {
        
        $sql = "SELECT * FROM " . $this->table_name." WHERE lang = :lang ORDER BY name DESC";
        
        $query = $this->db->prepare($sql);
        $query->execute(array(":lang" => $lang));
        return $query->fetchAll();
    }

    public function orderASC() {
        
        $sql = "SELECT * FROM " . $this->table_name." ORDER BY name DESC";
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }



    function listing($lang) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :lang AND active = 1 ORDER BY name ASC";
        $query = $this->db->prepare($sql);
        $query->execute(array(":lang" => $lang));
        return $query->fetchAll();
    }

    public function getLanguageByLang($language) {

        $execute    = array(":language" => $language);

        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :language" ;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }
}
?>