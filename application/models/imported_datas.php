<?php 

/** 
*   Model imported_datas 
* 
*   Extends: core/Model.php
*   Author: Vlad
**/

namespace Fyre\Model;

class imported_datas extends \Fyre\Core\Model {

    public $table_name  = "imported_datas"; 
    public $schema      = array (
                            "id",
                            "ref",
                            "name",
                            "brand",
                            "value"
                        );
    
    /*
        Insert, edit, delete extends from /application/core/model.php
    */

    public function single($ref) {
        
        $execute = array(":ref" => $ref);
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE ref = :ref";
        
        $query = $this->db->prepare($sql);
        $query->execute($execute);

        return $query->fetch();
    }
    
    public function multiple() {
        
        $sql = "SELECT * FROM " . $this->table_name . "";
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function search($text) {
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE ref LIKE '%" . $text . "%' OR name LIKE '%" . $text . "%' OR brand LIKE '%" . $text . "%' OR value LIKE '%" . $text . "%'";
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function listing() {

        $sql = "SELECT * FROM " . $this->table_name . "";
        $query = $this->db->prepare($sql);
        $query->execute(array());
        return $query->fetchAll();
    }

    function list($ids = null) {
      
        $str = '';
        
        if($ids != null) {
            foreach ($ids as $k => $item) {                
                if ($k != array_key_first($ids)) {                    
                    $str .= ', ' . $item['id'];
                } else {
                    $str .= '' . $item['id'];
                }
            }
        }
       
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id IN (". $str .")";
        $query = $this->db->prepare($sql);
        $query->execute(array());
        return $query->fetchAll();
    }

    function insert_all ($datas) {
        $sql = "INSERT INTO " . $this->table_name . " (ref, name, brand, value) VALUES " . $datas;

        $query = $this->db->prepare($sql);       
        return  $query->execute();
    }

    function delete_all () {
        $sql = "TRUNCATE TABLE " . $this->table_name . "";

        $query = $this->db->prepare($sql);       
        return  $query->execute();
    }


}
?>