<?php 

/** 
*   Model info_form 
* 
*   Extends: core/Model.php
*   Author: Vlad
* 
*   Insert, edit, delete extends from /application/core/model.php
**/

namespace Fyre\Model;

class info_form extends \Fyre\Core\Model {

    public $table_name  = "info_form"; 
    public $schema      = array (
                            "id",
                            "name",
                            "email",
                            "phone",
                            "custom_1",
                            "description",
                            "custom_2",
                            "custom_3",
                            "custom_4",
                            "custom_5",
                            "custom_6",
                            "custom_7",
                            "custom_8",
                            "custom_9",
                            "custom_10",
                            "custom_11",
                            "custom_12",
                        );
                        
    public function single($id) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

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

        $sql = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC" . $limiter;
        
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