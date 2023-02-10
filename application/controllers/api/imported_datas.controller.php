<?php 

/** 
*   Controller imported_datas ( API )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;



class imported_datas extends \Fyre\Core\Controller {

   

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("imported_datas", "historic_imported_datas"));  

        $file = $_FILES['file_input']['tmp_name'];       
    
        # Create a new Xls Reader
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();

        // Tell the reader to only read the data. Ignore formatting etc.
        $reader->setReadDataOnly(true);

        // Read the spreadsheet file.
        $spreadsheet = $reader->load($file);       

        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        
        $data = $sheet->toArray();
        $stringSql = '';
        // output the data to the console, so you can see what there is.
        foreach($data as $key => $value) {
            if($key != 0) {       
                if ($key === array_key_last($data)){
                    $stringSql .= '("'. $value[0] .'","'. $value[1] .'","'. $value[2] .'","'. $value[3] .'");';
                } else {
                    $stringSql .= '("'. $value[0] .'","'. $value[1] .'","'. $value[2] .'","'. $value[3] .'"), ';
                }                 
            }          
        }

        //deletar todos dados antigos
        $this->dependencies->imported_datas->delete_all(); 
        
        //inserir novos dados
        $this->dependencies->imported_datas->insert_all($stringSql);      
        
        //salvar histórico
        $historic = [
            'user' => intval($this->user['id']),
            'name' => $_FILES['file_input']['name'],
            'data' => date('d/m/Y H:i'),
        ];

        $this->dependencies->historic_imported_datas->insert($historic);     

        $this->response(true, "API REQUEST SUCCESS");

    }


    function get($text) {
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("imported_datas"), array());

        $imported_datas = $this->dependencies->imported_datas->search($text);
        
        if (empty($imported_datas)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

        $this->response(true, "API REQUEST SUCCESS", $imported_datas);
    }

    function getHistoric() {
        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("historic_imported_datas", "users"), array());

        $historic = $this->dependencies->historic_imported_datas->listing();
        
        if (empty($historic)) {

            $this->response(true, "API REQUEST EMPTY");
        } 

     
        foreach ($historic as $hst){
            $user = $this->dependencies->users->single($hst->user);
            $hst->user = $user->client_data->name;
        }
       

        $this->response(true, "API REQUEST SUCCESS", $historic);
    }
}
