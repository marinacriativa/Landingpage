<?php 

/** 
*   Controller banners ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class banners extends \Fyre\Core\Controller {

    function index() {

        global $app;
        
        // Dependencies
        $this->dependencies(array("banners"), array());

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "order_by";
        $lang       = (isset($_GET["lang"]) && !empty($_GET["lang"])) ? $_GET["lang"] : null;
        $start      = ($page - 1) * $limit;
       
        $banners = $this->dependencies->banners->multiple($lang, $start, $limit, $search, $order);
        $total = $this->dependencies->banners->total($search);

        $pagination = array (
            "page" => (int) $page,
            "limit" => (int) $limit,
            "total" => (int) $total,
            "start" => (int) $start,
        );
        
        if (empty($banners)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

        $this->response(true, "API REQUEST SUCCESS", $banners, $total);
    }

    function single($id) {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("banners"), array());

        $banners = $this->dependencies->banners->single($id);
        
        if (empty($banners)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

        $this->response(true, "API REQUEST SUCCESS", $banners);
    }

    function active($id) {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("banners"), array());
        $banners = $this->dependencies->banners->single($id);
        
        $res = false;

        switch ($banners->active)
        {
            case 0:
                $res = 1;
                break;
            case 1:
                $res = 0;
                break;
        }
       
        $this->dependencies->banners->edit(array("id" => $id, "active" => $res));


        if (empty($banners)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

        $this->response(true, "API REQUEST SUCCESS", $banners);
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("banners"));

        if(isset($_POST['is_active_btn_txt'])) {
            $_POST['is_active_btn_txt'] = 1;
        } else {
            $_POST['is_active_btn_txt'] = 0;
        }

        if(isset($_POST['active'])) {
            $_POST['active'] = 1;
        } else {
            $_POST['active'] = 0;
        }

        // Definir a linguagem principal
        if (!isset($_POST["lang"])) {
            
            $_POST["lang"] = $app->default_language->code;
        }        

        // Se o $_POST tiver um ID copia as informações todas desse banner para outro

        if (isset($_POST["id"])) {

            $clone      = $this->dependencies->banners->single($_POST["id"]);
            $clone->photo = '$clone->photo';

            if (!empty($clone)) {

                //Neste foreach estamos a introduzir os valores que nao temos no novo banner
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

        $multiple = $this->dependencies->banners->multiple();

        // Insert the data
        $status = $this->dependencies->banners->insert($_POST);
        $allIds = [];

        if ($status["success"]) {
            foreach ($multiple as $multi) {
                $allIds[] = $multi->id;
            }
            array_unshift($allIds, $status["data"]);
            $new_positions = implode(",", $allIds);            
            $this->dependencies->banners->order($new_positions);   
            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->banners->single($status["data"]));
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
    
    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("banners"));
        
        if(isset($_POST['is_active_btn_txt'])) {
            $_POST['is_active_btn_txt'] = 1;
        } else {
            $_POST['is_active_btn_txt'] = 0;
        }

        if(isset($_POST['active'])) {
            $_POST['active'] = 1;
        } else {
            $_POST['active'] = 0;
        }

        // Data handling
        $data = $_POST;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->banners->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->banners->single($id));
    }

    function ordenation() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("banners"));
        
        // Data handling
        $ids       = $_POST['ids'];                
        $status = $this->dependencies->banners->order($ids);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function clone() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("banners"));

        // Se o $_POST tiver um ID copia as informações todas desse banner para outro
        
        if (isset($_POST["id"])) {

            $clone      = $this->dependencies->banners->single($_POST["id"]);
            $clone->photo = '$clone->photo';

            if (!empty($clone)) {

                //Neste foreach estamos a introduzir os valores que nao temos no novo banner
                foreach ($clone as $key => $value) {

                    if (!isset($_POST[$key])) {

                        $_POST[$key] = $value;
                    }
                }
            }

            //Retirar o id do post
            unset($_POST["id"]);
            
        }   

        // Insert the data
        $status = $this->dependencies->banners->insert($_POST);
        
        if ($status["success"]) {
            
            $banner = $this->dependencies->banners->single($status["data"]);

            $this->response(true, "API REQUEST SUCCESS", $banner);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function delete($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->dependencies(array("banners"));

        $status = $this->dependencies->banners->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->banners->single($id));
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("banners"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->banners->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}
