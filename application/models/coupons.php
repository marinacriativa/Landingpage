<?php 

/** 
*   Model coupons 
* 
*   Extends: core/Model.php
*   Author: Vlad
* 
*   Insert, edit, delete extends from /application/core/model.php
**/

namespace Fyre\Model;

class coupons extends \Fyre\Core\Model {

    public $table_name  = "coupons"; 
    public $schema      = array (
                            "id",
                            "code",
                            "type",     
                            "start_date",
                            "end_date",
                            "discount",
                            "tags",
                            "first_purchase",
                            "apply_discount",
                            "customer_group",
                            "products_group",
                            "start_price",
                            "reused",
                            "description",
                            "active",
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

    public function singleByCode ($code, $isactive = "AND active = 1") {

        if($isactive != "AND active = 1") {
            $isactive = '';
        }

        $sql = "SELECT * FROM " . $this->table_name . " WHERE code = :code " . $isactive;

        $query = $this->db->prepare($sql);
        $query->execute(array(":code" => $code));
        return $query->fetch();
    }
    
    public function multiple($start = null, $limit = null, $search = null, $order = null) { 

        $query = '';
        $order_by = 'order_by';
        $limiter    = "";
        $orderType    = "ASC";

        if ($search != null) {
            
            $query              .= " WHERE (code LIKE '%" . $search . "%') ";

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
            
            $query              .= "WHERE code LIKE '%". $search ."%' ";
        
        }
        
        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " " . $query;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchColumn();
    }
    
}