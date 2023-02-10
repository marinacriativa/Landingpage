<?php 

/** 
*   Controller main ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class pages extends \Fyre\Core\Controller {

    function editor($id) {

        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $pageLink = "/adm/editor/raw/" . $id;

        include(ROOT . "public/static/editor/editor.php");
    }

    function editor_raw($id) {

        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->dependencies(array("pages"), array());

        $pages = $this->dependencies->pages->single($id);

        // conteudo da pagina a partir da database        // 
        $content_html = $pages->content;

        $type = 'pages';

        $html = $this->template("pages/preview-pages", array("content_html" => $content_html, "type" => $type, "page_id" => $id));

        echo $html;
    }


    function index() {
        // Dependencies
        $this->dependencies(array("pages"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;

        $pages = $this->dependencies->pages->multiple(null, $start, $limit, $search, $order);

        $this->backoffice("pages/pages/index", array("pages" => $pages));
        exit();

        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("pages"), array());
        
        // Init pages array
        $pages = array();
        
        // Pagination
        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : null;
        $start      = ($page - 1) * $limit;  
        
        foreach ($app->languages as $language) {
            
            $pages[$language["code"]]            = $this->dependencies->pages->multiple($language["code"], $start, $limit, $search, $order);
            $total[$language["code"]]["count"]      = $this->dependencies->pages->total($language["code"], $search, $order);
            $total[$language["code"]]["pages"]      = ceil($total[$language["code"]]["count"] / $limit);
            $total[$language["code"]]["page"]       = $page;
        }
        
        $this->backoffice("pages/pages/index", array("pages" => $pages, "total" => $total, "query" => http_build_query($_GET)));
    }

    function single($id) {
        $this->backoffice("pages/pages/page", ['id' => $id]);
        exit();
    }

    function edit($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("pages"));

        // Data handling
        $data       = $_GET;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->pages->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->pages->single($id));
    }
}