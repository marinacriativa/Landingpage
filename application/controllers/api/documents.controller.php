<?php

/**
 *   Controller documents ( Backoffice )
 *
 *   Extends: core/Controller.php
 *   Author: Vlad
 **/

namespace Fyre\Controller;

class documents extends \Fyre\Core\Controller
{

    function index()
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("documents"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 10;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"]))   ? $_GET["order"]            : "id";
        $start      = ($page - 1) * $limit;
    
        
        $documents = $this->dependencies->documents->multiple($start, $limit, $search, $order);
        $total = $this->dependencies->documents->total($search);      
        
        $pagination = array (
            "page" => (int) $page,
            "limit" => (int) $limit,
            "total" => (int) $total,
            "start" => (int) $start,
        );

        if (empty($documents)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $documents, $pagination);

    }

    function single($id)
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("documents"), array());

        $page = $this->dependencies->documents->single($id);

        if (empty($page)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $page);
    }

    function edit($id)
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("documents"));

        // Data handling
        
        $_POST['id'] = $id;
        $_POST['name'] = $_FILES["file"]["name"];

        if(isset($_FILES['file'])) {
            $file = $_FILES['file'];

            $fileName = $_FILES['file']['name'];
            $fileTmpName = $_FILES['file']['tmp_name'];
            $fileSize = $_FILES['file']['size'];
            $fileError = $_FILES['file']['error'];
            $fileType = $_FILES['file']['type'];

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allowed = array('jpg', 'jpeg', 'png', 'pdf');                        

           // var_dump($fileActualExt); die;
            if(in_array($fileActualExt, $allowed)) {
                if($fileError === 0) {
                    if($fileSize < 50000000) { // file size = 50mb
                        $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                        $fileDestination = ROOT . 'public/static/documents/' . $fileNameNew;
                        $_POST['file'] = $fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);   
                        if (!empty($_FILES["file"])) {
                            $myf[] = array("name" => $fileNameNew, "path" => $fileDestination);
                        } 

                        
                        $fileDestination = str_replace(ROOT . "public", "", $fileDestination);                      

                        $_POST['url'] = $fileDestination;

                        // Edit the data
                        $status = $this->dependencies->documents->edit($_POST);
                        
                        // Send json response
                        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->documents->single($id));   

                    } else { 
                        $this->response(false, "API REQUEST ERROR", "Arquivo muito grande!");

                    }
                } else {
                    $this->response(false, "API REQUEST ERROR", "Falha no upload, tente novamente.");
                }
            } elseif($fileActualExt != "") {
                $this->response(false, "API REQUEST ERROR", "Somente são permitidos arquivos jpg, jpeg, png e pdf.");
            }

        } else {
            $this->response(false, "API REQUEST ERROR", 'Nenhum arquivo foi enviado.');
        }
    
    }

    function changeStatus() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("documents"));

        // Data handling
        $data       = $_POST;
        $id         = $data["id"];

        // Edit the data
        $status = $this->dependencies->documents->changeStatus($data);

        if($status == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->documents->single($id));
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
        $this->dependencies(array("documents"));          
    
        
        if(isset($_FILES['file'])) {
            $_POST['name'] = $_FILES["file"]["name"];
            $file = $_FILES['file'];

            $fileName = $_FILES['file']['name'];
            $fileTmpName = $_FILES['file']['tmp_name'];
            $fileSize = $_FILES['file']['size'];
            $fileError = $_FILES['file']['error'];
            $fileType = $_FILES['file']['type'];

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'mp4', 'mkv');                        

           // var_dump($fileActualExt); die;
            if(in_array($fileActualExt, $allowed)) {
                if($fileError === 0) {
                    if($fileSize < 50000000) { // file size = 50mb
                        $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                        $fileDestination = ROOT . 'public/static/documents/' . $fileNameNew;
                        $_POST['file'] = $fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);   
                        if (!empty($_FILES["file"])) {
                            $myf[] = array("name" => $fileNameNew, "path" => $fileDestination);
                        } 
                        
                        $fileDestination = str_replace(ROOT . "public", "", $fileDestination);                      

                        $_POST['url'] = $fileDestination;

                       

                         // Insert the data
                        $status = $this->dependencies->documents->insert($_POST);
               
                        // Send json response
                        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->documents->single($status['data']));   

                    } else { 
                        $this->response(false, "API REQUEST ERROR", "Arquivo muito grande!");

                    }
                } else {
                    $this->response(false, "API REQUEST ERROR", "Falha no upload, tente novamente.");
                }
            } elseif($fileActualExt != "") {
                $this->response(false, "API REQUEST ERROR", "Somente são permitidos arquivos jpg, jpeg, png e pdf.");
            }

        } else {
            $this->response(false, "API REQUEST ERROR", 'Nenhum arquivo foi enviado.');
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
        $this->dependencies(array("documents"));
        
        $status = $this->dependencies->documents->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->documents->single($id));
        }

        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("documents"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->documents->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}