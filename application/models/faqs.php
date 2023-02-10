<?php 

namespace Fyre\Model;

class faqs extends \Fyre\Core\Model {

    public $table_name  = "faqs";
    public $schema      = array (
                            "id",
                            "title",
                            "details",
                            "status",
                            "lang"
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