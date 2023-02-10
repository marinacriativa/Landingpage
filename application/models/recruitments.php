<?php 

/** 
*   Model recruitments 
* 
*   Extends: core/Model.php
*   Author: Vlad
* 
*   Insert, edit, delete extends from /application/core/model.php
**/

namespace Fyre\Model;

class recruitments extends \Fyre\Core\Model {

    public $table_name  = "recruitment"; 
    public $schema      = array (
                            "id",
                            "title",
                            "date",
                            "text",
                            "youtube",
                            "lang",
                            "photo_path",
                            "slug",
                            "status",
                            "keywords",
                            "draft",
                            "featured",
                            "language_group"
                        );
                        
    /*  
    *   @OVERIDEs parents constructor, 
    *   because this model is called from application.php 
    *   before initialization 
    */
    
    public function single($id, $lang = false) {
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id OR slug = :id";
        
        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));
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

    public function getSingleRelated($language_group, $id, $lang){
        //Vamos buscar as noticias que tem o mesmo grupo
        $sql = "SELECT * FROM " . $this->table_name . " WHERE language_group = :language_group AND lang = '". $lang ."' AND id <> :id";

        $quary = $this->db->prepare($sql);
        $quary->execute(array(":language_group" => $language_group, ":id" => $id));
        return $quary->fetch();
    }

    public function getDraft() {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE draft = 1";
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    function getFeatured($language) {

        $execute    = array(":language" => $language);

        $sql = "SELECT * FROM " . $this->table_name  . " WHERE lang = :language AND featured = 1 ORDER BY id DESC";
        
        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    public function multiple($language, $start = null, $limit = null, $search = null, $order = null) {
        
        $execute    = array(":language" => $language);
        $query      = " ";
        $limiter    = "";
        $order_by   = "id";
        
        if ($limit !== null && $start !== null) {
            
            $limiter = " LIMIT " . $start . ", " . $limit;
        }
        
        if ($search != null) {
            
            $query              .= " AND (title LIKE :search OR date LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";
        }
        
        if ($order != null) {
            
            if (in_array($order, $this->schema)) {
                
                $order_by = $order;
            }
        }
        
        $sql = "SELECT * FROM " . $this->table_name  . " WHERE draft = 0 AND lang = :language " . $query . "ORDER BY " . $order_by . " DESC" . $limiter;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }
    
    public function total($language, $search = null) {
        
        $execute    = array(":language" => $language);
        $query      = "";
        
        if ($search != null) {
            
            $query              .= " AND (title LIKE :search OR date LIKE :search) ";
            $execute[":search"]  = $search;
        }
        
        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE draft = 0 AND lang = :language " . $query;
        
        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchColumn();
    }

    function all($min_status = 0) {
        
        $execute    = array();
        
        $status = "";
        
        switch ($min_status) {
            
            case 1:
                $status = " WHERE (status = 1 OR status = 2) ";
                break;
                
                case 2: 
                    $status = " WHERE status = 2 ";
                    break;
                }
                
        $sql = "SELECT * FROM " . $this->table_name . "" . $status;
                

        $query = $this->db->prepare($sql);
        $query->execute($execute);

        return $query->fetchAll();
    }
    
    public function listing($language, $start, $limit) {

        $execute = array("language" => $language);

        if ($limit !== null && $start !== null) {
            
            $limiter = " LIMIT " . $start . ", " . $limit;
        }
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :language ORDER BY date DESC" . $limiter;
        
        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }
}
?>