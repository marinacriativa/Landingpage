<?php 

/** 
*   Model galleries 
* 
*   Extends: core/Model.php
*   Author: Vlad
* 
*   Insert, edit, delete extends from /application/core/model.php
**/

namespace Fyre\Model;

class advanced_galleries extends \Fyre\Core\Model {

    public $table_name  = "galleries_advanced";
    public $schema      = array (
                            "id",
                            "id_gallery",
                            "name",
                            "stock",
                            "current_price",
                            "gallery",
                        );


    public function single($id) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));


        return $query->fetch();
    }

    public function advancedGalleriesByGallery($idGallery){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id_gallery = :id_gallery";
        $query = $this->db->prepare($sql);
        $query->execute(array(":id_gallery" => $idGallery));

        return $query->fetchAll();
    }
}
