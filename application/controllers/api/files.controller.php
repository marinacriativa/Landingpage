<?php 

/** 
*   Controller files ( API )
*   
*   Upload de imagens e ficheiros
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class files extends \Fyre\Core\Controller {

    function dropzone() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);        
     
        $folder = isset($_GET["folder"]) ? str_replace("/", "", $_GET["folder"]) : "products";
        $gallery_dep = "products_gallery";
        
        if(isset($_POST["folder"]))   
        {   
            switch($_POST["folder"]) {
                case 'constructions':
                    $gallery_dep = "constructions_gallery";
                    break;
                case 'news':
                    $gallery_dep = "news_gallery";
                    break;
            }

            $folder = $_POST["folder"];            
        }        
     
        // Dependencies
        $this->dependencies(array($gallery_dep), array("s3", "image"));        

        if (isset($_FILES["file"]) && !empty($_FILES["file"]) && !empty($_FILES["file"]["tmp_name"])) {
            
            try {

                if ($app->config->aws_s3_enabled == "1") { 

                    // Definir a configuração no model S3 AWS
                    $this->dependencies->library->s3->_set($app->config);
                }

                $status = true;

                if (strpos($_FILES["file"]["type"], 'image/') !== false) {

                    // Comprimir a imagem
                    $status = $this->dependencies->library->image->compress_image($_FILES["file"]["tmp_name"], $_FILES["file"]["tmp_name"]);

                    
                }

                // Obter o tamanho novo
                $file_size = filesize($_FILES["file"]["tmp_name"]);

                if ($status == false) {

                    $this->raw_response(array("success" => false, "message" => "Ocorreu algum erro ao carregar o ficheiro"));
                }

                if ($app->config->aws_s3_enabled == "1") {

                    // Fazer upload do ficheiro atraves do s3
                    $file_uploaded = $this->dependencies->library->s3->upload($_FILES["file"]["name"], $_FILES["file"]["tmp_name"])->get("ObjectURL");
                    
                    if ($file_uploaded == false) {

                        $this->raw_response(array("success" => false, "message" => "Ocorreu algum erro ao carregar o ficheiro"));
                    
                    } else {

                        $file_uploaded = CRIATIVATEK_CDN_PROXY . str_replace("http://", "https://", $file_uploaded);
                    }


                } else {
                    
                    // Fazer upload para o servidor
                    if(isset($_POST['isEditor'])) {
                        $file_uploaded = $this->dependencies->library->image->upload($_FILES["file"], ROOT . "public/static/images/editor/");  
                    } else {
                        if($folder == 'constructions' || $folder == 'news' || $folder == 'products') {
                            $file_uploaded = $this->dependencies->library->image->upload($_FILES["file"], ROOT . "public/static/images/$folder/");             
                        } else {
                            $file_uploaded = $this->dependencies->library->image->upload($_FILES["file"], ROOT . "public/static/videos/");                    
                        }     
                    }             
                        
                    // Retirar o ROOT
                    $file_uploaded = str_replace(ROOT . "public", "", $file_uploaded);


                }

                $file                       = array();
                $file["name"]               = (isset($_FILES["file"]["name"]) && !empty($_FILES["file"]["name"])) ? explode(".", str_replace("/", "-", $_FILES["file"]["name"]))[0] : false;
                
                // Deixar a extensao se for .stl
                if (isset($_FILES["file"]["name"])) {

                    if (strpos($_FILES["file"]["name"], '.stl') !== false) {
                        
                        $file['name'] = str_replace("/", "-", $_FILES["file"]["name"]);
                    }
                }
                
                $file["path"]               = $file_uploaded;
                $file["size"]               = $file_size;

                

                if (isset($_GET["not_product_gallery"])) {

                    $this->raw_response(array("success" => true, "message" => "Ficheiro carregado com sucesso!", "data" => $file));

                } elseif(isset($_POST['isEditor'])) {
                    $this->raw_response(array("success" => true, "message" => "Ficheiro carregado com sucesso!", "data" => $file));
                } else {

                    $file["isvideo"] = 0;                                 
                    
                    if (strpos($_FILES["file"]["type"], 'video/') !== false) {
                        $file["isvideo"] = 1;
                    }

                    $index_str = '';

                    switch($folder) {
                        case 'products':
                            if(isset($_POST["product_id"])){                              
                                $index_str  = "product_id";   
                            }
                            break;
                        case 'constructions':
                            if(isset($_POST["construction_id"])){                                
                                $index_str  = "construction_id"; 
                            }
                            break;
                        case 'news':
                            if(isset($_POST["new_id"])){                                 
                                $index_str  = "new_id";   
                            }   
                            break;
                    }  

                    $file[$index_str] = $_POST[$index_str];   
              
                    if (!isset($_POST[$index_str]) || empty($_POST[$index_str])){
                        $this->raw_response(array("success" => false, "message" => "Ocorreu algum erro ao carregar o ficheiro"));
                    }
                        
                    // Try the insert 
                    $file["id"] = $this->dependencies->$gallery_dep->insert($file)["data"];                    
                    
                    $objFiles = $this->dependencies->$gallery_dep->multiple($file[$index_str]);                   

                    $arrayIdFiles = array();

                    foreach ($objFiles as $file) {

                        array_push($arrayIdFiles, $file->id);
                    }

                    $files = implode(",", $arrayIdFiles);

                    $this->dependencies->$gallery_dep->order($files);

                    $this->raw_response(array("success" => true, "message" => "Ficheiro carregado com sucesso!", "data" => $file));
                }
                
            } catch (\Exception $e) {
                
                $this->raw_response(array("success" => false, "message" => $e->getMessage()));
            }
            
        } else {
            
            $this->raw_response(array("success" => false, "message" => "Ficheiro demasiado grande"));
        }
    }

    function ckeditor () {
        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);       


        if(isset($_FILES['files'])) {

            $files = array_filter($_FILES['files']['name']);
            $total_count = count($_FILES['files']['name']);
            $baseUrl = '/public/static/images/description/';
            $names = [];
            $isImg = [];
            for( $i=0 ; $i < $total_count ; $i++ ) {
                
                $tmpFilePath = $_FILES['files']['tmp_name'][$i];
                
                $size = $_FILES['files']['size'][$i];
                if($size > 500000) {
                    echo json_encode([
                        'data' => [
                            'baseurl'   => $baseUrl, 
                            'code'      => 220, 
                            'files'     => $names, 
                            'isImages'  => $isImg, 
                            'messages'  => ['Erro: tamanho de imagem não permitido.']
                        ],
                        'success' => false
                    ]);    
        
                    exit;
                }

                if ($tmpFilePath != ""){
                    $fileNameNew = uniqid('', true) . "-" . $_FILES['files']['name'][$i];
                    $newFilePath = ROOT . 'public/static/images/description/' . $fileNameNew;
                    
                    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                        $fileDestination = str_replace(ROOT . "public", "", $newFilePath);  
                        $names[] = $fileNameNew;
                        $isImg[] = true;
                    }
                }
            }
            
            echo json_encode([
                'data' => [
                    'baseurl'   => $baseUrl, 
                    'code'      => 220, 
                    'files'     => $names, 
                    'isImages'  => $isImg, 
                    'messages'  => []
                ],
                'success' => true
            ]);    

            exit;
        }

    }

    function dropzone_gallery() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("galleries_gallery"), array("s3", "image"));

        //
        
        if (isset($_FILES["file"]) && !empty($_FILES["file"]) && !empty($_FILES["file"]["tmp_name"])) {
            
            if (!isset($_POST["gallery_id"]) || empty($_POST["gallery_id"])) {
                
                $this->raw_response(array("success" => false, "message" => "Ocorreu algum erro ao carregar o ficheiro"));
            }
            
            try {

                if ($app->config->aws_s3_enabled == "1") { 

                    // Definir a configuração no model S3 AWS
                    $this->dependencies->library->s3->_set($app->config);
                }

                $status = false;

                // Comprimir a imagem
                if($_FILES['file']['type'] !== 'video/mp4' || $_FILES['file']['type'] !== 'video/mkv')
                    $status = $this->dependencies->library->image->compress_image($_FILES["file"]["tmp_name"], $_FILES["file"]["tmp_name"]);
              
                
                // Obter o tamanho novo
                $file_size = filesize($_FILES["file"]["tmp_name"]);

                if ($status == false && !$_FILES['file']['type'] == 'video/mp4' || !$_FILES['file']['type'] == 'video/mkv') {

                    $this->raw_response(array("success" => false, "message" => "Ocorreu algum erro ao carregar o ficheiro"));
                }

                if ($app->config->aws_s3_enabled == "1") {

                    // Fazer upload do ficheiro atraves do s3
                    $file_uploaded = $this->dependencies->library->s3->upload($_FILES["file"]["name"], $_FILES["file"]["tmp_name"])->get("ObjectURL");
                    
                    if ($file_uploaded == false) {

                        $this->raw_response(array("success" => false, "message" => "Ocorreu algum erro ao carregar o ficheiro"));
                    
                    } else {

                        $file_uploaded = CRIATIVATEK_CDN_PROXY . str_replace("http://", "https://", $file_uploaded);
                    }

                } else {
                    // Fazer upload para o servidor
                    if($_FILES['file']['type'] !== 'video/mp4' || $_FILES['file']['type'] !== 'video/mkv'){
                        $file_uploaded = $this->dependencies->library->image->upload($_FILES["file"], ROOT . "public/static/images/products/");
                    } else {   
                        $file_uploaded = $this->dependencies->library->image->upload($_FILES["file"], ROOT . "public/static/videos/");
                    }
                    
                    // Retirar o ROOT
                    $file_uploaded = str_replace(ROOT . "public", "", $file_uploaded);
                }

                $file                       = array();
                $file["name"]               = (isset($_FILES["file"]["name"]) && !empty($_FILES["file"]["name"])) ? explode(".", str_replace("/", "-", $_FILES["file"]["name"]))[0] : false;
                $file["gallery_id"]         = $_POST["gallery_id"];
                $file["path"]               = $file_uploaded;
                $file["size"]               = $file_size;
                
                // Try the insert 
                $file["id"] = $this->dependencies->galleries_gallery->insert($file)["data"];

                $objFiles = $this->dependencies->galleries_gallery->multiple($file["gallery_id"]);

                $arrayIdFiles = array();

                foreach ($objFiles as $file) {

                    array_push($arrayIdFiles, $file->id);
                }

                $files = implode(",", $arrayIdFiles);

                $this->dependencies->galleries_gallery->order($files);

                $this->raw_response(array("success" => true, "message" => "Ficheiro carregado com sucesso!", "data" => $file));
                
            } catch (\Exception $e) {
                
                $this->raw_response(array("success" => false, "message" => $e->getMessage()));
            }
            
        } else {
            
            $this->raw_response(array("success" => false, "message" => "Ficheiro demasiado grande"));
        }
    }

    function updateFile() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("products_gallery"), array("s3", "image"));

        if (!isset($_GET["new_file_name"])) {

            $this->raw_response(array("success" => false, "message" => "Ocorreu algum erro ao carregar o ficheiro"));
        }

        if (isset($_FILES["data"]) && !empty($_FILES["data"]) && !empty($_FILES["data"]["tmp_name"])) {
            
            try {

                if ($app->config->aws_s3_enabled == "1") { 

                    // Definir a configuração no model S3 AWS
                    $this->dependencies->library->s3->_set($app->config);
                }

                // Comprimir a imagem
                $status = $this->dependencies->library->image->compress_image($_FILES["data"]["tmp_name"], $_FILES["data"]["tmp_name"]);
                
                // Obter o tamanho novo
                $file_size = filesize($_FILES["data"]["tmp_name"]);

                if ($status == false) {

                    $this->raw_response(array("success" => false, "message" => "Ocorreu algum erro ao carregar o ficheiro"));
                }

                if ($app->config->aws_s3_enabled == "1") {

                    $file_name = explode("/", $_GET["new_file_name"]);
                    $file_name = end($file_name);

                    // Fazer upload do ficheiro atraves do s3
                    $file_uploaded = $this->dependencies->library->s3->upload($file_name, $_FILES["data"]["tmp_name"], true)->get("ObjectURL");
                    
                    if ($file_uploaded == false) {

                        $this->raw_response(array("success" => false, "message" => "Ocorreu algum erro ao carregar o ficheiro"));
                    
                    } else {

                        $file_uploaded = CRIATIVATEK_CDN_PROXY . str_replace("http://", "https://", $file_uploaded);
                    }

                    $clear_cache = $file_uploaded;

                } else {

                    if (!file_exists(ROOT . "public" . $_GET["new_file_name"])) {

                        echo "ERROR";
                        exit();
                    }
                     
                    // Fazer upload para o servidor
                    $file_uploaded = $this->dependencies->library->image->upload($_FILES["data"], ROOT . "public/static/images/products/", $_GET["new_file_name"]);
                    
                    // Retirar o ROOT
                    $file_uploaded = str_replace(ROOT . "public", "", $file_uploaded);

                    $clear_cache = URL . $file_uploaded;
                }

                // Limpar cache do cloudflare
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/" . CLOUDFLARE_ZONE_ID . "/purge_cache");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array("files" => array($clear_cache))));  
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization: Bearer ' . CLOUDFLARE_API_TOKEN,
                    'Content-Type: application/json'
                ));

                curl_exec($ch);
                curl_close ($ch);
                
                echo $file_uploaded;
                
            } catch (\Exception $e) {
                
                $this->raw_response(array("success" => false, "message" => $e->getMessage()));
            }
            
        } else {
            
            $this->raw_response(array("success" => false, "message" => "Ficheiro demasiado grande"));
        }
    }

    function updateFileNews() {
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("news", "news_gallery"), array("s3", "image"));

        if (!isset($_GET["new_file_name"])) {

            $this->raw_response(array("success" => false, "message" => "Ocorreu algum erro ao carregar o ficheiro"));
        }

        if (isset($_FILES["data"]) && !empty($_FILES["data"]) && !empty($_FILES["data"]["tmp_name"])) {
            
            try {

                if ($app->config->aws_s3_enabled == "1") { 

                    // Definir a configuração no model S3 AWS
                    $this->dependencies->library->s3->_set($app->config);
                }

                // Comprimir a imagem
                $status = $this->dependencies->library->image->compress_image($_FILES["data"]["tmp_name"], $_FILES["data"]["tmp_name"]);
                
                // Obter o tamanho novo
                $file_size = filesize($_FILES["data"]["tmp_name"]);

                if ($status == false) {

                    $this->raw_response(array("success" => false, "message" => "Ocorreu algum erro ao carregar o ficheiro"));
                }

                if ($app->config->aws_s3_enabled == "1") {

                    $file_name = explode("/", $_GET["new_file_name"]);
                    $file_name = end($file_name);

                    // Fazer upload do ficheiro atraves do s3
                    $file_uploaded = $this->dependencies->library->s3->upload($file_name, $_FILES["data"]["tmp_name"], true)->get("ObjectURL");
                    
                    if ($file_uploaded == false) {

                        $this->raw_response(array("success" => false, "message" => "Ocorreu algum erro ao carregar o ficheiro"));
                    
                    } else {

                        $file_uploaded = CRIATIVATEK_CDN_PROXY . str_replace("http://", "https://", $file_uploaded);
                    }

                    $clear_cache = $file_uploaded;

                } else {

                    if (!file_exists(ROOT . "public" . $_GET["new_file_name"])) {

                        echo "ERROR";
                        exit();
                    }
                     
                    // Fazer upload para o servidor
                    $file_uploaded = $this->dependencies->library->image->upload($_FILES["data"], ROOT . "public/static/images/news/", $_GET["new_file_name"]);
                    
                    // Retirar o ROOT
                    $file_uploaded = str_replace(ROOT . "public", "", $file_uploaded);

                    $clear_cache = URL . $file_uploaded;
                }

                // Limpar cache do cloudflare
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/" . CLOUDFLARE_ZONE_ID . "/purge_cache");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array("files" => array($clear_cache))));  
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization: Bearer ' . CLOUDFLARE_API_TOKEN,
                    'Content-Type: application/json'
                ));

                curl_exec($ch);
                curl_close ($ch);   

                if(isset($_GET["id"])) {

                    $this->dependencies->news->edit(array("id" => $_GET["id"], "photo_path" => $file_uploaded));           
                }

          
                echo $file_uploaded;               
                
            } catch (\Exception $e) {
                
                $this->raw_response(array("success" => false, "message" => $e->getMessage()));
            }
            
        } else {
            
            $this->raw_response(array("success" => false, "message" => "Ficheiro demasiado grande"));
        }
    }

    function updateFile_gallery() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("galleries_gallery"), array("s3", "image"));

        if (!isset($_GET["new_file_name"])) {

            $this->raw_response(array("success" => false, "message" => "Ocorreu algum erro ao carregar o ficheiro"));
        }

        if (isset($_FILES["data"]) && !empty($_FILES["data"]) && !empty($_FILES["data"]["tmp_name"])) {
            
            try {

                if ($app->config->aws_s3_enabled == "1") { 

                    // Definir a configuração no model S3 AWS
                    $this->dependencies->library->s3->_set($app->config);
                }

                // Comprimir a imagem
                $status = $this->dependencies->library->image->compress_image($_FILES["data"]["tmp_name"], $_FILES["data"]["tmp_name"]);
                
                // Obter o tamanho novo
                $file_size = filesize($_FILES["data"]["tmp_name"]);

                if ($status == false) {

                    $this->raw_response(array("success" => false, "message" => "Ocorreu algum erro ao carregar o ficheiro"));
                }

                if ($app->config->aws_s3_enabled == "1") {

                    $file_name = explode("/", $_GET["new_file_name"]);
                    $file_name = end($file_name);

                    // Fazer upload do ficheiro atraves do s3
                    $file_uploaded = $this->dependencies->library->s3->upload($file_name, $_FILES["data"]["tmp_name"], true)->get("ObjectURL");
                    
                    if ($file_uploaded == false) {

                        $this->raw_response(array("success" => false, "message" => "Ocorreu algum erro ao carregar o ficheiro"));
                    
                    } else {

                        $file_uploaded = CRIATIVATEK_CDN_PROXY . str_replace("http://", "https://", $file_uploaded);
                    }

                    $clear_cache = $file_uploaded;

                } else {

                    if (!file_exists(ROOT . "public" . $_GET["new_file_name"])) {

                        echo "ERROR";
                        exit();
                    }
                     
                    // Fazer upload para o servidor
                    $file_uploaded = $this->dependencies->library->image->upload($_FILES["data"], ROOT . "public/static/images/products/", $_GET["new_file_name"]);
                    
                    // Retirar o ROOT
                    $file_uploaded = str_replace(ROOT . "public", "", $file_uploaded);

                    $clear_cache = URL . $file_uploaded;
                }

                // Limpar cache do cloudflare
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/" . CLOUDFLARE_ZONE_ID . "/purge_cache");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array("files" => array($clear_cache))));  
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization: Bearer ' . CLOUDFLARE_API_TOKEN,
                    'Content-Type: application/json'
                ));

                curl_exec($ch);
                curl_close ($ch);
                
                echo $file_uploaded;
                
            } catch (\Exception $e) {
                
                $this->raw_response(array("success" => false, "message" => $e->getMessage()));
            }
            
        } else {
            
            $this->raw_response(array("success" => false, "message" => "Ficheiro demasiado grande"));
        }
    }

    function remove($id) {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        $gallery_dep    = "products_gallery";
        $item_id        = 'product_id';
        $current_item   = 'products';
        $column_name    = 'photo';

        
        if(isset($_GET['isconstruction']))  {    
            $gallery_dep    = "constructions_gallery";
            $item_id        = 'construction_id';
            $current_item   = 'constructions';   
            
        }

        if(isset($_GET['isnews']))  {           
            $gallery_dep    = "news_gallery";
            $item_id        = 'new_id';
            $current_item   = 'news';    
            $column_name    = 'photo_path';       
        }
  
        // Dependencies
        $this->dependencies(array($gallery_dep, $current_item), array("s3", "image"));

        // Eliminar o ficheiro
        $file = $this->dependencies->$gallery_dep->single($id);
        $obj_id = $file->$item_id;   

        $this->dependencies->library->image->delete_file($this->dependencies->library->s3, str_replace(CRIATIVATEK_CDN_PROXY, "", $file->path));

        // Delete the data
        $status = $this->dependencies->$gallery_dep->remove($id);
        
        if ($status["success"]) {


            $product_images = $this->dependencies->$gallery_dep->multiple($obj_id);
            
            if (!empty($product_images)) {
                $photo = $product_images[0]->path;
            } else {
                $photo = "";
            }

            $t = $this->dependencies->$current_item->edit(array("id" => $obj_id, $column_name => $photo));

            $this->response(true, "API REQUEST SUCCESS");
        }

        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function remove_gallery($id) {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("galleries_gallery", "galleries"), array("s3", "image"));

        // Eliminar o ficheiro
        $file = $this->dependencies->galleries_gallery->single($id);
        $gallery_id = $file->gallery_id;

        $this->dependencies->library->image->delete_file($this->dependencies->library->s3, str_replace(CRIATIVATEK_CDN_PROXY, "", $file->path));

        // Delete the data
        $status = $this->dependencies->galleries_gallery->remove($id);

        if ($status["success"]) {


            $product_images = $this->dependencies->galleries_gallery->multiple($gallery_id);
            if (!empty($product_images)) {
                $photo = $product_images[0]->path;
            } else {
                $photo = "";
            }

            $this->dependencies->galleries->edit(array("id" => $gallery_id, "photo" => $photo));

            

            $this->response(true, "API REQUEST SUCCESS");
        }

        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function slim() { 

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("config"), array("s3", "image"));

        $slim = json_decode($_POST["slim"][0], true);
        $file = $_FILES[$slim["output"]["field"]];
        $name = null;  

        if ($app->config->aws_s3_enabled == "1") { 

            // Definir a configuração no model S3 AWS
            $this->dependencies->library->s3->_set($app->config);
        }

        // Comprimir a imagem
        $status = $this->dependencies->library->image->compress_image($file["tmp_name"], $file["tmp_name"]);
        
        if ($status == false) {

            $this->raw_response(array("success" => false, "message" => "Ocorreu algum erro ao carregar o ficheiro"));
        }

        if ($app->config->aws_s3_enabled == "1") {

            // Fazer upload do ficheiro atraves do s3
            $file_uploaded = $this->dependencies->library->s3->upload($file["name"], $file["tmp_name"])->get("ObjectURL");
            
            if ($file_uploaded == false) {

                $this->raw_response(array("success" => false, "message" => "Ocorreu algum erro ao carregar o ficheiro"));
            
            } else {

                $file_uploaded = CRIATIVATEK_CDN_PROXY . str_replace("http://", "https://", $file_uploaded);
            }

        } else {

            $folder = isset($slim["meta"]["folder"]) ? $slim["meta"]["folder"] : "products";
            
            // Fazer upload para o servidor
            $file_uploaded = $this->dependencies->library->image->upload($file, ROOT . "public/static/images/" . $folder . "/");
            
            // Retirar o ROOT
            $file_uploaded = str_replace(ROOT . "public", "", $file_uploaded);

            if($folder == isset($slim["meta"]["folder"]) && $slim["meta"]["folder"] == 'logo') 
                $this->dependencies->config->edit_keys('mail_logo', $file_uploaded);
        }

        // atualizar db

        echo ($file_uploaded);
    }

    function order () {
        
        global $app;
        
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);       
         // Dependencies

        $this->dependencies(array($_REQUEST['gallery']));
        
        $gallery = $_REQUEST['gallery'];

        $status = $this->dependencies->$gallery->order($_REQUEST["ids"]);
        
        $this->raw_response($status);
    }

    function order_gallery() {
        
        global $app;
        
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("galleries_gallery"));
        
        $status = $this->dependencies->galleries_gallery->order($_REQUEST["ids"]);
        
        $this->raw_response($status);
    }
}