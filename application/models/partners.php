<?php 

/** 
*   Model partners 
* 
*   Extends: core/Model.php
*   Author: Vlad
* 
*   Insert, edit, delete extends from /application/core/model.php
**/

namespace Fyre\Model;

class partners extends \Fyre\Core\Model {

    public $table_name  = "partners"; 
    public $schema      = array (
                            "id",
                            "url",
                            "path",     
                            "order_by",
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

    public function multiple($start = null, $limit = null, $search = null, $order = null) { 

        $query = '';
        $order_by = 'order_by';
        $limiter    = "";
        $orderType    = "ASC";

        if ($search != null) {
            
            $query              .= " WHERE (name LIKE '%" . $search . "%') ";

        }

        if ($order != null) {
            
            if (in_array($order, $this->schema)) {
                
                $order_by = $order;
                if($order_by == 'id') 
                    $orderType = 'DESC';
            }
        }

        if ($limit !== null && $start !== null) {
            
            $limiter = " LIMIT " . $start . ", " . $limit;
        }
        
        $sql = "SELECT * FROM " . $this->table_name . " " . $query . " ORDER BY " . $order_by . " ". $orderType ." " . $limiter;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function total($search = null) {
        
        $query      = "";

        if ($search != null) {
            
            $query              .= "WHERE name LIKE '%". $search ."%' ";
        
        }
        
        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " " . $query;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchColumn();
    }

    public function ordenation ($i, $id) {       

        $sql = "UPDATE " . $this->table_name . " SET order_by = ".$i." WHERE id = ".$id."";
        
        $query = $this->db->prepare($sql);
        
        return $query->execute();
    }
    
    public function listing() {        
        
        $sql = "SELECT * FROM " . $this->table_name . " ORDER BY order_by ASC";
       
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }


}