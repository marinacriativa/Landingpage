<?php 

namespace Fyre\Model;

class orderStatus extends \Fyre\Core\Model {

    public $table_name  = "order_status";
    public $schema      = array (
                            "id",
                            "name",
                            "email",
                            "lang",
                            "predefined"
                        );

    public function multiple() {

        $sql = "SELECT * FROM " . $this->table_name;

        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function byLang($lang) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE lang = :lang";

        $query = $this->db->prepare($sql);
        $query->execute(array(":lang" => $lang));

        return $query->fetchAll();
    }

    public function single($id) {
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        
        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $id));

        return $query->fetch();
    }
}
?>