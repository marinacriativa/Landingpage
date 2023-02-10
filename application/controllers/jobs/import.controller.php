<?php 

/** 
*   Controller import
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class import extends \Fyre\Core\Controller {

    function categories() {

        global $app;

        // Dependencies
        $this->dependencies(array("categories"), array());

        $options = array(\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $import_db = new \PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . "loja_standart1" . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options);
    
        $sql = "SELECT * FROM categories";
        $query = $import_db->prepare($sql);
        $query->execute();
        $categories = $query->fetchAll();

        $old = [];

        $sql = "SELECT * FROM subcategories";
        $query = $import_db->prepare($sql);
        $query->execute();
        $subcategories = $query->fetchAll();

        foreach ($categories as $category) {

            $status = $this->dependencies->categories->insert(array(
                "name" => $category->name,
                "lang" => "pt",
                "parent" => 1,
                "root" => "0"
            ));

            $old[$category->id] = $status['data'];

            $sql = "UPDATE categories SET new_id = :new_id WHERE id = :id";
            $query = $import_db->prepare($sql);
            $query->execute(array(":new_id" => $status["data"], ":id" => $category->id));
        }

        foreach ($subcategories as $category) {

            $status = $this->dependencies->categories->insert(array(
                "name" => $category->name,
                "lang" => "pt",
                "parent" => $old[$category->category_id],
                "root" => "0"
            ));

            $sql = "UPDATE subcategories SET new_id = :new_id WHERE id = :id";
            $query = $import_db->prepare($sql);
            $query->execute(array(":new_id" => $status["data"], ":id" => $category->id));
        }
    }

    function products() {

        global $app;

        // Dependencies
        $this->dependencies(array("categories", "products"), array());

        $options = array(\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $import_db = new \PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . "loja_standart1" . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options);
        
        $sql = "SELECT * FROM products";
        $query = $import_db->prepare($sql);
        $query->execute();
        $products = $query->fetchAll();

        foreach ($products as $product) {

            $categories = [];

            $sql = "SELECT new_id FROM categories WHERE id = :id";
            $query = $import_db->prepare($sql);
            $query->execute(array(":id" => $product->category_id));
            $result = $query->fetchColumn();

            if (!empty($result)) {

                $categories[] = $result;
            }

            $sql = "SELECT new_id FROM subcategories WHERE id = :id";
            $query = $import_db->prepare($sql);
            $query->execute(array(":id" => $product->subcategory_id));
            $result = $query->fetchColumn();

            if (!empty($result)) {

                $categories[] = $result;
            }

            $product->categories = implode(",", $categories);
            $product->photo = '/static/images/products/' . $product->photo;

            $product->language_group = md5(time() . "dedw");
            $product->stock = 99999;
            $product->lang = "pt";
            $product->active = "1";
            $product->status = "2";

            $this->dependencies->products->insert((array) $product);
        }
    }

    function productImages() {

        global $app;

        // Dependencies
        $this->dependencies(array("products", "products_gallery"), array());

        $products = $this->dependencies->products->multiple($app->default_language->code, 0, 600);

        foreach ($products as $product) {

            $this->dependencies->products_gallery->insert(array(
                
                "product_id"    => $product->id,
                "path"          => $product->photo,
                "name"          => str_replace("/static/images/products/", "", $product->photo),
                "size"          => filesize(ROOT . "public" . $product->photo)
            ));
        }
    }
}