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

class shipping extends \Fyre\Core\Model {

    public $table_name  = "shipping";
    public $schema      = array (
        "id",
        "title",
        "subtitle",
        "price",
        "lang",
        "price_limit"
    );

    public function single($id) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));
        return $query->fetch();
    }

    public function multiple($language = null) {

        $query      = "";
        $execute    = array();

        if ($language != null) {
            
            $query              .= " WHERE lang = :lang ";
            $execute[":lang"]    = $language;
        }

        $sql = "SELECT * FROM " . $this->table_name . $query;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }
}
?>