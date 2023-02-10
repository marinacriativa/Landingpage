<?php 

/** 
*   Controller newsletter ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class newsletter extends \Fyre\Core\Controller {

    function index() {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("newsletter"), array());

        $page       = (isset($_GET["page"]))    ? intval($_GET["page"])     : 1;
        $limit      = (isset($_GET["length"]))  ? intval($_GET["length"])   : 50;
        $order      = (isset($_GET["order"]))   ? $_GET["order"]            : "date";

        $start      = ($page - 1) * $limit;  

        $newsletter = $this->dependencies->newsletter->multiple($start, $limit);
        $total      = $this->dependencies->newsletter->total();

        $pagination = array (
            "page"      => (int) $page, 
            "limit"     => (int) $limit, 
            "total"     => (int) $total, 
            "start"     => (int) $start, 
        );

        if (empty($newsletter)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $newsletter, $pagination);
    }
        
    function single($id) {
        
        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("newsletter"), array());

        // Product array
        $newsletters = $this->dependencies->newsletter->single($id);

        if (empty($newsletters)) {
            
            $this->response(false, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $newsletters);
    }

    function multiple() {
        
        global $app;
     
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("newsletter"), array());

        // Product array
        $newsletters = $this->dependencies->newsletter->multiple();
        
        if (empty($newsletters)) {
            
            $this->response(false, "API REQUEST EMPTY");
        }

        $headers = array('ID :', 'Email :', 'IP :', 'Idioma :', 'Data :');
        $array = [];
        foreach ($newsletters as $value) {
            $array[] = [
                'ID' => $value->id,
                'Email' => $value->email,
                'IP' => $value->ip,
                'Idioma' => $value->lang,
                'Data' => date('d/m/Y H:i:s', strtotime($value->date)),
            ];
        }        

        $rows = $array;

        // Create file and make it writable

        $file = fopen('newsletters.csv', 'w');

        // Add BOM to fix UTF-8 in Excel

        fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

        // Headers
        // Set ";" as delimiter

        fputcsv($file, $headers, ";");

        // Rows
        // Set ";" as delimiter

        foreach ($rows as $row) {

            fputcsv($file, $row, ";");
        }

        // Close file

        fclose($file);

        // Send file to browser for download

        $dest_file = 'newsletters.csv';
        $file_size = filesize($dest_file);

        header("Content-Type: text/csv; charset=utf-8");
        header("Content-disposition: attachment; filename=\"newsletters.csv\"");
        header("Content-Length: " . $file_size);
        readfile($dest_file);
    }

    function delete($id) {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("newsletter"));
        
        // Delete the data
        $status = $this->dependencies->newsletter->remove($id);
        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->newsletter->single($id));
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function insert() {
        
        global $app;
        
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);
        
        // Dependencies
        $this->dependencies(array("newsletter"), array());
        
        $status = $this->dependencies->newsletter->insert($_GET);
        
        $this->raw_response($status);
    }
    /* TODO EXPORT EXCEL */

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("newsletter"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->newsletter->removeSelected($_POST['selected']);
        }
        // Delete the data

        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}