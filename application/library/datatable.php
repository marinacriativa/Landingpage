<?php 

/** 
* Library Datatables 
*
* Library criada para não usar o código PHP dos Tabatables
* Author: Vlad
* 
**/

namespace Fyre\Library;

class Datatable {
	
	private $columns;
	public  $db;
	private $table;
	private $whereCondition;
	private $executeArray;
	private $subQuery;
	private $request;
	private $columns_modifier;
	private $columns_modifier_other_vars;
	
	function __construct($columns, $request, $columns_modifier = "") {
		
		global $app;
		
		if (empty($columns)) {
			
			$this->fatal($app->translations["common"]["datatable_missing_columns"]);
		}
		
		if (empty($request)) {
			
			$this->fatal($app->translations["common"]["datatable_no_connection"]);
		}
		
		if(!isset($request["order"])) {
			
			$this->fatal($app->translations["common"]["datatable_no_connection"]);
		}
		
		if (!empty($columns_modifier)) {
			
			if (isset($columns_modifier["other_variables"])) {
				
				$this->columns_modifier_other_vars = $columns_modifier["other_variables"];
				unset($columns_modifier["other_variables"]);
			}
			
			$this->columns_modifier = $columns_modifier;
			
		}
		
		$this->columns			= $columns;
		$this->request			= $request;
	}
	
	public function output($data) {
		
		return json_encode(array(
			"draw"            => isset ( $this->request['draw'] ) ? intval( $this->request['draw'] ) : 0,
			"recordsTotal"    => intval( $this->getTotal() ),
			"recordsFiltered" => $this->getTotal(true),
			"data"            => $this->data_output( $this->columns, $data )
		));
	}
	
	private function getTotal($filtred = false) {
		
		if ($filtred) {
			
			return $this->total_cache;
		}

		$where   = " " . $this->whereCondition;
		$execute = $this->executeArray;
				
		$sql = "SELECT COUNT(" . $this->getColumnNameFromRequestID(0) . ") FROM " . $this->table . $where;
		
		$query = $this->db->prepare($sql);
		$query->execute($execute);
    	$this->total_cache = $query->fetchColumn();
    	
    	return $this->total_cache;
    	
	}
	
	public function setTable($table) {
		
		$this->table = $table;
		
		return $this;
	}
	
	public function setWhereCondition($sql = "", $binding = array()) {
		
		// SQL example: username LIKE %:username%
		
		if (!empty($sql)) {
			
			$this->whereCondition = "WHERE " . $sql . " ";
		}
		
		// $binding = array(":column_name" => "value", ":column_name2" => "value");
		$this->executeArray = $binding;
		
		return $this;
	}
	
	public function addJoin($join) {
		
		if (!empty($join)) {

			$this->whereCondition = $join . $this->whereCondition;
		}
		
		return $this;
	}
	
	public function execute() {
		
		$sql = $this->buildSqlQuery();
		
		$query = $this->db->prepare($sql);
		$query->execute($this->executeArray);
    	$data = $query->fetchAll();

		return $data;
	}
	
	private function buildSqlQuery() {
		
		// From request, add search parameteres if they exist
		$this->addSearchParameters();
		
		return "SELECT " . $this->getColumnNamesForQuery() . $this->subQuery . " FROM " . $this->table . " " . $this->whereCondition . $this->orderByParameters() . $this->limit();
	}
	
	public function setSubquery($subQuery) {
		
		$this->subQuery .= $subQuery;
		
		return $this;
	}
	
	private function orderByParameters() {
		
		// Get columns name
		$column = $this->getColumnNameFromRequestID($this->request["order"][0]["column"]);
		return " ORDER BY " . $column  . " " . $this->request["order"][0]["dir"];
	}
	
	private function addSearchParameters() {
		
		if (!empty($this->request["search"]["value"])) {

			if (empty($this->whereCondition)) {
				
				$this->whereCondition = " WHERE " . $this->buildSearchQuery();
				
			} else {
				
				$this->whereCondition .= " AND " . $this->buildSearchQuery();
			}			
		}
	}
	
	private function buildSearchQuery() {
		
		$sql = "(";
		
		if (!empty($this->columns)) {
			
			foreach ($this->columns as $key => $column) {
				

				if (strpos($column, '*') !== false) {
					continue;
				}
				
				$sql .= $column . " LIKE :search_binding OR ";
			}
			
			$this->executeArray[":search_binding"] = "%" . $this->request["search"]["value"] . "%";
			
			$sql = rtrim($sql, " OR ");
			$sql .= ")";
		}
		
		return $sql;
	}
	
	private function limit() {
		
		$limit = '';

		if (isset($this->request['start']) && $this->request['length'] != -1) {
			
			$limit = " LIMIT " . intval($this->request['start']) . ", " . intval($this->request['length']);
		}

		return $limit;
	}
	
	private function getColumnNamesForQuery() {
		
		$columns = $this->columns;
		
		foreach ($columns as $key => $column) {
			
			if (strpos($column, '*') !== false) {
				
				$this->columns[$key] = str_replace("*", "", $column);
				unset($columns[$key]);
			}
		}
		
		return implode(", ", $columns);
	}
	
	private function getColumnNameFromRequestID($column_id) {
		
		return $this->columns[$column_id];
	}
	
	
	private function data_output( $columns_raw, $data ) {
		
		$columns_flipped = array_flip($columns_raw);
		$columns = array();
		
		foreach ($columns_flipped as $column_flipped => $value) {
			
			$new_key = explode(".", $column_flipped); 
			
			$columns[$new_key[1]] = $value;
		}
		
		$output = array();

		foreach ($data as $row) {
			
			foreach ($row as $key => $column_item) {
				
				$output_array[$columns[$key]] = $column_item;
			}
			
			$output[] = $output_array;
		}
		
		if (!empty($this->columns_modifier)) {
			
			return $this->modify_columns($columns, $output);
		}
		
		return $output;
	}
	
	private function modify_columns($columns, $output) {
		
		$columns = array_flip($columns);
		
		foreach ($output as $key_column => $output_column) {
		
			foreach ($this->columns_modifier as $key => $column_modifier) {
				
				$output[$key_column][$key] = $column_modifier($columns[$key], $output[$key_column][$key], $this->columns_modifier_other_vars);
			}
		}
			
		return $output;
	}
	
	public function setDatabaseConnection($db) {
		
		if (!empty($db)) {
			
			$this->db = $db;
			return $this;	
		}
		
		$this->fatal($app->translations["common"]["sql_conection_invalid"]);
	}
	
	private function fatal($message) {
		
		echo json_encode(array("success" => false, "message" => $message));
		exit();
	}
}