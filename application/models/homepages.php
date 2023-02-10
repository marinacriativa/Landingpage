<?php 

/** 
*   Model homepages 
* 
*   Extends: core/Model.php
*   Author: Vlad
* 
*   Insert, edit, delete extends from /application/core/model.php
**/

namespace Fyre\Model;

class homepages extends \Fyre\Core\Model {

    public $table_name  = "homepages"; 
    public $schema      = array (
                            "id",
                            "name",     
                            "active",
                            "order_by",
                            "content",
                            "lang"
                        );


    /*  
    *   @OVERIDEs parents constructor, 
    *   because this model is called from application.php 
    *   before initialization 
    */

    public function single($id) { 

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));
        return $query->fetch();
    }

    public function multiple($lang) { 

        $order_by = 'order_by';
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = '" . $lang . "' ORDER BY " . $order_by . " ASC ";

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function listing($lang) { 

        $order_by = 'order_by';
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE active = 1 AND lang = '" . $lang . "' ORDER BY " . $order_by . " ASC ";

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

}