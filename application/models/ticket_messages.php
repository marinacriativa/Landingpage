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

class ticket_messages extends \Fyre\Core\Model {

    public $table_name  = "ticket_messages";
    public $schema      = array (
        "id",
        "id_ticket",
        "id_sender",
        "message",
    );

    public function single($id) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));
        return $query->fetch();
    }


    public function getMessagesByTicket($language, $start = null, $limit = null, $search = null, $order = null, $id) {

        $execute    = array(":id" => $id);
        $query      = "";
        $limiter    = "";
        $order_by   = "id";

        if ($limit !== null && $start !== null) {

            $limiter = " LIMIT " . $start . ", " . $limit;
        }

        if ($search != null) {

            $query              .= " AND (ticket_number LIKE :search OR subject LIKE :search OR status LIKE :search OR create_date LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";
        }

        if ($order != null) {

            if (in_array($order, $this->schema)) {

                $order_by = $order;
            }
        }
        if($language != null){
            $query              .= " AND (ticket_number LIKE :search OR subject LIKE :search OR status LIKE :search OR create_date LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";
        }

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id_ticket = $id  " . $query . "ORDER BY " . $order_by . " ASC" . $limiter;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    function total() {

        $sql = "SELECT COUNT(*) FROM " . $this->table_name;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchColumn();
    }
}
?>