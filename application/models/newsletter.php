<?php

/** 
 *   Model newsletter 
 * 
 *   Extends: core/Model.php
 *   Author: Vlad
 * 
 *   Insert, edit, delete extends from /application/core/model.php
 **/

namespace Fyre\Model;

class newsletter extends \Fyre\Core\Model
{

    public $table_name  = "newsletter";
    public $schema      = array(
        "id",
        "name",
        "email",
        "ip",
        "date",
        "lang"
    );
    public function single($id) {

        $sql = "SELECT * from " . $this->table_name . " WHERE id = :id";   
        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));
        
        return $query->fetch();
        
    }
    public function dashboard($limit) {

        $sql = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC LIMIT " . $limit;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public function multiple($start = null, $limit = null) {

        $limiter    = "";

        if ($limit !== null && $start !== null) {

            $limiter = " LIMIT " . $start . ", " . $limit;
        }

        $sql = "SELECT * FROM " . $this->table_name . " ORDER BY date DESC" . $limiter;
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function newsletterByEmail($email) {

        $sql = "SELECT * from " . $this->table_name . " WHERE email = :email";
        $query = $this->db->prepare($sql);
        $query->execute(array(":email" => $email));

        return $query->fetch();
    }

    function total() {

        $sql = "SELECT COUNT(*) FROM " . $this->table_name;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchColumn();
    }
}