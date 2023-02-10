<?php 

/** 
*   Model menus 
* 
*   Extends: core/Model.php
*   Author: Vlad
**/

namespace Fyre\Model;

class menus extends \Fyre\Core\Model {

    public $table_name  = "menu"; 
    public $schema      = array (
                            "id",
                            "name",
                            "lang",
                            "parent",
                            "root",
                            "url",
                            "newtab",
                            "type",
                            "order_by",
                            "icon",
                            "active",
                            "url_type",
                            "related_id",
                            "language_group",
                            "doc_or_page",
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

      
        $execute    = array(":language" => $lang);
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :language ORDER by order_by ASC";
  
        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    public function deleteAllByParent($id) {
        
        $sql = "DELETE FROM " . $this->table_name . " WHERE parent = ". $id ." ";

        $query = $this->db->prepare($sql);
                
        return $query->execute();
    }

    public function multipleByParent($parent) {
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE parent = ". $parent ."";
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function listing($parent = null, $lang) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :lang AND active = 1 ORDER by order_by ASC";
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
