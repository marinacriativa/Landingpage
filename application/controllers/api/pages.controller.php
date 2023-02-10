<?php

/**
 *   Controller pages ( Backoffice )
 *
 *   Extends: core/Controller.php
 *   Author: Vlad
 **/

namespace Fyre\Controller;

class pages extends \Fyre\Core\Controller
{

    function index()
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("pages"), array());

        $page = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit = (isset($_GET["length"])) ? intval($_GET["length"]) : 10;
        $search = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $lang       = (isset($_GET["lang"]) && !empty($_GET["lang"])) ? $_GET["lang"] : $app->default_language->code;
        $start = ($page - 1) * $limit;
        
        $pages   = $this->dependencies->pages->multiple($lang, $start, $limit, $search, $order);
        $total  = $this->dependencies->pages->total($lang, $search);


        $pagination = array(
            "page" => (int)$page,
            "limit" => (int)$limit,
            "total" => (int)$total,
            "start" => (int)$start,
        );

        if (empty($pages)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $pages, $pagination);

    }

    function single($id)
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("pages"), array());

        $page = $this->dependencies->pages->single($id);

        if (empty($page)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        $page->related = $this->dependencies->pages->getRelated($page->language_group, $page->id);

        $this->response(true, "API REQUEST SUCCESS", $page);
    }

    function edit($id)
    {
        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("pages"));

        // Data handling

        $_POST['id'] = $id;
        if(isset($_POST['url'])) {           
            $check_slug = $this->dependencies->pages->check_slug($id, $_POST['url']);
            if($check_slug === false) 
                $this->response(false, "API REQUEST ERROR", ['msg' => 'Este slug já existe.']);
        }

        // Edit the data
        $status = $this->dependencies->pages->edit($_POST);
        
        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->pages->single($id));

    }

    function changeStatus() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("pages"));

        // Data handling
        $data       = $_POST;
        $id         = $data["id"];

        // Edit the data
        $status = $this->dependencies->pages->changeStatus($data);

        if($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->pages->single($id));
        }
        
        // Send json response
        $this->response(false, "API REQUEST FALSE");
    }

    function insert()
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("pages"));

        // Vereficar se está a inserir uma notícia "rascunho"
        if (isset($_POST["draft"]) && $_POST["draft"] == "1") {

            $draft = $this->dependencies->pages->getDraft();

            if (!empty($draft)) {

                // A API dá return da noticia rascunho, depois desta função o codigo nao executa mais
                $this->response(true, "API REQUEST SUCCESS", $draft);
            }
        }

        // Temos de definir a lingua principal da noticia
        if (!isset($_POST["lang"])) {

            $_POST["lang"] = $app->default_language->code;
        }


        
        // Se o $_POST tiver um id é para copiar as informações todas dessa noticia para a noticia nova
        if (isset($_POST["id"])) {

            $clone = $this->dependencies->pages->single($_POST["id"]);
            
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

        // Insert the data
        $status = $this->dependencies->pages->insert($_POST);

        if ($status["success"]) {

            // Definir o campo que vai agrupar as linguas todas da noticia
            // É basicamente um MD5 do ID da noticia na lingua default
            if (!isset($_POST["language_group"])) {
                
                $this->dependencies->pages->edit(array("id" => $status["data"], "language_group" => md5($status["data"])));
            }

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->pages->single($status["data"]));
        }
        
        // Send json response 
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function clone() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("pages"));

        // Se o $_POST tiver um ID copia as informações todas desse produto para outro
        
        if (isset($_POST["id"])) {

            $clone      = $this->dependencies->pages->single($_POST["id"]);

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
        $status = $this->dependencies->pages->insert($_POST);
        
        if ($status["success"]) {

            //Define o campo que vai agrupar as linguas todas do produto, 
            // é basicamente um MD5 do ID do produto na lingua default
            if (!isset($_POST["language_group"])) {
                $this->dependencies->pages->edit(array("id" => $status["data"], "language_group" => md5($status["data"])));
            }
            
            $product = $this->dependencies->pages->single($status["data"]);

            //Copiar os atributos
            if (!empty($attributes)) {

                foreach($attributes as $key => $value) {
                    
                    // Remover id do atributo
                    unset($value->id);

                    // Adicionar id do produto novo
                    $value->id_page = $pages->id;

                    $this->dependencies->attributes->insert($value);
                }
            }

            $this->response(true, "API REQUEST SUCCESS", $product);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function delete($id)
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("pages"));

        // Delete the data
        $status = $this->dependencies->pages->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->pages->single($id));
        }

        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("pages"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->pages->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}