<?php 

/** 
*   Model notifications
* 
*   Extends: core/Model.php
*   Author: Vlad
* 
*   Insert, edit, delete extends from /application/core/model.php
**/

namespace Fyre\Model;

class notifications extends \Fyre\Core\Model {

    public $table_name  = "notifications";
    public $schema      = array (
                            "id",
                            "id_user",
                            "type",
                            "identifier",
                            "date",
                            "link"

                        );
    public function single($id) {

        $this->edit(array("id" => $id, "seen" => 1));
        
        $sql = "SELECT * from " . $this->table_name . " WHERE id = :id";   
        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));
        
        return $query->fetch();
        
    }
    
    public function dashboard($limit) {

        $sql = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC LIMIT " . $limit;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public function multiple($id) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id_user = :id ORDER BY date DESC";
        
        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));
        return $query->fetchAll();
    }

    function total() {

        $sql = "SELECT COUNT(*) FROM " . $this->table_name;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchColumn();
    }
}
?>