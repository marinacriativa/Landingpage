<?php 

/** 
*   Model news 
* 
*   Extends: core/Model.php
*   Author: Vlad
* 
*   Insert, edit, delete extends from /application/core/model.php
**/

namespace Fyre\Model;

class news extends \Fyre\Core\Model {

    public $table_name  = "news"; 
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
                            "language_group",
                            "resume",
                            "categories",
                            "order_by",
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

    function getFeatured($language) {

        $execute    = array(":language" => $language);

        $sql = "SELECT * FROM " . $this->table_name  . " WHERE lang = :language AND featured = 1 AND (status = 1 OR status = 2) ORDER BY id DESC";
        
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
            
            $query              .= " AND (title LIKE :search OR date LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";
        }

        if ($category != null) {
            $query              .= " AND FIND_IN_SET(:category, categories) ";
            $execute[":category"]  =  $category;
        }
        
        if ($order != null) {
            
            if (in_array($order, $this->schema)) {
                
                $order_by = $order;
                if($order_by == 'title') {
                    $up_or_down = "ASC";
                }
            }
        }
        
        $sql = "SELECT * FROM " . $this->table_name  . " WHERE draft = 0 AND lang = :language " . $query . "ORDER BY " . $order_by . " ". $up_or_down ." " . $limiter;

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
            
            $query              .= " AND (title LIKE :search OR date LIKE :search) ";
            $execute[":search"]  = $search;
        }
        
        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE draft = 0 AND lang = :language " . $query;
        
        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchColumn();
    }    

    function all($min_status = 0, $lang = null) {
        
        $execute    = array();
        
        $status = "";
        $lg = "";
        $where = "";
        
        switch ($min_status) {
            
            case 1:
                $status = " AND (status = 1 OR status = 2) ";
                $where =  "WHERE";
                break;
                
            case 2: 
                $status = " AND status = 2 ";
                $where = "WHERE";
                break;
        }

        if($lang != null) {
            $v = '';
            if($min_status == 0) {
                $v = 'AND';
            }
            $lg =  $v . " lang = '". $lang ."'";
            $where = "WHERE";
        }
                
        $sql = "SELECT * FROM " . $this->table_name . " ". $where ." ". $lg . "" . $status;


        $query = $this->db->prepare($sql);
        $query->execute($execute);

        return $query->fetchAll();
    }

    public function getAllRelated($language_group, $id){
        //Vamos buscar os produtos que tem o mesmo grupo
        $sql = "SELECT * FROM " . $this->table_name . " WHERE language_group = :language_group AND status = 2 AND id <> :id";

        $quary = $this->db->prepare($sql);
        $quary->execute(array(":language_group" => $language_group, ":id" => $id));
        return $quary->fetchAll();
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

            $query              .= " AND (title LIKE :search OR text LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";

        }

        if ($status != '') {
            $status = " AND (status = 1 OR status = 2)";
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

    public function listingAll($language = null, $start = null, $limit = null, $search = null, $order = null, $status = '') {

        $execute = array("language" => $language);
        $query      = "";
        $limiter    = "";

        if ($limit !== null && $start !== null) {
            
            $limiter = " LIMIT " . $start . ", " . $limit;
        }

        if ($search != null) {       
            $query              .= " AND (title LIKE :search OR text LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";

        }

        if ($status != '') {
            $status = " AND (status = 1 OR status = 2)";
        }        
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :language AND draft = 0 ". $status ." ". $query ." " . $limiter;
        
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
            
            $query              .= " AND (title LIKE :search OR text LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";
        }

        switch ($min_status) {

            case 1:
                $status = " AND (status = 1 OR status = 2) ";
                break;
            
            case 2: 
                $status = " AND status = 2 ";
                break;
        }
        
        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE lang = :language AND draft = 0  " . $query . $status;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchColumn();
    }
}
