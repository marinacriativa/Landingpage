<?php

/**
*   Controller products ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;
use Jenssegers\Blade\Blade;

class products extends \Fyre\Core\Controller {

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("products", "categories"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 10;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "order_by";
        $category   = (isset($_GET["category"])) ? $_GET["category"] : '';
        $lang       = (isset($_GET["lang"]) && !empty($_GET["lang"])) ? $_GET["lang"] : $app->default_language->code;
        $start      = ($page - 1) * $limit;
      
        $categories = $this->dependencies->categories->listing(null,$lang);
        $products = $this->dependencies->products->multiple($lang, $start, $limit, $search, $order, 0, $category);        
        $total = $this->dependencies->products->total($lang, $search, $category);

        $pagination = array (
            "page" => (int) $page,
            "limit" => (int) $limit,
            "total" => (int) $total,
            "start" => (int) $start,
        );

        if (empty($products)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $datas = [
            $products, $pagination, $categories
        ];

        $this->response(true, "API REQUEST SUCCESS", $datas);
    }

    function ordenation_adv() {
    
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("advanced_products"));
        
        // Data handling
        $ids       = $_POST['ids'];   
        
        $status = $this->dependencies->advanced_products->order($ids);      

        $this->changeInfoFromMainProduct($_POST['id_product']);

        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function ordenation() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("products"));
        
        // Data handling
        $ids       = $_POST['ids'];  
        
        $status = $this->dependencies->products->order($ids);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }


    function index_featured() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("products"), array());

        $products = $this->dependencies->products->getFeatured($app->default_language->code);

        if (empty($products)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $products);
    }

    function single($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("products", "products_gallery", "brands"), array());

        // Product array
        $product = $this->dependencies->products->single($id);

        if (empty($product)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        //Obter outras linguas disponiveis no produto
        $product->related = $this->dependencies->products->getRelated($product->language_group, $product->id);

        // Obter as imagens
        $product->images  = $this->dependencies->products_gallery->multiple($product->id);    

        $this->response(true, "API REQUEST SUCCESS", $product);
    }

    /* function updateGoogleAPI () {
        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $client = new \Google\Client();
        $client->setAuthConfig(APP . 'config/service-account.json');
        $client->setApplicationName('Content API for Shopping');
        $client->setAccessType('offline');
        $client->addScope(\Google\Service\ShoppingContent::CONTENT);
        $client->setRedirectUri(URL);

        $datastore = new \Google\Service\Datastore($client);
     
         // Dependencies
         $this->dependencies(array("products"));

         //get all products
         $products = $this->dependencies->products->listingAll();

         $query = [];
        // build the query - this maps directly to the JSON
        foreach ($products as $product) {
            $query[] = new \Google\Service\Datastore\Query([
                'offerId' => $product->id,
                'title' => $product->name,
                'description' => $product->details,
                'link' => URL . $app->selected_language->code . $product->lang . '/' . $product->slug,
                'imageLink' => URL . $product->photo,
                'contentLanguage' => $product->lang,
                'targetCountry' => 'PT',
                'channel' => 'online',
                'availability' => $stock = ($product->stock > 0 && $product->stock < 9999999) ? 'Em estoque' : 'Indisponível no momento',
                'condition' => 'novo',
                'googleProductCategory' => '',
                'gtin' => '9780007350896',
                'price' => [
                    'value' => $product->price,
                    'currency' => 'EUR'
                ],
                'shipping' => [
                    'country' => 'PT',
                    'service' => 'Standard shipping',
                    'price' => [
                        'value' => '0.99',
                        'currency' => 'EUR'
                    ]
                ],
                'shippingWeight' => [
                    'value' => '200',
                    'unit' => 'grams'
                ]
            ]);
        }        

        // build the request and response
        $request = new \Google\Service\Datastore\RunQueryRequest(['query' => $query]);
        $response = $datastore->projects->runQuery('merchant-center-1655299055999', $request);
       

    } */

    function exportProducts () {
        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("products", "advanced_products", "products_gallery"));

        //get all products
        $products = $this->dependencies->products->listingAll();

        $array = [];

        foreach ($products as $product) {

            // Obter as imagens
            $gallery = $this->dependencies->products_gallery->multiple($product->id);

            //Obter Links das images
            $linksImages = $this->getImagesLinks($gallery);
            
            if($product->type == "1") {               
                $productsAdvanced = $this->dependencies->advanced_products->advancedProductsByProduct($product->id);
                foreach ($productsAdvanced as $productAdvanced) {
                    $imagesId = explode(",", $productAdvanced->gallery);

                    $filteredGallery = array_filter($gallery, function ($image) use ($imagesId) {
                        return in_array($image->id, $imagesId);
                    });

                    $productAdvanced->gallery = $filteredGallery;                    

                    //Obter Links das images do produto composto
                    $linksImagesAdvanced = $this->getImagesLinks($productAdvanced->gallery);

                    $productAdvanced->photo = $linksImagesAdvanced;
                    $productAdvanced->main_brand = $product->main_brand;
                    $productAdvanced->short_description = $product->short_description;
                    $productAdvanced->price = $productAdvanced->current_price;
                    $productAdvanced->lang = $product->lang;
                    $productAdvanced->slug = $product->slug;

                    if(isset($_GET['google'])) {
                        $productAdvanced->gtin = $product->gtin;
                        $productAdvanced->mpn = $product->mpn;
                        $array[] = $this->arrayToGoogle($productAdvanced);                
                    } else {            
                        $array[] = $this->arrayToFacebook($productAdvanced);
                    }            
                }
            } else {
                if(isset($_GET['google'])) {
                    $array[] = $this->arrayToGoogle($product, $linksImages);                
                } else {            
                    $array[] = $this->arrayToFacebook($product, $linksImages);
                }
            }            
        }

        
        if(isset($_GET['google'])) {
            $blade  = new Blade(APP . "templates/backoffice", APP . "templates/cache/");
            $datafeedRendered = $blade->render('layouts.datafeed',compact('array'));

            file_put_contents(ROOT . "public/datafeed.xml", $datafeedRendered);
            

            $dir_file = ROOT . "public/datafeed.xml";

            if (!file_exists($dir_file))
                die('Arquivo não existe!');

            header('Content-type: text/xml');       
            header('Content-disposition: attachment; filename=datafeed.xml;'); 
            header('Content-Length: '.filesize($dir_file));

            readfile($dir_file);

            exit;

        } else {
            $filename = 'datafeed.csv';

            $dir_file = ROOT . "public/" . $filename;

            if (!file_exists($dir_file)){
                file_put_contents(ROOT . "public/" . $filename, '');            
            }           
            
     
            $output = fopen(ROOT . "public/" . $filename, "w");

            $header = array_keys($array[0]);

            fputcsv($output, $header);
        
            foreach ($array as $row) {
                fputcsv($output, $row);
            }

            fclose($output);

            // open csv file for writing
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            header("Content-Transfer-Encoding: UTF-8");
            
            readfile($dir_file);
            
            die;
        }
        
    }

    function arrayToFacebook ($product, $linksImages = null) {

        global $app;       

        $array = [
            "id" => $product->id,
            "title" => $product->name,
            "description" => $product->short_description,
            "availability" => $stock = ($product->stock > 0 && $product->stock < 9999999) ? "in stock" : "out of stock",
            "condition" => "new",
            "price" => number_format((float) $product->price, 2, ',', '.') . " EUR", 
            "link" => URL . $product->lang . '/products/' . $product->slug,
            "image_link" => URL . $product->photo,            
            "brand" => $product->main_brand, 
            "google_product_category" => "Apparel & Accessories > Handbags, Wallets & Cases", 
            "fb_product_category" => "travel & luggage > handbags & wallets", 
            "quantity_to_sell_on_facebook" => $stock = ($product->stock > 0 && $product->stock < 9999999) ? $product->stock : 0,
            "sale_price" => number_format((float) $product->price, 2, ',', '.') . " EUR", 
            "sale_price_effective_date" => "",  
            "item_group_id" => "",  
            "gender" => "female",  
            "color" => "A consultar",  
            "size" => "A consultar",  
            "age_group" => "all ages",  
            "material" => "",  
            "pattern" => "",  
            "shipping" => "",  
            "shipping_weight" => "",  
        ]; 

        if($linksImages != null) {
            $array["additional_image_link"] = $linksImages;            
        }



        return $array;
    }

    function arrayToGoogle ($product, $linksImages = null) {

        global $app;

        $array = [
            "id" => $product->id,
            "title" => $product->name,
            "description" => $product->short_description,
            "link" => URL . $product->lang . '/products/' . $product->slug,
            "image_link" => URL . $product->photo,
            "availability" => $stock = ($product->stock > 0 && $product->stock < 9999999) ? "in_stock" : "out_of_stock",
            "price" => $product->price . " EUR", 
            "brand" => $product->main_brand, 
            "gtin" => intval($product->gtin),
            "mpn" => intval($product->mpn), 
            "update_type" => "merge", 
            "adult" => "no",
            "condition" => "new",
            "multipack" => 0, 
            "is_bundle" => "no", 
            "age_group" => "adult", 
            "gender" => "unisex",     
        ]; 

        if($linksImages != null) {
            foreach(explode(",",$linksImages) as $image) {
                $array["additional_image_link"][] = $image;            
            }     
        }

        return $array;
    }

    function getImagesLinks ($gallery) {
        $linksImages = "";
        foreach ($gallery as $key => $gall) {
            if(array_key_last($gallery) == $key) {
                $linksImages .= URL . $gall->path . "";
            } else {
                $linksImages .= URL . $gall->path . ",";
            }
        }

        return $linksImages;
    }

    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("products"));

        // Data handling
        $data       = $_POST;
        $data["id"] = $id;

      

        if(isset($_POST['policy'])) {             
            $data['policy'] = str_replace('rel="nofollow"', 'target="_blank"', $data['policy']); 
        }

        if(isset($_POST['details'])) {
            $data['details'] = str_replace('rel="nofollow"', 'target="_blank"', $data['details']);        
        }

        if(isset($_POST['order_by'])) {      
            $multiple = $this->dependencies->products->getAll(); 
            $allIds = [];

            foreach ($multiple as $multi) {
                $allIds[] = $multi->id;
            }
     
            array_unshift($allIds, $_POST['order_by']);

            $new_positions = implode(",", $allIds);            
            $this->dependencies->products->order($new_positions);   
          
            unset($_POST['order_by']);
        }

        // Edit the data
        $status = $this->dependencies->products->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->products->single($id));
    }

    function changeStatus() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("products"));

        // Data handling
        $data       = $_POST;
        $id         = $data["id"];

        // Edit the data
        $status = $this->dependencies->products->changeStatus($data);

        if($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->products->single($id));
        }
        
        // Send json response
        $this->response(false, "API REQUEST FALSE");
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("products", "products_gallery", "attributes"));        
        // Verifica se está a inserir o produto rascunho
        if (isset($_POST["draft"]) && $_POST["draft"] == "1") {

            $draft = $this->dependencies->products->getDraft();

            if (!empty($draft)) {

                $this->response(true, "API REQUEST SUCCESS", $draft);
            }
        }

        // Defenir a linguagem principal
        if (!isset($_POST["lang"])) {
            
            $_POST["lang"] = $app->default_language->code;
        }

        // Se o $_POST tiver um ID copia as informações todas desse produto para outro
        $galleryImg = false;
        if (isset($_POST["id"])) {            
            $clone          = $this->dependencies->products->single($_POST["id"]);
            $galleryImg     = $this->dependencies->products_gallery->multiple($_POST["id"]);            
            if($clone->photo == null) {
                $clone->photo   = '/static/images/login-background.jpg';
            }
            $attributes     = $this->dependencies->attributes->getAttributesByProduct($_POST["id"]);

            if (!empty($clone)) {

                //Neste foreach estamos a introduzir os valores que nao temos no novo produto
                foreach ($clone as $key => $value) {

                    if (!isset($_POST[$key])) {

                        $_POST[$key] = $value;
                    }
                }
            }

            //Retirar o id do post
            unset($_POST["id"]);
            
            if (!isset($_POST["keep_language_group"])) {
                
                // Retirar o language group se tiver
                unset($_POST['language_group']);
            }
        }   



        if(isset($_POST['policy'])) {             
            $_POST['policy'] = str_replace('rel="nofollow"', 'target="_blank"', $_POST['policy']); 
        }

        if(isset($_POST['details'])) {
            $_POST['details'] = str_replace('rel="nofollow"', 'target="_blank"', $_POST['details']);        
        }

        $multiple = $this->dependencies->products->getAll(); 
   
        // Insert the data
        $status = $this->dependencies->products->insert($_POST);
       
        if ($status["success"]) {
            $allIds = [];
            foreach ($multiple as $multi) {
                $allIds[] = $multi->id;
            }
           
            array_unshift($allIds, $status["data"]);

            $new_positions = implode(",", $allIds);            
            $this->dependencies->products->order($new_positions);   
            $product = $this->dependencies->products->single($status["data"]);

            if($galleryImg != false) {
                foreach($galleryImg as $g) {
                    unset($g->id);
                    $g->product_id = $product->id;
                    $path_parts = pathinfo($g->path);       
                    $new_path = $g->path . '-' . $product->lang . '.' . $path_parts['extension'];                     
                    copy(ROOT . 'public' . $g->path, ROOT . 'public' . $new_path);
                    if($product->photo == $g->path) {                   
                        $this->dependencies->products->edit(array("id" => $product->id, "photo" => $new_path));
                    }
                    $g->path = $new_path;
                    $this->dependencies->products_gallery->insert($g);                    
                }
            }
            
            //Define o campo que vai agrupar as linguas todas do produto, 
            // é basicamente um MD5 do ID do produto na lingua default
            if (!isset($_POST["language_group"])) {
                $this->dependencies->products->edit(array("id" => $product->id, "language_group" => md5($product->id)));
            }             

            //Copiar os atributos
            if (!empty($attributes)) {

                foreach($attributes as $key => $value) {
                    
                    // Remover id do atributo
                    unset($value->id);

                    // Adicionar id do produto novo
                    $value->id_product = $product->id;

                    $this->dependencies->attributes->insert((array)$value);
                }
            }

            $this->response(true, "API REQUEST SUCCESS", $product);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }


    function clone() {
   
        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("products", "products_gallery", "attributes"));

        // Se o $_POST tiver um ID copia as informações todas desse produto para outro
        $galleryImg = false;
        if (isset($_POST["id"])) {            
            $clone          = $this->dependencies->products->single($_POST["id"]);
            $galleryImg     = $this->dependencies->products_gallery->multiple($_POST["id"]);            
            if($clone->photo == null) {
                $clone->photo   = '/static/images/login-background.jpg';
            }
            $attributes     = $this->dependencies->attributes->getAttributesByProduct($_POST["id"]);

            if (!empty($clone)) {

                //Neste foreach estamos a introduzir os valores que nao temos no novo produto
                foreach ($clone as $key => $value) {

                    if (!isset($_POST[$key])) {

                        $_POST[$key] = $value;
                    }
                }
            }

            //Retirar o id do post
            unset($_POST["id"]);
            
            if (!isset($_POST["keep_language_group"])) {
                
                // Retirar o language group se tiver
                unset($_POST['language_group']);
            }
        }   
  
        // Insert the data
        $status = $this->dependencies->products->insert($_POST);
       
        if ($status["success"]) {

            $product = $this->dependencies->products->single($status["data"]);            
            
            if($galleryImg != false) {
                foreach($galleryImg as $g) {
                    unset($g->id);
                    $g->product_id = $product->id;
                    $path_parts = pathinfo($g->path);       
                    $new_path = $g->path . '-' . $product->lang . '.' . $path_parts['extension'];                     
                    copy(ROOT . 'public' . $g->path, ROOT . 'public' . $new_path);
                    if($product->photo == $g->path) {                   
                        $this->dependencies->products->edit(array("id" => $product->id, "photo" => $new_path));
                    }
                    $g->path = $new_path;
                    $this->dependencies->products_gallery->insert($g);                    
                }
            }
           
            //Define o campo que vai agrupar as linguas todas do produto, 
            // é basicamente um MD5 do ID do produto na lingua default
            if (!isset($_POST["language_group"])) {
                $this->dependencies->products->edit(array("id" => $product->id, "language_group" => md5($product->id)));
            }             
  
            //Copiar os atributos
            if (!empty($attributes)) {
               
                foreach($attributes as $key => $value) {
                    
                    // Remover id do atributo
                    unset($value->id);
                   
                    // Adicionar id do produto novo
                    $value->id_product = $product->id;                   
                 
                    $this->dependencies->attributes->insert((array) $value);
                }
            }
     
            $this->response(true, "API REQUEST SUCCESS", $product);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function delete($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("products"));

        // Delete the data
        $status = $this->dependencies->products->softDelete($id);

        if ($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->products->single($id));
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("products"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->products->softDeleteMultiple($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    //#########################################ADVANCED PRODUCT#############################################

    function advancedProductsByProduct($idProduct){
        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("advanced_products"), array());
       
        // Product array
        $advanced_products = $this->dependencies->advanced_products->advancedProductsByProduct($idProduct);

        if (empty($advanced_products)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $advanced_products);
    }

    function insertAdvancedProduct() {

        global $app;

     
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("advanced_products", "products"));

        // Insert the data
        $status = $this->dependencies->advanced_products->insert($_POST);        

        if ($status["success"]) {
            $this->changeInfoFromMainProduct($_POST['id_product']);

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->advanced_products->single($status["data"]));
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }    

    function editAdvancedProduct($id) {

        global $app;

        // Middleware
        //$this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("advanced_products", "products"));

        // Data handling
        $data       = $_POST;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->advanced_products->edit($data);

        $all = $this->dependencies->advanced_products->all($_POST['id_product']);
        if(count($all) > 0) {
            $edit_product = ['id' => $all[0]->id_product, 'price' => $all[0]->current_price, 'stock' => $all[0]->stock];                
            $all = $this->dependencies->products->edit($edit_product);
        }

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->advanced_products->single($id));
    }

    function deleteAdvancedProduct($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->dependencies(array("advanced_products", "products"));

        $status = $this->dependencies->advanced_products->remove($id);
        if ($status["success"]) {
            $all = $this->dependencies->advanced_products->all($_GET['id_product']);
            if(count($all) > 0) {
                $edit_product = ['id' => $all[0]->id_product, 'price' => $all[0]->current_price, 'stock' => $all[0]->stock];                
                $all = $this->dependencies->products->edit($edit_product);
            }
            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->advanced_products->single($id));
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function singleAdvancedProducts($idAdvancedProduct){
        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("advanced_products"), array());

        // Product array
        $advancedProduct = $this->dependencies->advanced_products->single($idAdvancedProduct);

        if (empty($advancedProduct)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $advancedProduct);
    }

    function changeInfoFromMainProduct($product_id) {
        
        // Dependencies
        $this->dependencies(array("advanced_products", "products"));

        $all = $this->dependencies->advanced_products->all($product_id);
        if(count($all) > 0) {
            $edit_product = ['id' => $all[0]->id_product, 'price' => $all[0]->current_price, 'stock' => $all[0]->stock, 'price_request' => $all[0]->price_request];                
            $all = $this->dependencies->products->edit($edit_product);
        }
        return $all;
    }
}