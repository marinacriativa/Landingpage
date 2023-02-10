<?php 

/** 
*   Model contacts 
* 
*   Extends: core/Model.php
*   Author: Vlad
* 
*   Insert, edit, delete extends from /application/core/model.php
**/

namespace Fyre\Model;

class contacts extends \Fyre\Core\Model {

    public $table_name  = "contacts"; 
    public $schema      = array (
                            "id",
                            "seen",
                            "name",
                            "surname",
                            "contact",
                            "email",
                            "subject",
                            "description",
                            "date"
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
    
    public function multiple($start = null, $limit = null) {

        $limiter    = "";

        if ($limit !== null && $start !== null) {

            $limiter = " LIMIT " . $start . ", " . $limit;
        }

        $sql = "SELECT * FROM " . $this->table_name . " ORDER BY date DESC" . $limiter;
        
        $query = $this->db->prepare($sql);
        $query->execute();
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