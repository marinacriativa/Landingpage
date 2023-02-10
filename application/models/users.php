<?php

/**
 *   Model users
 *
 *   Extends: core/Model.php
 *   Author: Vlad
 *
 *   Insert, edit, delete extends from /application/core/model.php
 **/

namespace Fyre\Model;

class users extends \Fyre\Core\Model
{

    public $table_name = "users";
    public $sessions_table_name = "sessions";
    public $schema = array(
        "id",
        "type",
        "email",
        "password",
        "photo_path",
        "name",
        "phone",
        "nif",
        "address",
        "address2",
        "city",
        "country",
        "zipCode",
        "isactive",
        "notification_new_client",
        "notification_new_order",
        "notification_new_ticket",
        "notification_new_contact",
        "notification_empty_stock",
        "can_be_selected_contact_form",
        "dt",
        "customer_group",
        "draft",
        "role"
    );

    


    public function multipleClient($language, $start = null, $limit = null, $search = null, $order = null)
    {

        $execute = array(":language" => $language);
        $query = "";
        $limiter = "";
        $order_by = "id";

        if ($limit !== null && $start !== null) {

            $limiter = " LIMIT " . $start . ", " . $limit;
        }

        if ($search != null) {

            $query .= " AND (name LIKE :search OR email LIKE :search ) ";
            $execute[":search"] = "%" . $search . "%";
        }

        if ($order != null) {

            if (in_array($order, $this->schema)) {

                $order_by = $order;
            }
        }

        $sql = "SELECT * FROM " . $this->table_name . " WHERE type = 0  " . $query . "ORDER BY " . $order_by . " DESC" . $limiter;

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

    public function multiple($language, $start = null, $limit = null, $search = null, $order = null, $type = null)
    {

        $execute = array();
        $query = "";
        $limiter = "";
        $order_by = "id";

        if ($limit !== null && $start !== null) {

            $limiter = " LIMIT " . $start . ", " . $limit;
        }

        
        if ($type != null) {

            $query .= " AND (type = :type) ";
            $execute[":type"] =  $type;
        }

        if ($search != null) {

            $query .= " AND (name LIKE :search OR email LIKE :search OR phone LIKE :search OR city LIKE :search) ";
            $execute[":search"] = "%" . $search . "%";
        }

        if ($order != null) {

            if (in_array($order, $this->schema)) {

                $order_by = $order;
            }
        }

        $sql = "SELECT * FROM " . $this->table_name . " WHERE 1 = 1  " . $query . "ORDER BY " . $order_by . " DESC" . $limiter;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    public function single($id) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));

        $sqlSessions = "SELECT * FROM " . $this->sessions_table_name . " WHERE uid = :id ";
        $querySessions = $this->db->prepare($sqlSessions);
        $querySessions->execute(array(":id" => $id));

        $sessions_data = $querySessions->fetchAll();
        $client_data = $query->fetch();
        return (object) ['client_data' => $client_data, 'sessions_data' => $sessions_data];
    }

    function getEmailsForNotifications($type) {

        $sql = "SELECT email FROM " . $this->table_name . " WHERE " . $type . " = 1";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_COLUMN, 0);
    }

    function getAdmins() {

        $sql = "SELECT id FROM " . $this->table_name . " WHERE type = 2";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_COLUMN, 0);
    }

    function totalClients() {

        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE type = 0 ";

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchColumn();
    }


    function total() {

        $sql = "SELECT COUNT(*) FROM " . $this->table_name;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchColumn();
    }

    public function getGroup($id, $group) {       
        $query      = "";       

        if ($group != null) {

            $query                  .= "  AND FIND_IN_SET('". $group ."', customer_group) ";       
        }

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = ". $id ." " . $query;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }
}

?>