<?php 

/** 
*   Model products 
* 
*   Extends: core/Model.php
*   Author: Vlad
* 
*   Insert, edit, delete extends from /application/core/model.php
**/

namespace Fyre\Model;

class products extends \Fyre\Core\Model {

    public $order_products_table_name  = "orders_products";
    public $table_name  = "products"; 
    public $discounts_table_name  = "discounts";
    public $attributes_table_name  = "attributes";
    public $products_advanced_table_name  = "products_advanced";
    public $schema      = array (
                            "id",
                            "sku",
                            "user_id",
                            "filters",
                            "categories",
                            "personalizationGroup",
                            "name",
                            "language_group",
                            "slug",
                            "photo",
                            "price",
                            "details",
                            "stock",
                            "policy",
                            "status",
                            "draft",
                            "views",
                            "product_condition",
                            "previous_price",
                            "ship",
                            "youtube",
                            "featured",
                            "create_at",
                            "update_at",
                            "is_discount",
                            "active",
                            "lang",
                            "group_id",
                            "keywords",
                            "labels",
                            "type",
                            "products_group",
                            "brands",
                            "doc_path",
                            "doc_active",
                            "weight",
                            "height",
                            "width",
                            "depth",
                            "youtube_active",
                            "price_request",
                            "year",
                            "label_color",
                            "short_description",
                            "gtin",
                            "mpn",
                            "main_brand",
                            "order_by",
                            "is_digital"
                        );

                        
    /*  
    *   @OVERIDEs parents constructor, 
    *   because this model is called from application.php 
    *   before initialization 
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

    public function listingAll () {
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE status = 2 AND active = 1";
        
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    function singleSlug($id, $min_status = 0, $lang = false) {

        $execute = array(":slug" => $id);

        $status = "";

        switch ($min_status) {

            case 1:
                $status = " AND (status = 1 OR status = 2) ";
                break;
            
            case 2: 
                $status = " AND status = 2 ";
                break;
        }
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE slug = :slug" . $status . " AND active = 1";
        
        $query = $this->db->prepare($sql);
        $query->execute($execute);
        $res = $query->fetch();
        
        if($lang != false && $res != false) {
            if($res->lang != $lang) {
                $another_lang = $this->getSingleRelated($res->language_group, $res->id, $lang);                
                if(!empty($another_lang) && $another_lang != null) {
                    $res = $another_lang;
                }
            }
        }
        
        return $res;
    }

    function all($min_status = 0, $lang = null) {
        
        $execute    = array();
        
        $status = "";
        $lg = "";
        
        switch ($min_status) {
            
            case 1:
                $status = " AND (status = 1 OR status = 2) ";
                break;
                
            case 2: 
                $status = " AND status = 2 ";
                break;
        }

        if($lang != null) {
            $lg = " AND lang = '". $lang ."'";
        }
                
        $sql = "SELECT * FROM " . $this->table_name . " WHERE active = 1". $lg . "" . $status;
  

        $query = $this->db->prepare($sql);
        $query->execute($execute);

        return $query->fetchAll();
    }

    public function advancedProductsByProduct($idProduct) {
        $sql = "SELECT * FROM " . $this->products_advanced_table_name . " WHERE id_product = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(":id" => $idProduct));

        return $query->fetchAll();
    }

    public function softDelete($id) {

        $sql = "UPDATE " . $this->table_name . " SET active = 0 WHERE id = :id";

        $query = $this->db->prepare($sql);
        if($query->execute(array(":id" => $id)) == true){
            $sqlDiscount = "DELETE FROM " . $this->discounts_table_name . " WHERE id_product = :id";
            $queryDiscount = $this->db->prepare($sqlDiscount);
            if($queryDiscount->execute(array(":id" => $id)) == true){
                $sqlAttribute = "DELETE FROM " . $this->attributes_table_name . " WHERE id_product = :id";
                $queryAttributes = $this->db->prepare($sqlAttribute);
                return $queryAttributes->execute(array(":id" => $id));
            }
            return false;
        };
        return false;
    }

    public function changeStatus($datas){
        
        $sql = "UPDATE " . $this->table_name . " SET status = " . $datas['status'] . " WHERE id = "  . $datas['id'];
        $quary = $this->db->prepare($sql);     
        if($quary->execute() == true) {
            return true;
        }
        return false;
    }

    public function getRelated($language_group, $id){
        //Vamos buscar os produtos que tem o mesmo grupo
        $sql = "SELECT id, lang, status FROM " . $this->table_name . " WHERE language_group = :language_group AND active = 1 AND id <> :id";

        $quary = $this->db->prepare($sql);
        $quary->execute(array(":language_group" => $language_group, ":id" => $id));
        return $quary->fetchAll();
    }

    public function getAllRelated($language_group, $id){
        //Vamos buscar os produtos que tem o mesmo grupo
        $sql = "SELECT * FROM " . $this->table_name . " WHERE language_group = :language_group AND status = 2 AND active = 1 AND id <> :id";

        $quary = $this->db->prepare($sql);
        $quary->execute(array(":language_group" => $language_group, ":id" => $id));
        return $quary->fetchAll();
    }

    public function getSingleRelated($language_group, $id, $lang){
        //Vamos buscar os produtos que tem o mesmo grupo
        $sql = "SELECT * FROM " . $this->table_name . " WHERE language_group = :language_group AND lang = '". $lang ."' AND id <> :id";       
        $quary = $this->db->prepare($sql);
        $quary->execute(array(":language_group" => $language_group, ":id" => $id));        
        return $quary->fetch();
    }

    public function getByCategory($category = null, $min_status = 0) {

        $status = "";
        $query      = "";

        switch ($min_status) {
            case 1:
                $status = " AND (status = 1 OR status = 2) ";
                break;
            
            case 2: 
                $status = " AND status = 2 ";
                break;
        }

        if ($category != null) {       
            $query .= " AND FIND_IN_SET('$category', categories)";           
        }

        $sql = "SELECT id FROM " . $this->table_name ." WHERE draft = 0 AND active = 1 " . $status . " " . $query . "";
     
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getByFilter($category = null, $min_status = 0) {

        $status = "";
        $query      = "";

        switch ($min_status) {
            case 1:
                $status = " AND (status = 1 OR status = 2) ";
                break;
            
            case 2: 
                $status = " AND status = 2 ";
                break;
        }

        if ($category != null) {       
            $query .= " AND FIND_IN_SET('$category', filters)";           
        }

        $sql = "SELECT id FROM " . $this->table_name ." WHERE draft = 0 AND active = 1 " . $status . " " . $query . "";
     
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function multiple($language, $start = null, $limit = null, $search = null, $order = null, $min_status = 0, $category = '') {
 
        $status = "";

        switch ($min_status) {

            case 1:
                $status = " AND (status = 1 OR status = 2) ";
                break;
            
            case 2: 
                $status = " AND status = 2 ";
                break;
        }
        
        $execute    = array(":language" => $language);
        $query      = " ";
        $limiter    = "";
        $order_by   = "order_by";
        $up_or_down = "ASC";
        
        if ($limit !== null && $start !== null) {
            
            $limiter = " LIMIT " . $start . ", " . $limit;
        }
        
        if ($search != null) {

            $query              .= " AND (name LIKE :search OR sku LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";

        }
        
        if ($order != null) {
            
            if (in_array($order, $this->schema)) {
                
                $order_by = $order;
                if($order_by == 'name') {
                    $up_or_down = "ASC";
                }
            }
        }

        if ($category != '') {       
            $query .= " AND FIND_IN_SET('$category', categories)";           
        }


        $sql = "SELECT * FROM " . $this->table_name ." WHERE draft = 0 AND active = 1 " . $status . " AND lang = :language" . $query . "ORDER BY " . $order_by . " ".  $up_or_down ." " . $limiter;
        
        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    function getAll() {

        $sql = "SELECT id FROM " . $this->table_name  . " ORDER BY order_by ASC LIMIT 0, 150";
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function getFeatured($language) {

        $execute    = array(":language" => $language);

        $sql = "SELECT * FROM " . $this->table_name  . " WHERE lang = :language AND featured = 1 AND active = 1 AND (status = 1 OR status = 2) ORDER BY id DESC";
        
        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchAll();
    }

    public function getDraft(){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE draft = 1";

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }
    
    public function dashboard($limit) {
        
        $sql = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC LIMIT " . $limit;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    
    public function total($language, $search = null, $category = '') {
        
        $execute    = array(":language" => $language);
        $query      = "";

        if ($search != null) {
            
            $query              .= " AND (name LIKE :search OR sku LIKE :search) ";
            $execute[":search"]  = $search;
        }

        if ($category != '') {       
            $query .= " AND FIND_IN_SET('$category', categories)";           
        }
        
        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE draft = 0 AND lang = :language AND active = 1 " . $query;

        $query = $this->db->prepare($sql);
        $query->execute($execute);
        
        return $query->fetchColumn();
    }

    public function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='bcdefghijklmnopqrstuvwxyz', ceil($length/strlen($x)) )),1,$length);
    }
    

    
    public function listing($language, $start, $limit, $search, $order, $min_status = 0, $category = null, $brand = null, $filters = null) {

        $execute    = array(":language" => $language);
        $query      = "";
        $limiter    = "";
        $order_by   = "products.order_by";
        $status     = "";
        $up_or_down = "ASC";
        $join = "";
        
        switch ($min_status) {

            case 1:
                $status = " AND (status = 1 OR status = 2) ";
                break;
            
            case 2: 
                $status = " AND status = 2 ";
                break;
        }

        if ($limit !== null && $start !== null) {

            $limiter = " LIMIT " . $start . ", " . $limit;
        }

        if ($search != null) {
            
            // Inner join brands
            $join  = ' LEFT JOIN brands ON FIND_IN_SET(brands.id, products.brands) ';
            $join .= ' LEFT JOIN categories ON FIND_IN_SET(categories.id, products.categories) ';    

            $query              .= " AND (products.name LIKE :search OR products.sku LIKE :search OR brands.name LIKE :search OR categories.name LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";

        }
        
        if ($category != null) {
            $cat_queries = "";            
            if(is_array($category)) {
                foreach($category as $k => $cat) {                
                    if(empty($cat) == false)
                    {
                        $cat_queries .= 'FIND_IN_SET('. $cat .', products.categories) ';                                      
                        if ($k != array_key_last($category)) 
                            $cat_queries .= 'AND ';
                    }
                }
                $query                  .= " AND ($cat_queries) ";
            } else {
                $query                  .= "  AND FIND_IN_SET(:category, products.categories) ";
                $execute[":category"]    = $category;
            }            
        }
        
        if ($filters != null) {
 
            foreach ($filters as $mainfilterKey => $filter) {

                $mainRandomKey = $this->generateRandomString(10);
 
                if ($filter['is_multiple']) {
                    
                    $subQuery = [];
 
                    foreach (explode(',', $filter['values']) as $key => $filterValue) {

                        $subRandomKey = $this->generateRandomString(10);
                        $subQuery[] = "FIND_IN_SET(:filter" . $key . "multiple" . $mainRandomKey . ", products.filters)";
                        $execute[':filter' . $key . 'multiple' . $mainRandomKey] = $filterValue;
                    }

                    $query .= " AND ( " . implode(' OR ', $subQuery) . " )";
 
                } else {
 
                    $query .= " AND ( FIND_IN_SET(:filter" . 'single' . "" . $mainRandomKey . ", products.filters) )";
                    $execute[':filter' . 'single' . '' . $mainRandomKey] = $filter['values'];
                }
            }
        }

      

        if ($brand != null) {
            $brand_queries = "";            
            if(is_array($brand)) {
                foreach($brand as $k => $b) {                
                    if(empty($b) == false)
                    {
                        $brand_queries .= 'FIND_IN_SET('. $b .', products.brands) ';                                      
                        if ($k != array_key_last($brand)) 
                            $brand_queries .= 'AND ';
                    }
                }
                $query                  .= " AND ($brand_queries) ";
            } else {
                $query                  .= "  AND FIND_IN_SET(:brand, products.brands) ";
                $execute[":brand"]    = $brand;
            }            
        }
       
        if ($order != null) {

            if (in_array($order, $this->schema)) {

                $order_by = 'products.' . $order;
                switch ($order_by) {
                    case 'products.name':
                        $up_or_down = "ASC";
                        break;
                    
                    default:
                        $up_or_down = "DESC";
                        break;
                }
            }
        }
        
        // se der erro no mysql por ter GROUP by é porque o servidor não permite o GROUP by (Refazer query, ou mudar o servidor)
        $sql = "SELECT products.* FROM " . $this->table_name . $join ." WHERE products.lang = :language AND products.active = 1 " . $status . $query . " GROUP BY products.id ORDER BY " . $order_by . " ". $up_or_down ." " . $limiter; 
        
        //var_dump($sql); 
        //var_dump($execute); die;
        $query = $this->db->prepare($sql);
        $query->execute($execute);
    
        return $query->fetchAll();
    }
    
    public function total_listing($language, $search, $min_status = 0, $category, $brand = null, $filters = null) {
        
        $execute    = array(":language" => $language);
        $query      = "";
        
        if ($search != null) {
            
            $query              .= " AND (name LIKE :search OR sku LIKE :search) ";
            $execute[":search"]  = "%" . $search . "%";
        }

        switch ($min_status) {

            case 1:
                $status = " AND (status = 1 OR status = 2) ";
                break;
            
            case 2: 
                $status = " AND status = 2 ";
                break;
        }

        if ($category != null) {
            $cat_queries = "";            
            if(is_array($category)) {
                foreach($category as $k => $cat) {                
                    if(empty($cat) == false)
                    {
                        $cat_queries .= 'FIND_IN_SET('. $cat .', categories) ';                                      
                        if ($k != array_key_last($category)) 
                            $cat_queries .= 'OR ';
                    }
                }
                $query                  .= " AND $cat_queries";
            } else {
                $query                  .= "  AND FIND_IN_SET(:category, categories) ";
                $execute[":category"]    = $category;
            }            
        }

        if ($filters != null) {
 
            foreach ($filters as $mainfilterKey => $filter) {

                $mainRandomKey = $this->generateRandomString(10);
 
                if ($filter['is_multiple']) {
                    
                    $subQuery = [];
 
                    foreach (explode(',', $filter['values']) as $key => $filterValue) {

                        $subRandomKey = $this->generateRandomString(10);
                        $subQuery[] = "FIND_IN_SET(:filter" . $key . "multiple" . $mainRandomKey . ", products.filters)";
                        $execute[':filter' . $key . 'multiple' . $mainRandomKey] = $filterValue;
                    }

                    $query .= " AND ( " . implode(' OR ', $subQuery) . " )";
 
                } else {
 
                    $query .= " AND ( FIND_IN_SET(:filter" . 'single' . "" . $mainRandomKey . ", products.filters) )";
                    $execute[':filter' . 'single' . '' . $mainRandomKey] = $filter['values'];
                }
            }
        }

        if ($brand != null) {
            $brand_queries = "";            
            if(is_array($brand)) {
                foreach($brand as $k => $b) {                                   
                    if(empty($b) == false)
                    {
                        $brand_queries .= 'FIND_IN_SET('. $b['values'] .', brands) ';                                      
                        if ($k != array_key_last($brand)) 
                            $brand_queries .= 'OR ';
                    }
                }
                $query                  .= " AND $brand_queries";
            } else {
                $query                  .= "  AND FIND_IN_SET(:brand, brands) ";
                $execute[":brand"]    = $brand;
            }            
        }
        
        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE lang = :language AND active = 1  " . $query . $status;
     
        $query = $this->db->prepare($sql);
        $query->execute($execute);
        return $query->fetchColumn();
    }

    function random($product_id, $language, $limit = 5) {

        $sql = "SELECT * FROM " . $this->table_name . " WHERE active = 1 AND status = 2 AND draft = 0 AND lang = :lang AND id <> :id LIMIT " . $limit;

        $query = $this->db->prepare($sql);
     
        $query->execute(array(":id" => $product_id, ":lang" => $language));

        
        return $query->fetchAll();
    }
    
    public function getByIds($ids) {
        
        $query = array();
        
        foreach ($ids as $id) {
            
            $id = intval($id);
            $query[] = " id = " . $id . " ";
        }
        
        $query = "AND (" . implode(" OR ", $query) . ") ";
        
        $sql = "SELECT * FROM " . $this->table_name . " WHERE active = 1 " . $query;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }



    public function countByFilter($id) {


        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE filters LIKE '%".$id."%' AND status = 2 AND active = 1";

        $query = $this->db->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }


    public function softDeleteMultiple($ids) {

        $query = array();
        $queryDiscount = array();
        $queryAttributes = array();
        
        foreach ($ids as $id) {
            
            $id = intval($id);
            $query[] = " id = " . $id . " ";
            $queryDiscount[] = " id_product = " . $id . " ";
            $queryAttributes[] = " id_product = " . $id . " ";
        }
        
        $query = "WHERE (" . implode(" OR ", $query) . ") ";        
        $queryDiscount = "WHERE (" . implode(" OR ", $queryDiscount) . ") ";
        $queryAttributes = "WHERE (" . implode(" OR ", $queryAttributes) . ") ";
        
        $sql = "UPDATE " . $this->table_name . " SET active = 0 " . $query;      
        $query = $this->db->prepare($sql);
        if($query->execute() == true) {
            $sqlDiscount = "DELETE FROM " . $this->discounts_table_name . " " . $queryDiscount;       
            $queryDiscount = $this->db->prepare($sqlDiscount);
            if($queryDiscount->execute() == true){
                $sqlAttribute = "DELETE FROM " . $this->attributes_table_name . " " . $queryAttributes;
                $queryAttributes = $this->db->prepare($sqlAttribute);
                return $queryAttributes->execute();
            }
        }

        return false;
    }

    public function getGroup($id, $group) {       
        $query      = "";       

        if ($group != null) {

            $query                  .= "  AND FIND_IN_SET('". $group ."', products_group) ";       
        }

        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = ". $id ." " . $query;

        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }
}
?>