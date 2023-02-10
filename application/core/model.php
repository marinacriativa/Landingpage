<?php

namespace Fyre\Core;

class Model {
    
    // Database connection
    public $db;

    function __construct() {
        
        global $app;
        
        // Init database connection
        $this->db = $app->databaseConnection();
    }
    
    public function insert($data, $ignore = "") {
        
        global $app;
        
        if (empty($data)) {
            
            return array("message" => "FALHA NO DATA", "success" => false);
        }
        
        $data = $this->cleanSchema($data);

        foreach ($data as $key => $value) {
	
            if (empty($value) && $value != 0) {
                
                unset($data[$key]);
            }
        }
        
        $columns    = "";
        $values     = "";
        $execute    = array();
        
        // SQL builder
        foreach ($data as $key => $value) {
            
            $columns            .= $key . ", ";
            $values             .= ":" . $key . ", ";
            $execute[":" . $key] = $value;
        }
        
        $columns = rtrim($columns, ", ");
        $values  = rtrim($values, ", ");
        
        $sql = "INSERT " . $ignore . " INTO " . $this->table_name . " (" . $columns . ") VALUE (" . $values . ")";
        
        return $this->execute($sql, $execute, true);
    }
    
    public function remove($id) {
        
        $execute        = array();
        $execute["id"]  = $id;
        
        $sql = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        
        return $this->execute($sql, $execute);
    }

    public function removeSelected($ids) {

        $query = array();
        
        foreach ($ids as $id) {
            
            $id = intval($id);
            $query[] = " id = " . $id . " ";
        }
        
        $query = "WHERE (" . implode(" OR ", $query) . ") ";        
        
        $sql = "DELETE FROM " . $this->table_name . " " . $query;      
       
        $query = $this->db->prepare($sql);

        if($query->execute() == true) {
            return $query->execute();
        }

        return false;
    }
    
    public function edit($data) {
        
        global $app;
        
        if (empty($data)) {
            
            return array("message" => $app->translations["common"]["sql_empty_data"], "success" => false);
        }
        
        if (!isset($data["id"])) {
            
            return array("message" => $app->translations["common"]["sql_edit_no_id"], "success" => false);
        }

        $data = $this->cleanSchema($data);

        foreach ($data as $key => $value) {
	
            if (empty($value) && $value != 0) {

                unset($data[$key]);
            }
        }
        
        $set     = "";
        $execute = array(":id" => $data["id"]);
        unset($data["id"]);
        
        // SQL builder
        foreach ($data as $key => $value) {
            
            $set                .= "`" . $key . "` = :" . $key . ", ";
            $execute[":" . $key] = $value;
        }

        $set   = rtrim($set, ", ");
        $sql = "UPDATE " . $this->table_name . " SET " . $set . " WHERE id = :id";
        return $this->execute($sql, $execute);
    }
    
    function datatable($columns, $WHERE = "", $execute = array()) {
        
        global $app;
        
        header('Content-Type: application/json');
	
    	// Require do model com funções para o plugin DataTables
    	require APP . 'library/datatable.php';
    	
    	$table = new \Fyre\Library\Datatable($columns, $_POST);
    	
    	$data  = $table->setDatabaseConnection($app->databaseConnection())
    				   ->setTable($this->table_name)
    				   ->setWhereCondition($WHERE, $execute)
    				   ->execute();
    	
    	echo $table->output($data); 
    }
    
    public function order($ids) {
        
        global $app;
        
        if (!in_array("order_by", $this->schema)) {
            
            return array("success" => false, "message" => $app->translations["common"]["sql_order_not_set"]);
        }
        
        if (empty($ids)) {
            return array("success" => false, "message" => $app->translations["common"]["sql_order_not_set"]);
        }
        
        $sql = "";
        $ids = explode(",", $ids);
        
        foreach ($ids as $key => $id) {
            
            $sql .= "UPDATE " . $this->table_name . " SET `order_by` = " . $key . " WHERE id = " . $id . ";";
        }
        
        return $this->execute($sql, array());
    }
    
    private function cleanSchema($data) {
        
        // Delete all columns that do not belong to this table schema
        foreach ($data as $key => $value) {
            
            if (!in_array($key, $this->schema)) {
                
                $data[$key] = null;
                unset($data[$key]);
            }
        }
        
        return $data;
    }
    
    public function execute($sql, $execute = array(), $return_id = false) {
        
        global $app;
        
        $query = $this->db->prepare($sql);
        
        if ($query->execute($execute)) {
            
            if ($return_id) {
                
                return array("success" => true, "data" => $this->db->lastInsertId());
            }
            
            return array("success" => true);
            
        } else {
            
            if (ENVIRONMENT == "dev") {
                
                return array("success" => false, "message" => "BOA");
                
            } else {
                
                return array("success" => false, "message" => "ERRO SQL");
            }
        }
    }
}