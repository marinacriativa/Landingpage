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

class historic extends \Fyre\Core\Model {

    public $table_name  = "historic";
    public $schema = array(
        "id",
        "idOrder",
        "status",
        "date"

    );

    public function single($id) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));
        return $query->fetch();
    }
}
