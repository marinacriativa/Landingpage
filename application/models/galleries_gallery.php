<?php

/**
 *   Model galleries_gallery
 *
 *   Extends: core/Model.php
 *   Author: Vlad
 *
 *   Insert, edit, delete extends from /application/core/model.php
 **/

namespace Fyre\Model;

class galleries_gallery extends \Fyre\Core\Model {

    public $table_name  = "galleries_gallery";
    public $schema      = array (
        "id",
        "gallery_id",
        "path",
        "name",
        "size",
        "date",
        "order_key",
    );

    public function single($id) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));
        return $query->fetch();
    }

    public function multiple($gallery_id) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE gallery_id = :gallery_id ORDER BY order_key ASC";

        $query = $this->db->prepare($sql);
        $query->execute(array(":gallery_id" => $gallery_id));
        return $query->fetchAll();
    }

    public function order($ids) {

        if (empty($ids)) {

            return array("success" => false, "message" => "Empty data");
        }

        $sql = "";
        $ids = explode(",", $ids);

        foreach ($ids as $key => $id) {

            $sql .= "UPDATE " . $this->table_name . " SET `order_key` = " . $key . " WHERE id = " . $id . ";";
        }

        // Definir a foto principal na coluna photo do produto
        // Obter o caminho da foto
        $main_foto = $this->single($ids[0]);

        if (!empty($main_foto)) {

            $photo      = $main_foto->path;
            $gallery_id = $main_foto->gallery_id;

            $sql .= "UPDATE galleries SET `photo` = '" . $photo . "' WHERE id = " . $gallery_id . ";";
        }

        return $this->execute($sql, array());
    }
}
