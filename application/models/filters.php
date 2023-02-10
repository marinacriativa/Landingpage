<?php 

/** 
*   Model filters 
* 
*   Extends: core/Model.php
*   Author: Vlad
* 
*   Insert, edit, delete extends from /application/core/model.php
**/

namespace Fyre\Model;

class filters extends \Fyre\Core\Model {

    public $table_name  = "filters"; 
    public $schema      = array (
                            "id",
                            "name",
                            "lang",
                            "is_multiple",                          
                            "order_by",                          
                        );


    /*  
    *   @OVERIDEs parents constructor, 
    *   because this model is called from application.php 
    *   before initialization 
    */

    public function single($id) {
        $execute = array(":id" => $id);


        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetch();
    }

    public function multiple($start = null, $limit = null, $search = null, $order = null) {


        $execute    = array();
        $query      = " ";
        $limiter    = "";
        $order_by   = "order_by";

        if ($limit !== null && $start !== null) {

            $limiter = " LIMIT " . $start . ", " . $limit;
        }

        if ($search != null) {

            $query              .= " WHERE (name LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";
        }

        if ($order != null) {

            if (in_array($order, $this->schema)) {

                $order_by = $order;
            }
        }

        $sql = "SELECT * FROM " . $this->table_name  . " " . $query . "ORDER BY " . $order_by . " ASC" . $limiter;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
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

        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE lang = :language " . $query;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchColumn();
    }

    public function listing($language) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = '" . $language ."' ORDER BY order_by ASC";

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function total_listing($language, $search) {

        $execute    = array(":language" => $language);
        $query      = "";

        if ($search != null) {

            $query              .= " AND (name LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";
        }

        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE lang = :language " . $query;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchColumn();
    }

    function random($gallery_id, $language, $limit = 5) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :lang AND id <> :id ORDER BY RAND() LIMIT " . $limit;

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

        $sql = "SELECT * FROM " . $this->table_name . " " . $query;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}