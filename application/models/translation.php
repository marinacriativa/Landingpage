<?php 

/** 
*   Model translation 
* 
*   Extends: core/Model.php
*   Author: Vlad
* 
*   Insert, edit, delete extends from /application/core/model.php
**/

namespace Fyre\Model;

class translation extends \Fyre\Core\Model {

    public $table_name  = "translation"; 
    public $schema      = array (
                            "id",
                            "code",
                            "name",
                            "author",
                            "currency",
                            "phpauth",
                            "active",
                            "default_state1",
                            "default_state2",
                            "default_state3",
                        );
                        
    /*  
    *   @OVERIDEs parents constructor, 
    *   because this model is called from application.php 
    *   before initialization 
    */
    
    function __construct($db = null) {
        
        global $app;
        
        $this->db = ($db == null) ? $app->databaseConnection() : $db;
    }
    
    public function multiple() {
        
        $sql = "SELECT * FROM " . $this->table_name;
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function single($id) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));

        return $query->fetch();
    }

    public function singleByCode($code) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE code = :code";

        $query = $this->db->prepare($sql);
        $query->execute(array(":code" => $code));

        return $query->fetch();
    }
}
?>