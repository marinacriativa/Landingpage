<?php 

/** 
*   Model documents 
* 
*   Extends: core/Model.php
*   Author: Vlad
**/

namespace Fyre\Model;

class documents extends \Fyre\Core\Model {

    public $table_name  = "documents"; 
    public $schema      = array (
                            "id",
                            "name",
                            "lang",
                            "url",
                            "draft",
                            "status",
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

    public function getDraft(){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE draft = 1";

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }
    
    public function url ($url) {
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE url = :url";
        
        $query = $this->db->prepare($sql);
        $query->execute(array(":url" => $url));
        return $query->fetch();
    }

    public function multiple($start = null, $limit = null, $search = null, $order = null, $min_status = 0) { 
        
        $status = "";

        switch ($min_status) {

            case 1:
                $status = " AND (status = 1 OR status = 2) ";
                break;
            
            case 2: 
                $status = " AND status = 2 ";
                break;
        }

        $query = '';
        $order_by = 'id';
        $limiter    = "";
        $up_or_down = "DESC";

        if ($search != null) {
            
            $query              .= " WHERE (name LIKE '%" . $search . "%') ";

        }

        if ($order != null) {
            
            if (in_array($order, $this->schema)) {
                
                $order_by = $order;
                if($order_by == 'name') {
                    $up_or_down = "ASC";
                }
            }
        }

        if ($limit !== null && $start !== null) {
            
            $limiter = " LIMIT " . $start . ", " . $limit;
        }
        
        $sql = "SELECT * FROM " . $this->table_name . " " . $query . " ORDER BY " . $order_by . " ".  $up_or_down ." " . $limiter;

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
    
    function listing($search = null, $lang = 'pt') {
        $query = '';
        if ($search != null) {
            
            $query              .= " AND (name LIKE '%" . $search . "%') ";

        }

        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :lang ". $query;
        $query = $this->db->prepare($sql);
        $query->execute(array(":lang" => $lang));
        return $query->fetchAll();
    }

    public function listingAll($start = null, $limit = null, $search = null, $order = null, $status = '') {

        $execute = array();
        $query      = "";
        $limiter    = "";

        if ($limit !== null && $start !== null) {
            
            $limiter = " LIMIT " . $start . ", " . $limit;
        }

        if ($search != null) {       
            $query              .= " AND (name LIKE :search) OR (url LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";
        }
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE status = 2 ". $query ." " . $limiter;
        
        $query = $this->db->prepare($sql);
        $query->execute($execute);      
        return $query->fetchAll();
    }

    public function getLanguageByLang($language) {

        $execute    = array(":language" => $language);

        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :language AND root = 1" ;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    public function changeStatus($datas){
        
        $sql = "UPDATE " . $this->table_name . " SET status = " . $datas['status'] . " WHERE id = "  . $datas['id'];
        $quary = $this->db->prepare($sql);     
        if($quary->execute() == true) {
            return true;
        }
        return false;
    }
}
?>