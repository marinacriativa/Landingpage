<?php

/**
 *   Model banners
 *
 *   Extends: core/Model.php
 *   Author: Vlad
 *
 *   Insert, edit, delete extends from /application/core/model.php
 **/

namespace Fyre\Model;

class banners extends \Fyre\Core\Model {

    public $table_name  = "banners";
    public $schema      = array (
            "id",
            "photo",
            "link",
            "title",
            "align",
            "subtitle",
            "description",
            "button_text",
            "lang",
            "color",
            "video",
            "is_active_btn_txt",
            "order_by",
            "active"
    );

    public function ordenation ($i, $id) {
        
        $sql = "UPDATE " . $this->table_name . " SET order_by = ".$i." WHERE id = ".$id."";
        
        $query = $this->db->prepare($sql);
        
        return $query->execute();
    }

    public function single($id) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));
        return $query->fetch();
    }

    public function total($search = null) {
        
        $query      = "";

        if ($search != null) {
            
            $query              .= "WHERE title LIKE '%". $search ."%' ";
        
        }
        
        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " " . $query;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchColumn();
    }

    public function multiple($language = null, $start = null, $limit = null, $search = null, $order = null) { 

        $query = '';
        $order_by = 'order_by';
        $limiter    = "";
        $orderType = 'ASC';

        if ($search != null) {
            
            $query              .= " WHERE (title LIKE '%" . $search . "%') ";

        }

        if ($language !== null) {
            $tex = 'WHERE';
            if($search != null) {
                $tex = 'AND';
            }
            $query              .= " ". $tex ." lang = '" . $language . "'";
            
        }

        if ($order != null) {
            
            if (in_array($order, $this->schema)) {
                
                $order_by = $order;
                if($order_by == 'title') 
                    $orderType = 'ASC';
            }
        }

        if ($limit !== null && $start !== null) {
            
            $limiter = " LIMIT " . $start . ", " . $limit;
        }
        
        $sql = "SELECT * FROM " . $this->table_name . "" . $query . " ORDER BY " . $order_by . " ". $orderType . " " . $limiter;
        
        $query = $this->db->prepare($sql);
        
        $query->execute();
        return $query->fetchAll();
    }

    public function list ($language = null, $start = null, $limit = null, $search = null, $order = null) { 

        $query = '';
        $order_by = 'order_by';
        $limiter    = "";
        $orderType = 'ASC';

        if ($search != null) {
            
            $query              .= " WHERE (title LIKE '%" . $search . "%') ";

        }

        if ($language !== null) {
            $tex = 'WHERE';
            if($search != null) {
                $tex = 'AND';
            }
            $query              .= " ". $tex ." lang = '" . $language . "'";
            
        }

        if ($order != null) {
            
            if (in_array($order, $this->schema)) {
                
                $order_by = $order;
                if($order_by == 'title') 
                    $orderType = 'ASC';
            }
        }

        if ($limit !== null && $start !== null) {
            
            $limiter = " LIMIT " . $start . ", " . $limit;
        }
        
        $sql = "SELECT * FROM " . $this->table_name . "" . $query . " AND active = 1 ORDER BY " . $order_by . " ". $orderType . " " . $limiter;
        
        $query = $this->db->prepare($sql);
        
        $query->execute();
        return $query->fetchAll();
    }
}
?>