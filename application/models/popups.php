<?php 

/** 
*   Model popups 
* 
*   Extends: core/Model.php
*   Author: Vlad
**/

namespace Fyre\Model;

class popups extends \Fyre\Core\Model {

    public $table_name  = "popup"; 
    public $schema      = array (
                            "id",
                            "photo",
                            "details",
                            "youtube",
                            "active",
                            "name",
                            "start_date",
                            "end_date",
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
        
        $sql = "SELECT * FROM " . $this->table_name;
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function listing($parent = null) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE active = 1";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function total($language, $search = null) {       

        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " ";

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchColumn();
    }
}
?>