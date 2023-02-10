<?php 

/** 
*   Model testimonies 
* 
*   Extends: core/Model.php
*   Author: Vlad
**/

namespace Fyre\Model;

class testimonies extends \Fyre\Core\Model {

    public $table_name  = "testimonies"; 
    public $schema      = array (
                            "id",
                            "name",
                            "job",
                            "description",
                            "url",
                            "lang",
                            "draft",
                            "status",
                            "language_group",
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

    public function ordenation ($i, $id) {       

        $sql = "UPDATE " . $this->table_name . " SET order_by = ".$i." WHERE id = ".$id."";
        
        $query = $this->db->prepare($sql);
        
        return $query->execute();
    }

    function singleSlug($id, $min_status = 0, $lang = false) {

        $execute = array(":slug" => $id);

        $status = "";

        switch ($min_status) {

            case 1:
                $status = " AND (status = 1 OR status = 2) ";
                break;
            
            case 2: 
                $status = " AND status = 2 ";
                break;
        }
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE slug = :slug" . $status . " AND active = 1";
        
        $query = $this->db->prepare($sql);
        $query->execute($execute);
        $res = $query->fetch();

        if($lang != false) {
            if($res->lang != $lang) {
                $another_lang = $this->getSingleRelated($res->language_group, $res->id, $lang);
                if(!empty($another_lang) && $another_lang != null) {
                    $res = $another_lang;
                }
            }
        }
        
        return $res;
    }

    function all($min_status = 0) {
        
        $execute    = array();
        
        $status = "";
        
        switch ($min_status) {
            
            case 1:
                $status = " AND (status = 1 OR status = 2) ";
                break;
                
                case 2: 
                    $status = " AND status = 2 ";
                    break;
                }
                
        $sql = "SELECT * FROM " . $this->table_name . " WHERE active = 1" . $status;
                

        $query = $this->db->prepare($sql);
        $query->execute($execute);

        return $query->fetchAll();
    }
    
    public function url ($url) {
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE url = :url";
        
        $query = $this->db->prepare($sql);
        $query->execute(array(":url" => $url));
        return $query->fetch();
    }

    public function multiple($language, $start = null, $limit = null, $search = null, $order = null) {
        
        $execute    = array();
        $query      = " ";
        $limiter    = "";
        $order_by   = "id";
        $up_or_down = "DESC";

        if ($limit !== null && $start !== null) {
            
            $limiter = " LIMIT " . $start . ", " . $limit;
        }
        
        if ($search != null) {
            
            $query              .= " AND (name LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";
        }
        
        if ($order != null) {
            
            if (in_array($order, $this->schema)) {
                
                $order_by = $order;
                if($order_by == 'name') {
                    $up_or_down = "ASC";
                }
            }
        }
        
        $sql = "SELECT * FROM " . $this->table_name  . " WHERE draft = 0 " . $query . "ORDER BY " . $order_by . " ". $up_or_down ." " . $limiter;
        
        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    function listing($parent = null, $lang = 'pt') {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :lang ORDER BY order_by ASC";
        $query = $this->db->prepare($sql);
        $query->execute(array(":lang" => $lang));
        return $query->fetchAll();
    }

    public function getDraft(){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE draft = 1";

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
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

    /*public function softDelete($id) {

        $sql = "UPDATE " . $this->table_name . " SET active = 0 WHERE id = :id";

        $query = $this->db->prepare($sql);
        if($query->execute(array(":id" => $id)) == true){
            return true;
        }
        return false;
    } */
}
?>