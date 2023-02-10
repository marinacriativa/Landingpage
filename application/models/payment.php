<?php

/**
 *   Model payment
 *
 *   Extends: core/Model.php
 *   Author: Vlad
 *
 *   Insert, edit, delete extends from /application/core/model.php
 **/

namespace Fyre\Model;

class payment extends \Fyre\Core\Model {

    public $table_name  = "payment_gateways";
    public $schema = array(
        "id",
        "name",
        "active",
        "settings"
    );

    public function single($id) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));
        return $query->fetch();
    }

    public function multiple($only_active = null) {

        $query = "";

        if ($only_active !== null) {

            $query = " WHERE active = 1";
        }

        $sql = "SELECT * FROM " . $this->table_name . $query;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}
?>