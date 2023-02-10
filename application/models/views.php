<?php

/**
 *   Model views
 *
 *   Extends: core/Model.php
 *   Author: Vlad
 *
 *   Insert, edit, delete extends from /application/core/model.php
 **/

namespace Fyre\Model;

class views extends \Fyre\Core\Model {

    public $table_name  = "views";
    public $schema      = array (
        "id",
        "hashed_ip",
        "date_visited",
    );

    public function getMonthlyVisits() {

        $sql = "SELECT COUNT(date_visited) as count, DAY(date_visited) as day FROM views WHERE MONTH(date_visited) = MONTH(CURRENT_DATE()) AND YEAR(date_visited) = YEAR(CURRENT_DATE()) GROUP BY date_visited ORDER BY date_visited ASC";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function getMonthlySales() {

        $sql = "SELECT COUNT(id) as count, DAY(created_at) as day FROM orders WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) GROUP BY DAY(created_at) ORDER BY created_at ASC";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
}
?>