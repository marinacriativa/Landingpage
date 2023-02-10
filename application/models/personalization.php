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

class personalization extends \Fyre\Core\Model {

    public $table_name  = "personalization";
    public $schema      = array (
                            "id",
                            "name",
                            "lang",
                            "parent",
                            "root"
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

    public function multiple() {

        $sql = "SELECT * FROM " . $this->table_name;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getAllIds($language, $start = null, $limit = null, $search = null, $order = null) {

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

        $sql = "SELECT id FROM " . $this->table_name . " WHERE lang = :language" . $query . "ORDER BY " . $order_by . " DESC" . $limiter;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    public function multipleByLanguage($language) {

        $execute    = array(":language" => $language);

        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :language AND root = 0" ;

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

    public function total($language, $search = null) {

        $execute    = array(":language" => $language);
        $query      = "";

        if ($search != null) {

            $query              .= " AND (name LIKE :search OR sku LIKE :search) ";
            $execute[":search"]  = $search;
        }

        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE lang = :language " . $query;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchColumn();
    }

    public function getRelated($id) {

        // Vamos buscar as noticias que têm o mesmo grupo
        $sql = "SELECT id FROM " . $this->table_name . " WHERE id <> :id";

        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));
        return $query->fetchAll();
    }

    // Obter os grupos de personalização do produto
    function productsPersonalization($groups) {

        $final = array();

        // Estas queries vao precisar de optimização, mas funciona bem assim por agora
        foreach ($groups as $group) {
            
            // Obter o nome do grupo
            $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

            $query = $this->db->prepare($sql);
            $query->execute(array(":id" => $group));
            $group = $query->fetch();
            
            // Obter os items do grupo
            $sql = "SELECT * FROM personalization_items WHERE FIND_IN_SET(:id_groups, replace(id_groups, ' ', ','))";

            $query = $this->db->prepare($sql);
            $query->execute(array(":id_groups" => $group->id));
            $group->items = $query->fetchAll();

            $final[] = $group;
        }

        return $final;
    }
}
?>