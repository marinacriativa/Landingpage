<?php 

/** 
*   Controller menus ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class menus extends \Fyre\Core\Controller {    

    function index() { 

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $lang = (isset($_GET["lang"]) && !empty($_GET["lang"])) ? $_GET["lang"] : $app->default_language->code;
    
        // Dependencies
        $this->dependencies(array("menus"), array());

        $menus   = $this->dependencies->menus->multiple($lang);

        if (empty($menus)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $menus);
    }

    function single($id) {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("menus"), array());

        $menus = $this->dependencies->menus->single($id);
        
        if (empty($menus)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

        $this->response(true, "API REQUEST SUCCESS", $menus);
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("menus"));

        switch ($_POST) {
            case $_POST['type']:
                $_POST['type'] = intval($_POST['type']);
                break;
            
            case $_POST['parent']:
                $_POST['parent'] = intval($_POST['parent']);
                break;
        }

        if(isset($_POST['related_id']) && $_POST['related_id'] != '') {
            $_POST['related_id'] = intval($_POST['related_id']);                   
        } else {
            unset($_POST['related_id']);                  
        }

        if(isset($_POST['doc_or_page']) && $_POST['doc_or_page'] != '') {
            $_POST['doc_or_page'] = intval($_POST['doc_or_page']);                   
        } else {
            unset($_POST['doc_or_page']);                  
        }

   
        
    
        // Insert the data
        $status = $this->dependencies->menus->insert($_POST);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS");
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
    
    function edit($id) {
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("menus"));
        
        // Data handling
        $data       = $_POST;
        $data["id"] = $id;

        if(isset($data['related_id']) && $data['related_id'] != '') {
            $data['related_id'] = intval($data['related_id']);                   
        } else {
            unset($data['related_id']);                  
        }

        if(isset($data['doc_or_page']) && $data['doc_or_page'] != '') {
            $data['doc_or_page'] = intval($data['doc_or_page']);                   
        } else {
            unset($data['doc_or_page']);                  
        }

        // Edit the data
        $status = $this->dependencies->menus->edit($data);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function active() {
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("menus"));        

        // Edit the data
        $status = $this->dependencies->menus->edit($_POST);
        
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }
    
    function delete($id) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("menus"));

        $childrens = $this->dependencies->menus->multipleByParent($id);

        if($childrens != null && !empty($childrens)) {
            //deletar filhos
            $this->dependencies->menus->deleteAllByParent($id);
        }

        // Delete the data
        $status = $this->dependencies->menus->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS");
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function ordenation() {

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("menus"));
        
        
        // Data handling
        $ids       = $_POST['ids'];        
        foreach($ids as $id) {
            $status = $this->dependencies->menus->edit($id);
        }
        // Send json response 
        $this->response(true, "API REQUEST SUCCESS");
    }

    function searchAjax() {
        
        global $app;
        
        // Dependencies
        $this->dependencies(array("documents", "pages"), array());

        //Filtros

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
   
        $status = 2;

        $resultSearch = [];

        /* TODO PAGINAÇÃO */
        $documents = $this->dependencies->documents->listingAll(null, null, $search, null, $status);
        $pages = $this->dependencies->pages->listingAll($app->selected_language->code, null, null, $search, null, $status);
        
       
        foreach ($documents as $key => $doc) {
            $result['id'] = $doc->id;
            $result['name'] = $doc->name;
            $result['edit'] = false;
            $result['type'] = 'Ficheiro: ';
            $result['url'] = $doc->url;
            $result['related'] = 0;
            $resultSearch[] = $result;
        }
   

        foreach ($pages as $key => $pag) {  
            $result['id'] = $pag->id;    
            $result['name'] = $pag->name;
            $result['edit'] = '/adm/pages/' . $pag->id;
            $result['type'] = 'Página: ';
            $result['url'] = 'pages/' . $pag->url;
            $result['related'] = 1;
            $resultSearch[] = $result;
        }      
   
       
        $this->response(true, "API REQUEST SUCCESS", $resultSearch);
    }
}