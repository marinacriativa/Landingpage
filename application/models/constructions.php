<?php 

/** 
*   Model constructions 
* 
*   Extends: core/Model.php
*   Author: Vlad
* 
*   Insert, edit, delete extends from /application/core/model.php
**/

namespace Fyre\Model;

class constructions extends \Fyre\Core\Model {

    public $table_name  = "constructions"; 
    public $attributes_table_name  = "attributes_constructions";
    public $schema      = array (
                            "id",
                            "name",
                            "language_group",
                            "slug",
                            "photo",                          
                            "details",
                            "policy",
                            "status",
                            "views",
                            "tags",
                            "youtube",                          
                            "keywords",                          
                            "featured",
                            "create_at",
                            "update_at",
                            "lang",
                            "active",
                            "draft",
                            "service",
                            "categories",
                            "order_by",
                            "youtube_active",
                            "duration"
                        );


    /*  
    *   @OVERIDEs parents constructor, 
    *   because this model is called from application.php 
    *   before initialization 
    */

    public function single($id, $min_status = 0) {
        $execute = array(":id" => $id);

        $status = "";

        switch ($min_status) {

            case 1:
                $status = " AND (status = 1 OR status = 2) ";
                break;

            case 2: 
                $status = " AND status = 2 ";
                break;
        }

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id" . $status;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetch();
    }

    public function getServices($language, $min_status = 0, $service = null) {

        $execute    = array(":language" => $language);
        $query      = "";

        switch ($min_status) {

            case 1:
                $status = " AND (status = 1 OR status = 2) ";
                break;

            case 2: 
                $status = " AND status = 2 ";
                break;
        }


        if ($service != null) {
            $service = intval($service);

            $query                  .= "  AND FIND_IN_SET(:service, service) ";
            $execute[":service"]    = $service;
        }


        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :language AND active = 1 " . $status . $query . " ORDER BY order_by ASC";

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    function singleSlug($id, $min_status = 0) {

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

        $sql = "SELECT * FROM " . $this->table_name . " WHERE slug = :slug" . $status;

        $query = $this->db->prepare($sql);
        $query->execute($execute);

        return $query->fetch();
    }

    /* public function advancedGalleriesByGallery($idGallery) {
        $sql = "SELECT * FROM " . $this->galleries_advanced_table_name . " WHERE id_gallery = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $idGallery));

        return $query->fetchAll();
    } */

    public function changeStatus($datas){
        
        $sql = "UPDATE " . $this->table_name . " SET status = " . $datas['status'] . " WHERE id = "  . $datas['id'];
        $quary = $this->db->prepare($sql);     
        if($quary->execute() == true) {
            return true;
        }
        return false;
    }

    public function getRelated($language_group, $id){
        //Vamos buscar as noticias que tem o mesmo grupo
        $sql = "SELECT id, lang, status FROM " . $this->table_name . " WHERE language_group = :language_group AND id <> :id";

        $quary = $this->db->prepare($sql);
        $quary->execute(array(":language_group" => $language_group, ":id" => $id));
        return $quary->fetchAll();
    }

    public function ordenation ($i, $id) {
        
        $sql = "UPDATE " . $this->table_name . " SET order_by = ".$i." WHERE id = ".$id."";
        
        $query = $this->db->prepare($sql);
        
        return $query->execute();
    }

    public function multiple($language, $start = null, $limit = null, $search = null, $order = null, $min_status = 0) {

        $status = "";

        switch ($min_status) {

            case 1:
                $status = " AND (status = 1 OR status = 2) ";
                break;

            case 2: 
                $status = " AND status = 2 ";
                break;
        }

        $execute    = array(":language" => $language);
        $query      = " ";
        $limiter    = "";
        $order_by   = "order_by";
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

        $sql = "SELECT * FROM " . $this->table_name  . " WHERE draft = 0 AND active = 1 " . $status . " AND lang = :language" . $query . "ORDER BY " . $order_by . " ".  $up_or_down ." " . $limiter;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    function getFeatured($language) {

        $execute    = array(":language" => $language);

        $sql = "SELECT * FROM " . $this->table_name  . " WHERE lang = :language AND featured = 1 AND active = 1 ORDER BY id DESC";

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    public function getDraft(){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE draft = 1";

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    public function dashboard($limit) {

        $sql = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC LIMIT " . $limit;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function total($language, $search = null) {

        $execute    = array(":language" => $language);
        $query      = "";

        if ($search != null) {

            $query              .= " AND (name LIKE :search) ";
            $execute[":search"]  = $search;
        }

        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE draft = 0 AND lang = :language " . $query;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchColumn();
    }

    public function listing($language, $start, $limit, $search, $order, $min_status = 0, $category = null) {

        $execute    = array(":language" => $language);
        $query      = "";
        $limiter    = "";
        $order_by   = "order_by";
        $status     = "";

        switch ($min_status) {

            case 1:
                $status = " AND (status = 1 OR status = 2) ";
                break;

            case 2: 
                $status = " AND status = 2 ";
                break;
        }

        if ($limit !== null && $start !== null) {

            $limiter = " LIMIT " . $start . ", " . $limit;
        }

        if ($search != null) {

            $query              .= "  AND (name LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";
        }

        if ($category != null) {
            $cat_queries = "";            
            if(is_array($category)) {
                foreach($category as $k => $cat) {                
                    if(empty($cat) == false)
                    {
                        $cat_queries .= 'FIND_IN_SET('. $cat .', categories) ';                                      
                        if ($k != array_key_last($category)) 
                            $cat_queries .= 'AND ';
                    }
                }
                $query                  .= " AND $cat_queries";
            } else {
                $query                  .= "  AND FIND_IN_SET(:category, categories) ";
                $execute[":category"]    = $category;
            }            
        }

        if ($order != null) {

            if (in_array($order, $this->schema)) {

                $order_by = $order;
            }
        }

        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :language AND active = 1 " . $status . $query . "ORDER BY " . $order_by . " DESC" . $limiter;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }
    

    public function total_listing($language, $search, $min_status = 0, $category) {

        $execute    = array(":language" => $language);
        $query      = "";

        if ($search != null) {

            $query              .= " AND (name LIKE :search) ";
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

        if ($category != null) {
            $cat_queries = "";            
            if(is_array($category)) {
                foreach($category as $k => $cat) {                
                    if(empty($cat) == false)
                    {
                        $cat_queries .= 'FIND_IN_SET('. $cat .', categories) ';                                      
                        if ($k != array_key_last($category)) 
                            $cat_queries .= 'OR ';
                    }
                }
                $query                  .= " AND $cat_queries";
            } else {
                $query                  .= "  AND FIND_IN_SET(:category, categories) ";
                $execute[":category"]    = $category;
            }            
        }

        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE lang = :language AND active = 1  " . $query . $status;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchColumn();
    }

    function random($gallery_id, $language, $limit = 5) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE active = 1 AND status = 2 AND draft = 0 AND lang = :lang AND id <> :id ORDER BY RAND() LIMIT " . $limit;

        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $gallery_id, ":lang" => $language));
        return $query->fetchAll();
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

    public function getByCategory($category = null, $min_status = 0) {

        $status = "";
        $query      = "";

        switch ($min_status) {
            case 1:
                $status = " AND (status = 1 OR status = 2) ";
                break;
            
            case 2: 
                $status = " AND status = 2 ";
                break;
        }

        if ($category != null) {       
            $query .= " AND FIND_IN_SET('$category', categories)";           
        }

        $sql = "SELECT id FROM " . $this->table_name ." WHERE draft = 0 AND active = 1 " . $status . " " . $query . "";
     
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}

