<?php 

/** 
*   Controller jobs ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class jobs extends \Fyre\Core\Controller {

    function index() {
        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);        

        // Dependencies
        $this->dependencies(array("jobs"), array());

        $page       = (isset($_GET["page"]))    ? intval($_GET["page"])     : 1;
        $limit      = (isset($_GET["length"]))  ? intval($_GET["length"])   : 10;
        $search     = (isset($_GET["search"]))  ? $_GET["search"]           : null;
        $order      = (isset($_GET["order"]))   ? $_GET["order"]            : "order_by";
        $lang       = (isset($_GET["lang"]) && !empty($_GET["lang"])) ? $_GET["lang"] : $app->default_language->code;
        $start      = ($page - 1) * $limit;  

        $jobs   = $this->dependencies->jobs->multiple($lang, $start, $limit, $search, $order);
        $total  = $this->dependencies->jobs->total($lang, $search);

        if (empty($jobs)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $pagination = array (
            "page"      => (int) $page, 
            "limit"     => (int) $limit, 
            "total"     => (int) $total, 
            "start"     => (int) $start, 
        );

        $this->response(true, "API REQUEST SUCCESS", $jobs, $pagination);
    }

    function single($id)
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("jobs"), array());

        $job = $this->dependencies->jobs->single($id);

        if (empty($job)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        // Obter outras linguas disponiveis na noticia
        $job->related = $this->dependencies->jobs->getRelated($job->language_group, $job->id);

        $this->response(true, "API REQUEST SUCCESS", $job);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("jobs"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->jobs->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function changeStatus() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("jobs"));

        // Data handling
        $data       = $_POST;
        $id         = $data["id"];

        // Edit the data
        $status = $this->dependencies->jobs->changeStatus($data);

        if($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->jobs->single($id));
        }
        
        // Send json response
        $this->response(false, "API REQUEST FALSE");
    }

    function clone() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("jobs"));
        
        // Se o $_POST tiver um ID copia as informações todas desse produto para outro
        $galleryImg = false;
        if (isset($_POST["id"])) {            
            $clone          = $this->dependencies->jobs->single($_POST["id"]);       
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
        $status = $this->dependencies->jobs->insert($_POST);
        
        if ($status["success"]) {

            $job = $this->dependencies->jobs->single($status["data"]);          

            //Define o campo que vai agrupar as linguas todas do produto, 
            // é basicamente um MD5 do ID do produto na lingua default
            if (!isset($_POST["language_group"])) {
                $this->dependencies->jobs->edit(array("id" => $job->id, "language_group" => md5($job->id)));
            }             

            $this->response(true, "API REQUEST SUCCESS", $job);
        }
        
        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("jobs"));

        // Temos de definir a lingua principal do job
        if (!isset($_POST["lang"])) {
            
            $_POST["lang"] = $app->default_language->code;
        }

        if (isset($_POST["id"])) {
            $clone      = $this->dependencies->jobs->single($_POST["id"]);
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
             

        // Insert the data
        $status = $this->dependencies->jobs->insert($_POST);
        if ($status["success"]) {
            
            $job = $this->dependencies->jobs->single($status['data']);

            if (!isset($_POST["language_group"])) {
                $this->dependencies->jobs->edit(array("id" => $job->id, "language_group" => md5($job->id)));
            }    

            $this->response(true, "API REQUEST SUCCESS", $job);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
    
    function edit($id) {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("jobs"));
        
        // Data handling
        $data       = $_POST;
        $data["id"] = $id;

        
        // Edit the data
        $status = $this->dependencies->jobs->edit($data);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function ordenation() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("jobs"));
        
        // Data handling
        $ids       = $_POST['ids'];   
        $status = $this->dependencies->jobs->order($ids);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }
    
    function associateProductCron () {

        $this->dependencies(array("jobs", "products", "categories"));
        
        // get data 
        $jobs   = $this->dependencies->jobs->all();
        $categories     = $this->dependencies->categories->multiple();

        foreach ($jobs as $cat) {  

            $filter = $this->dependencies->products->getByFilter($cat->id);  

            if(!empty($filter)) { 
                $this->dependencies->jobs->associateProduct($cat->id, 1);
            } else { 
                $this->dependencies->jobs->associateProduct($cat->id, 0);
            }           

        }

        foreach ($categories as $cat) {  

            $filter = $this->dependencies->products->getByCategory($cat->id);  

            if(!empty($filter)) { 
                $this->dependencies->categories->associateProduct($cat->id, 1);
            } else { 
                $this->dependencies->categories->associateProduct($cat->id, 0);
            }           

        }

        echo "<center><h2> Filtros atualizadas com sucesso! </h2> <br> <h4> Feche esta aba. </h4></center>";

    }

    function orderASC() {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("jobs"));
        
        // get data by alphabetical order 
        $multiple = $this->dependencies->jobs->orderASC();
        $allIds = [];
        if ($multiple) {
            foreach ($multiple as $multi) {
                $allIds[] = $multi->id;
            }
            $new_positions = implode(",", $allIds);            
            $this->dependencies->jobs->order($new_positions);  

            $this->response(true, "API REQUEST SUCCESS");
        }
        $this->response(false, "API REQUEST ERROR", $multiple);
    }
    
    function delete($id) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("jobs"));
        
        // Delete the data
        $status = $this->dependencies->jobs->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS");
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}