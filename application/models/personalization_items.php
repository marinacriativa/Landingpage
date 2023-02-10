<?php 

/** 
*   Model products 
* 
*   Extends: core/Model.php
*   Author: Vlad
* 
*   Insert, edit, delete extends from /application/core/model.php
**/

namespace Fyre\Model;

class personalization_items extends \Fyre\Core\Model {

    public $table_name  = "personalization_items";
    public $schema      = array (
                            "id",
                            "name",
                            "text",
                            "id_groups",
                            "ref",
                            "photo",
                            "ref",
                            "language_group",
                            "lang",
                            "draft",
                            "status"
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
    
    public function multiple($language, $start = null, $limit = null, $search = null, $order = null) {

        $execute    = array(":language" => $language);
        $query      = " ";
        $limiter    = "";
        $order_by   = "id";

        if ($limit !== null && $start !== null) {

            $limiter = " LIMIT " . $start . ", " . $limit;
        }

        if ($search != null) {

            $query              .= " AND (name LIKE :search OR ref LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";
        }

        if ($order != null) {

            if (in_array($order, $this->schema)) {

                $order_by = $order;
            }
        }

        $sql = "SELECT * FROM " . $this->table_name . " WHERE draft = 0 AND lang = :language" . $query . "ORDER BY " . $order_by . " DESC" . $limiter;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    public function total($language, $search = null) {

        $execute    = array(":language" => $language);
        $query      = "";

        if ($search != null) {

            $query              .= " AND (name LIKE :search OR ref LIKE :search) ";
            $execute[":search"]  = $search;
        }

        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE lang = :language " . $query;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
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
        $sql = "SELECT  id, lang, status FROM " . $this->table_name . " WHERE language_group = :language_group AND id <> :id";

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


}
?>