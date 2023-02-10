<?php 

/** 
*   Model jobs 
* 
*   Extends: core/Model.php
*   Author: Vlad
**/

namespace Fyre\Model;

class jobs extends \Fyre\Core\Model {

    public $table_name  = "jobs"; 
    public $schema      = array (
                            "id",
                            "name",
                            "description",
                            "price",
                            "period",
                            "status",
                            "urgency",
                            "experience",
                            "notes",
                            "location",
                            "photo_path",
                            "keywords",
                            "slug",
                            "featured",
                            "categories",
                            "language_group",
                            "lang",
                            "order_by",
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

    function getFeatured($language) {

        $execute    = array(":language" => $language);

        $sql = "SELECT * FROM " . $this->table_name  . " WHERE lang = :language AND featured = 1 ORDER BY id DESC";
        
        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    function getByPeriod($language, $period, $limit) {

        $execute    = array(":language" => $language);

        $sql = "SELECT * FROM " . $this->table_name  . " WHERE lang = :language AND period LIKE '". $period ."' ORDER BY id DESC LIMIT 0, " . $limit;
       
        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    public function getByCategory($category = null) {

        $status = "";
        $query      = "";

        if ($category != null) {       
            $query .= " WHERE FIND_IN_SET('$category', categories)";           
        }

        $sql = "SELECT  COUNT(*) FROM " . $this->table_name ." " . $query . "";
     
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchColumn();
    }

    public function changeStatus($datas){
        
        $sql = "UPDATE " . $this->table_name . " SET status = " . $datas['status'] . " WHERE id = "  . $datas['id'];
        $quary = $this->db->prepare($sql);     
        if($quary->execute() == true) {
            return true;
        }
        return false;
    }

    public function getRelated($language_group, $id) {

        // Vamos buscar as noticias que têm o mesmo grupo
        $sql = "SELECT id, lang, status FROM " . $this->table_name . " WHERE language_group = :language_group AND id <> :id";
        
        $query = $this->db->prepare($sql);
        $query->execute(array(":language_group" => $language_group, ":id" => $id));
        return $query->fetchAll();
    }

    public function all() {
        
        $sql = "SELECT * FROM " . $this->table_name."";
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }  

    public function multiple($language, $start = null, $limit = null, $search = null, $order = null, $category = null) {
        
        $execute    = array(":language" => $language);
        $query      = " ";
        $limiter    = "";
        $order_by   = "order_by";
        $up_or_down = "ASC";
        
        if ($limit !== null && $start !== null) {
            
            $limiter = " LIMIT " . $start . ", " . $limit;
        }
        
        if ($search != null) {
            
            $query              .= " AND (name LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";
        }

        if ($category != null) {
            $query              .= " AND FIND_IN_SET(:category, categories) ";
            $execute[":category"]  =  $category;
        }
        
        if ($order != null) {
            
            if (in_array($order, $this->schema)) {
                
                $order_by = $order;
                if($order_by == 'name') {
                    $up_or_down = "ASC";
                }
            }
        }
        
        $sql = "SELECT * FROM " . $this->table_name  . " WHERE lang = :language " . $query . "ORDER BY " . $order_by . " ". $up_or_down ." " . $limiter;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }
    
    public function total($language, $search = null, $category = null) {
        
        $execute    = array(":language" => $language);
        $query      = "";

        if ($category != null) {
            $query              .= " AND FIND_IN_SET(:category, categories) ";
            $execute[":category"]  =  $category;
        }
        
        if ($search != null) {
            
            $query              .= " AND (name LIKE :search) ";
            $execute[":search"]  = $search;
        }
        
        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE lang = :language " . $query;
        
        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchColumn();
    }   



    public function listing($language = null, $start = null, $limit = null, $search = null, $order = null, $status = '', $category = null) { 

        $execute = array("language" => $language);
        $query      = "";
        $up_or_down = "ASC";
        $limiter    = "";
        $order_by   = "order_by";

        if ($limit !== null && $start !== null) {
            
            $limiter = " LIMIT " . $start . ", " . $limit;
        }

        if ($search != null) {

            $query              .= " AND (name LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";

        }

        if ($status != '') {
            $status = " AND (status = 0 OR status = 1)";
        }

        if ($category != null) {
            $query              .= " AND FIND_IN_SET(:category, categories) ";
            $execute[":category"]  =  $category;
        }

        if ($order != null) {

            if (in_array($order, $this->schema)) {

                $order_by = $order;
                switch ($order_by) {
                    case 'name':
                        $up_or_down = "ASC";
                        break;
                    
                    default:
                        $up_or_down = "DESC";
                        break;
                }
            }
        }
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :language ". $status ." ". $query ." ORDER BY " . $order_by . " ". $up_or_down ." " . $limiter;
        
        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    public function total_listing($language, $search, $min_status = 0, $category = null) {
        
        $execute    = array(":language" => $language);
        $query      = "";

        if ($category != null) {
            $query              .= " AND FIND_IN_SET(:category, categories) ";
            $execute[":category"]  =  $category;
        }
        
        if ($search != null) {
            
            $query              .= " AND (name LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";
        }

        switch ($min_status) {

            case 0:
                $status = " AND (status = 0 OR status = 1) ";
                break;
            
            case 1: 
                $status = " AND status = 1 ";
                break;
        }
        
        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE lang = :language " . $query . $status;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchColumn();
    }

    public function getLanguageByLang($language) {

        $execute    = array(":language" => $language);

        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :language AND root = 1" ;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }
}
?>