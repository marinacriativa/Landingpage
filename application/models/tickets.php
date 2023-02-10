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

class tickets extends \Fyre\Core\Model {

    public $table_name  = "tickets";
    public $messages_table_name  = "ticket_messages";
    public $schema      = array (
        "id",
        "user_id",
        "ticket_number",
        "subject",
        "message",
        "status",
        "create_data",
        "update_data",
        "isSupport"
    );

    public function single($id, $min_status = 0) {

        $execute = array(":id" => $id);

        $status = "";

        switch ($min_status) {

            case 1:
                $status = " AND (status = 1 OR status = 2) ";
                break;

            case 2: 
                $status = " AND status = 2 ";
                break;
        }

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id" . $status;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetch();
    }

    function randomTicketNumber() {

        $string = $this->random();

        // Vereficação para ver se nao repetimos o order number
        $sql   = "SELECT COUNT(id) FROM " . $this->table_name . " WHERE ticket_number = :ticket_number";
        $query = $this->db->prepare($sql);
        $query->execute(array(":ticket_number" => $string));

        $count = $query->fetchColumn();

        if ($count == 0) {

            return $string;
        }

        // Já existe um igual, vamos buscar outro
        return $this->randomOrderNumber();
    }

    function random($lenght = 6) {

        $charactersAlphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = array();

        for ($i = 0; $i <= $lenght; $i++) {

            $randstring[] = $charactersAlphabet[rand(0, strlen($charactersAlphabet))];
        }

        return "T-" . implode("", $randstring);
    }

    public function multiple($language, $start = null, $limit = null, $search = null, $order = null) {

        $execute    = array(":language" => $language);
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

        $sql = "SELECT * FROM " . $this->table_name . " WHERE 1 = 1  " . $query . "ORDER BY " . $order_by . " DESC" . $limiter;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    public function getDraft(){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE draft = 1";

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    public function byUser($idUser) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE user_id = :id";

        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $idUser));
        return $query->fetchAll();
    }

    public function getTicketsByClient($language, $start = null, $limit = null, $search = null, $order = null, $clientId) {

        $execute    = array(":language" => $language);
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

        $sql = "SELECT * FROM " . $this->table_name . " WHERE user_id = $clientId  " . $query . "ORDER BY " . $order_by . " DESC" . $limiter;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    public function removeAllMessagesByTicket($idTicket) {

        $sql = "DELETE FROM " . $this->messages_table_name . " WHERE id_ticket = :id";

        $query = $this->db->prepare($sql);
        return $query->execute(array(":id" => $idTicket));
    }

    function total() {

        $sql = "SELECT COUNT(*) FROM " . $this->table_name;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchColumn();
    }
}
?>