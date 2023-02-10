<?php 

/** 
*   Model pages 
* 
*   Extends: core/Model.php
*   Author: Vlad
**/

namespace Fyre\Model;

class pages extends \Fyre\Core\Model {

    public $table_name  = "pages"; 
    public $schema      = array (
                            "id",
                            "name",
                            "lang",
                            "url",
                            "content",
                            "draft",
                            "status",
                            "language_group",
                            "keywords",
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

    public function getAllRelated($language_group, $id){
        //Vamos buscar os produtos que tem o mesmo grupo
        $sql = "SELECT * FROM " . $this->table_name . " WHERE language_group = :language_group AND status = 2 AND id <> :id";

        $quary = $this->db->prepare($sql);
        $quary->execute(array(":language_group" => $language_group, ":id" => $id));
        return $quary->fetchAll();
    }

    public function check_slug($id, $url) {       

        $all = $this->all();
        foreach ($all as $a) {
            if($a->url == $url && $a->id != $id) {
                return false;
                break;
            }
        }      
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        
        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));
        return $query->fetch();
    }
    
   /*  public function url ($url, $lang = false) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE url = :url";
        
        $query = $this->db->prepare($sql);
        $query->execute(array(":url" => $url));
        return $query->fetch();
    } */

    public function getSingleRelated($language_group, $id, $lang){
        //Vamos buscar as noticias que tem o mesmo grupo
        $sql = "SELECT * FROM " . $this->table_name . " WHERE language_group = :language_group AND lang = '". $lang ."' AND id <> :id";

        $quary = $this->db->prepare($sql);
        $quary->execute(array(":language_group" => $language_group, ":id" => $id));
        return $quary->fetch();
    }

    function url($url, $min_status = 0, $lang = false) {

        $execute = array(":url" => $url);

        $status = "";       
       

        switch ($min_status) {

            case 1:
                $status = " AND (status = 1 OR status = 2) ";
                break;
            
            case 2: 
                $status = " AND status = 2 ";
                break;
        }
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE url = :url" . $status . "";
        
        $query = $this->db->prepare($sql);
        $query->execute($execute);
        $res = $query->fetch();
        
        if($lang != false && $res != false) {
            if($res->lang != $lang) {
                $another_lang = $this->getSingleRelated($res->language_group, $res->id, $lang);
                if(!empty($another_lang) && $another_lang != null) {
                    $res = $another_lang;
                }
            }
        }
       
        return $res;
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

    public function multiple($language, $start = null, $limit = null, $search = null, $order = null) {
        
        $execute    = array(":language" => $language);
        $query      = " ";
        $limiter    = "";
        $order_by   = "id";
        $up_or_down   = "DESC";
        
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
                    $up_or_down   = "ASC";
                }
            }
        }
        
        $sql = "SELECT * FROM " . $this->table_name  . " WHERE draft = 0 AND lang = :language " . $query . "ORDER BY " . $order_by . " " . $up_or_down . "" . $limiter;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }
    
    public function total($language, $search = null) {
        
        $execute    = array(":language" => $language);
        $query      = "";
        
        if ($search != null) {       
            $query              .= " AND (name LIKE :search OR content LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";
        }
        
        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE draft = 0 AND lang = :language " . $query;
        
        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchColumn();
    }

    function listing($parent = null, $lang = 'pt') {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :lang";
        $query = $this->db->prepare($sql);
        $query->execute(array(":lang" => $lang));
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
            $query              .= " AND (name LIKE :search OR content LIKE :search) OR (url LIKE :search) ";
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

    public function getRelated($language_group, $id) {

        // Vamos buscar as noticias que têm o mesmo grupo
        $sql = "SELECT id, lang, status FROM " . $this->table_name . " WHERE language_group = :language_group AND id <> :id";
        
        $query = $this->db->prepare($sql);
        $query->execute(array(":language_group" => $language_group, ":id" => $id));
        return $query->fetchAll();
    }

    public function getDraft() {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE draft = 1";
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    public function getByIds($ids) {
        
        $query = array();
        
        foreach ($ids as $id) {
            
            $id = intval($id);
            $query[] = " id = " . $id . " ";
        }
        
        $query = "AND (" . implode(" OR ", $query) . ") ";
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE active = 1 " . $query;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}
?>