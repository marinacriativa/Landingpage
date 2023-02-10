<?php 

/** 
*   Controller news ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class news extends \Fyre\Core\Controller {

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("news"), array());

        $page       = (isset($_GET["page"]))    ? intval($_GET["page"])     : 1;
        $limit      = (isset($_GET["length"]))  ? intval($_GET["length"])   : 10;
        $search     = (isset($_GET["search"]))  ? $_GET["search"]           : null;
        $order      = (isset($_GET["order"]))   ? $_GET["order"]            : "id";
        $lang       = (isset($_GET["lang"]) && !empty($_GET["lang"])) ? $_GET["lang"] : $app->default_language->code;
        $start      = ($page - 1) * $limit;  

        $news   = $this->dependencies->news->multiple($lang, $start, $limit, $search, $order);
        $total  = $this->dependencies->news->total($lang, $search);

        $pagination = array (
            "page"      => (int) $page, 
            "limit"     => (int) $limit, 
            "total"     => (int) $total, 
            "start"     => (int) $start, 
        );

        if (empty($news)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $news, $pagination);
    }

    function changeStatus() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("news"));

        // Data handling
        $data       = $_POST;
        $id         = $data["id"];

        // Edit the data
        $status = $this->dependencies->news->changeStatus($data);

        if($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->news->single($id));
        }
        
        // Send json response
        $this->response(false, "API REQUEST FALSE");
    }

    function insert() {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("news", "news_gallery"));

        // Vereficar se está a inserir uma notícia "rascunho"
        if (isset($_POST["draft"]) && $_POST["draft"] == "1") {
            
            $draft = $this->dependencies->news->getDraft();
            
            if (!empty($draft)) {
                
                // A API dá return da noticia rascunho, depois desta função o codigo nao executa mais
                $this->response(true, "API REQUEST SUCCESS", $draft);
            }
        }
        
        // Temos de definir a lingua principal da noticia
        if (!isset($_POST["lang"])) {
            
            $_POST["lang"] = $app->default_language->code;
        }

        // Se o $_POST tiver um ID copia as informações todas desse construction para outro
        $galleryImg = false;
        if (isset($_POST["id"])) {

            $clone      = $this->dependencies->news->single($_POST["id"]);
            $galleryImg     = $this->dependencies->news_gallery->multiple($_POST["id"]);            
            if($clone->photo_path == null) {
                $clone->photo_path   = '/static/images/login-background.jpg';
            }

            if (!empty($clone)) {

                //Neste foreach estamos a introduzir os valores que nao temos no novo construction
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
        
        // Se o $_POST tiver um id é para copiar as informações todas dessa noticia para a noticia nova
        if (isset($_POST["id"])) {
            
            $clone = $this->dependencies->news->single($_POST["id"]);
            
            if (!empty($clone)) {
                
                // Neste foreach estamos a introduzir os valores que não temos na nova noticia
                foreach ($clone as $key => $value) {
                    
                    if (!isset($_POST[$key])) {
                        
                        $_POST[$key] = $value;
                    }
                }
            }
            
            // retirar o id do post
            unset($_POST["id"]);
        }

        if (isset($_POST["date"]) && $_POST["date"] == '0000-00-00') {
            $_POST["date"] = date("Y-m-d");
        }
        
        // Insert the data
        $status = $this->dependencies->news->insert($_POST);

        if ($status["success"]) {

            $new = $this->dependencies->news->single($status["data"]);

            if($galleryImg != false) {
                foreach($galleryImg as $g) {
                    unset($g->id);
                    $g->new_id = $new->id;
                    $path_parts = pathinfo($g->path);       
                    $new_path = $g->path . '-' . $new->lang . '.' . $path_parts['extension'];                     
                    copy(ROOT . 'public' . $g->path, ROOT . 'public' . $new_path);
                    if($new->photo_path == $g->path) {                   
                        $this->dependencies->news->edit(array("id" => $new->id, "photo_path" => $new_path));
                    }
                    $g->path = $new_path;
                    $this->dependencies->news_gallery->insert($g);                    
                }
            }
            
            //Define o campo que vai agrupar as linguas todas do produto, 
            // é basicamente um MD5 do ID do produto na lingua default
            if (!isset($_POST["language_group"])) {
                $this->dependencies->news->edit(array("id" => $new->id, "language_group" => md5($new->id)));
            }             

            $this->response(true, "API REQUEST SUCCESS", $new);
        }
        
        // Send json response 
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function ordenation() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("news"));
        
        // Data handling
        $ids       = $_POST['ids'];   
        $status = $this->dependencies->news->order($ids);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    
    function single($id) {
        
        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("news", "news_gallery"), array());

        // Product array
        $new = $this->dependencies->news->single($id);

        if (empty($new)) {
            
            $this->response(false, "API REQUEST EMPTY");
        }

        // Obter outras linguas disponiveis na noticia
        $new->related = $this->dependencies->news->getRelated($new->language_group, $new->id);

        // Obter as imagens
        $new->images  = $this->dependencies->news_gallery->multiple($new->id);

        $this->response(true, "API REQUEST SUCCESS", $new);
    }

    function edit($id) {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("news"), array("s3", "image"));

        // Data handling
        $data       = $_POST;
        $data["id"] = $id;

        // Vereficar se a imagem antiga não é igual à nova
        $old_data = $this->dependencies->news->single($id);

        if(!isset($data['date']) || $data['date'] == '')
            $data['date'] = date('Y-m-d');

        // Edit the data
        $status = $this->dependencies->news->edit($data);    

        if (isset($data["photo_path"])) {

            if (($old_data->photo_path !== $data["photo_path"]) && !empty($old_data->photo_path)) {

                // Eliminar imagem antiga
                $this->dependencies->library->image->delete_file($this->dependencies->library->s3, $old_data->photo_path);
            }
        }

        // Vereficar se a imagem antiga não é igual à nova
        $new_data = $this->dependencies->news->single($id);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS", $new_data);
    }

    function clone() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("news", "news_gallery"));

        // Se o $_POST tiver um ID copia as informações todas desse produto para outro
        
        // Se o $_POST tiver um ID copia as informações todas desse produto para outro
        $galleryImg = false;
        if (isset($_POST["id"])) {            
            $clone          = $this->dependencies->news->single($_POST["id"]);
            $galleryImg     = $this->dependencies->news_gallery->multiple($_POST["id"]);            
            if($clone->photo_path == null) {
                $clone->photo_path   = '/static/images/login-background.jpg';
            }

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
        $status = $this->dependencies->news->insert($_POST);
        
        if ($status["success"]) {

            $new = $this->dependencies->news->single($status["data"]);            
            
            if($galleryImg != false) {
                foreach($galleryImg as $g) {
                    unset($g->id);
                    $g->new_id = $new->id;
                    $path_parts = pathinfo($g->path);       
                    $new_path = $g->path . '-' . $new->lang . '.' . $path_parts['extension'];                     
                    copy(ROOT . 'public' . $g->path, ROOT . 'public' . $new_path);
                    if($new->photo_path == $g->path) {                   
                        $this->dependencies->news->edit(array("id" => $new->id, "photo_path" => $new_path));
                    }
                    $g->path = $new_path;
                    $this->dependencies->news_gallery->insert($g);                    
                }
            }
            
            //Define o campo que vai agrupar as linguas todas do produto, 
            // é basicamente um MD5 do ID do produto na lingua default
            if (!isset($_POST["language_group"])) {
                $this->dependencies->news->edit(array("id" => $new->id, "language_group" => md5($new->id)));
            }             

            $this->response(true, "API REQUEST SUCCESS", $new);
        }
        
        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
    
    function delete($id) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("news"), array("s3", "image"));

        $data = $this->dependencies->news->single($id);

        if (empty($data)) {

            $this->response(false, "API REQUEST ERROR");
        }

        if($data->photo_path != null && !empty($data->photo_path)){
            $this->dependencies->library->image->delete_file($this->dependencies->library->s3, $data->photo_path);
        }
        // Delete the data
        $status = $this->dependencies->news->remove($id);        

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS");
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("news"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->news->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}