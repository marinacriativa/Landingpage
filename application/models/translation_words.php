<?php 

/** 
*   Model translation_words 
* 
*   Extends: core/Model.php
*   Author: Vlad
* 
*   Insert, edit, delete extends from /application/core/model.php
**/

namespace Fyre\Model;

class translation_words extends \Fyre\Core\Model {

    public $table_name  = "translation_words"; 
    public $schema      = array (
                            "id",
                            "translation_id",
                            "category",
                            "word_key",
                            "word"
                        );
                        
    /*  
    *   @OVERIDEs parents constructor, 
    *   because this model is called from application.php 
    *   before initialization 
    */

    public function single($word_key) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE word_key = :word_key";

        $query = $this->db->prepare($sql);
        $query->execute(array(":word_key" => $word_key));
        return $query->fetch();
    }
    
    function __construct($db = null) {
        
        global $app;
        
        $this->db = ($db == null) ? $app->databaseConnection() : $db;
    }
    
    public function edit_keys($key, $value, $language) {
        
        $sql = "UPDATE " . $this->table_name . " SET word = :word WHERE word_key = :key AND translation_id = :translation_id";
        $query = $this->db->prepare($sql);
        $query->execute(array(":translation_id" => $language, ":key" => $key, ":word" => $value));
    }
                        
    public function multiple($language) {
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE translation_id = :language";
        
        $query = $this->db->prepare($sql);
        $query->execute(array(":language" => $language));
        return $query->fetchAll();
    }
    
    public function translation_clone($original, $new) {
        
        $sql = 'CREATE TEMPORARY TABLE temporary_table AS SELECT * FROM `translation_words` WHERE `translation_id` = :original;
                UPDATE temporary_table SET `translation_id` = :new;
                ALTER TABLE temporary_table DROP `id`;
                INSERT INTO `translation_words` (translation_id, category, word_key, word) SELECT * FROM temporary_table;';

        $query = $this->db->prepare($sql);
        $query->execute(array(":original" => $original, ":new" => $new));
        
        return $query;
    }
    
    // @overide
    public function remove($id) {
        
        $execute        = array();
        $execute["id"]  = $id;
        
        $sql = "DELETE FROM " . $this->table_name . " WHERE translation_id = :id";
        
        return $this->execute($sql, $execute);
    }
}
?>