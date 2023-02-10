<?php 

/** 
*   Model alerts 
* 
*   Extends: core/Model.php
*   Author: Vlad
**/

namespace Fyre\Model;

class alerts extends \Fyre\Core\Model {

    public $table_name  = "alerts"; 
    public $schema      = array (
                            "id",
                            "title",
                            "date",
                            "link",
                            "description",
                            "draft",
                            "status",
                            "active",
                            "date_end"
                        );
    
    /*
        Insert, edit, delete extends from /application/core/model.php
    */

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
    
    public function url ($url) {
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE url = :url";
        
        $query = $this->db->prepare($sql);
        $query->execute(array(":url" => $url));
        return $query->fetch();
    }

    public function multiple() {
        
        $sql = "SELECT * FROM " . $this->table_name;
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function listing($parent = null, $lang = 'pt') {

        $sql = "SELECT * FROM " . $this->table_name . "";
        $query = $this->db->prepare($sql);
        $query->execute(array());
        return $query->fetchAll();
    }

    public function getDraft(){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE draft = 1";

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    public function getLanguageByLang($language) {

        $execute    = array(":language" => $language);

        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :language AND root = 1" ;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    public function changeStatus($datas){
        
        $sql = "UPDATE " . $this->table_name . " SET status = " . $datas['status'] . " WHERE id = "  . $datas['id'];
        $quary = $this->db->prepare($sql);     
        if($quary->execute() == true) {
            return true;
        }
        return false;
    }
}
