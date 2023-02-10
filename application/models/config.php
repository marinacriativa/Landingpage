<?php 

/** 
*   Model config 
* 
*   Extends: core/Model.php
*   Author: Vlad
* 
*   Insert, edit, delete extends from /application/core/model.php
**/

namespace Fyre\Model;

class config extends \Fyre\Core\Model {

    public $table_name  = "config"; 
    public $schema      = array (
                            "setting",
                            "value"
                        );

    function __construct($db = null) {

        global $app;
        
        $this->db = ($db == null) ? $app->databaseConnection() : $db;
    }
    
    public function multiple() {
        
        $sql = "SELECT * FROM " . $this->table_name;

        $query = $this->db->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(\PDO::FETCH_UNIQUE);

        foreach ($results as $key => $config) {

            $results[$key] = $config->value;
        }

        return json_decode(json_encode($results));
    }
    
    public function edit_keys($key, $value) {
        
        $sql = "UPDATE " . $this->table_name . " SET value = :value WHERE setting = :setting";
        return $this->execute($sql, array(":setting" => $key, ":value" => $value));
    }
}
?>