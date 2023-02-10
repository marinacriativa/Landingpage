<?php 

/** 
*   Model historic_imported_datas 
* 
*   Extends: core/Model.php
*   Author: Vlad
**/

namespace Fyre\Model;

class historic_imported_datas extends \Fyre\Core\Model {

    public $table_name  = "historic_imported_datas"; 
    public $schema      = array (
                            "id",
                            "user",
                            "name",
                            "data"
                        );
    
    /*
        Insert, edit, delete extends from /application/core/model.php
    */

    public function single($id) {
        
        $execute = array(":id" => $id);
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        
        $query = $this->db->prepare($sql);
        $query->execute($execute);

        return $query->fetch();
    }
    
    public function multiple() {
        
        $sql = "SELECT * FROM " . $this->table_name . "";
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function listing() {

        $sql = "SELECT * FROM " . $this->table_name . "";
        $query = $this->db->prepare($sql);
        $query->execute(array());
        return $query->fetchAll();
    }

}
?>