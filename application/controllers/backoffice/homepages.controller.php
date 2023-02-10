<?php 

/** 
*   Controller main ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class homepages extends \Fyre\Core\Controller {


    function index() {
        global $app;

        $lang = (isset($_GET["lang"]) && !empty($_GET["lang"])) ? $_GET["lang"] : $app->default_language->code;

        // Dependencies
        $this->dependencies(array("homepages"), array());
        
        $homepages = $this->dependencies->homepages->multiple($lang);

        $this->backoffice("pages/homepage/index", array("homepages" => $homepages));
    }

    function editorH($id) {

        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $pageLink = "/adm/homepages/editor/raw/" . $id;

        include(ROOT . "public/static/editor/editor.php");
    }
    
    function editorH_raw($id) {

        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        $this->dependencies(array("homepages"), array());

        $homepages = $this->dependencies->homepages->single($id);

        // conteudo da pagina a partir da database        // 
        $content_html = $homepages->content;

        $type = 'homepage';

        $html = $this->template("pages/preview-pages", array("content_html" => $content_html, "type" => $type,"page_id" => $id));

        echo $html;
    }

}