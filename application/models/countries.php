<?php

/**
 *   Model countries
 *
 *   Extends: core/Model.php
 *   Author: Vlad
 *
 *   Insert, edit, delete extends from /application/core/model.php
 **/

namespace Fyre\Model;

class countries extends \Fyre\Core\Model {

    public $table_name  = "countries";
    public $schema      = array (
            "id",
            "phone_code",
            "country_code",
            "country_name",
    );

    public function multiple() {

        $sql = "SELECT * FROM " . $this->table_name;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}
?>