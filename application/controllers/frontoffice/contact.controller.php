<?php 

/** 
* Controller contact ( Backoffice ) 
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class contact extends \Fyre\Core\Controller {
    
    function contact() {
        global $app;
        $website_config = $app->config;

        // Dependencies
        $this->dependencies(array("users", "custom_info"), array());

        $admins  = $this->dependencies->users->multiple(null, 0, 100, null, null, 2);

        $custom_info = $this->dependencies->custom_info->singleLang($app->select_language);

        echo $this->template("pages/contact", compact('website_config', 'admins', "custom_info"));
    }

    function consult() {
        global $app;
        $website_config = $app->config;
        echo $this->template("pages/consult_form", compact('website_config'));
    }
    
    function contact_post() {
        
        global $app;
        
        // Dependencies
        $this->dependencies(array("contacts", "users", "notifications"), array("email"));

        // GOOGLE RECAPTCHA
        if (isset($_POST["g-recaptcha-response"]) && !empty($_POST["g-recaptcha-response"])) {
            
            $google_recaptcha = $_POST["g-recaptcha-response"];
            
            $url        = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $app->config->recaptcha_secret_key . '&response=' . $google_recaptcha;
            $curl       = curl_init();
            
            curl_setopt($curl, CURLOPT_URL,             $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,  true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,  0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,  0);
            curl_setopt($curl, CURLOPT_HEADER,          false);
            
            $data      = curl_exec($curl);
                         curl_close($curl);
            $result    = json_decode($data);
         
            if ($result->success) {
                
                unset($_POST["g-recaptcha-response"]);
                
                foreach ($_POST as $key => $post) {
                    
                    $_POST[$key] = filter_var($post, FILTER_SANITIZE_STRING);
                }
                
                $files = null;
                $emails = [];                
                // Suportar ficheiros
                if (!empty($_FILES["files"])) {
                    
                    $files = array();
                    
                    foreach ($_FILES["files"]["name"] as $key => $file) {
                        
                        $files[] = array("name" => $file, "path" => $_FILES["files"]["tmp_name"][$key]);
                    }
                }

                if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    if ($app->config->can_choose_collaborator_for_contact_page == "true" 
                    && isset($_POST['collaborator'])
                    && !empty($_POST['collaborator'])) {
                        $id = intval($_POST['collaborator']);
                        $admin = $this->dependencies->users->single($id);
                            
                        if (!empty($admin->client_data) && $admin->client_data->type == 2) {

                            $data_notification = array(
                                "id_user" => $admin->client_data->id,
                                "type" => "contact",
                                "link" => URL . "adm/contacts/",
                            );

                            $this->dependencies->notifications->insert($data_notification);
                            $emails[] = $admin->client_data->email;
                          
                        }

                    } else {

                        //Criar notificação de novo Contacto
                        $admins = $this->dependencies->users->getAdmins();

                        foreach ($admins as $id) {

                            $data_notification = array(
                                "id_user" => $id,
                                "type" => "contact",
                                "link" => URL . "adm/contacts/",
                            );

                            $this->dependencies->notifications->insert($data_notification);
                        }

                        // Obter os administradores que recebem pedidos de contacto
                        $emails = $this->dependencies->users->getEmailsForNotifications("notification_new_contact");
                    }

                    if(isset($_POST['email'])) {
                        $emails[] = $_POST['email'];
                    }

                    // Enviar os emails
                    $this->dependencies->library->email->send($emails, "Novo pedido de contacto", "emailContactRequest", $_POST, $files);

                    $this->response(true, "API REQUEST SUCCESS", $this->dependencies->contacts->insert($_POST));

                }else {

                    $this->response(false, "Email invalido");
                }

            } else {
                
                $this->response(false, "GOOGLE RECAPTCHA ERROR");
            }
        
        } else {

            $this->response(false, "GOOGLE RECAPTCHA ERROR");
        }
    }


    function booking_post() {
        
        global $app;
        
        // Dependencies
        $this->dependencies(array("contacts", "users", "notifications", "info_form"), array("email"));

        // GOOGLE RECAPTCHA
        if (isset($_POST["g-recaptcha-response"]) && !empty($_POST["g-recaptcha-response"])) {
            
            $google_recaptcha = $_POST["g-recaptcha-response"];
            
            $url        = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $app->config->recaptcha_secret_key . '&response=' . $google_recaptcha;
            $curl       = curl_init();
            
            curl_setopt($curl, CURLOPT_URL,             $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,  true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,  0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,  0);
            curl_setopt($curl, CURLOPT_HEADER,          false);
            
            $data      = curl_exec($curl);
                         curl_close($curl);
            $result    = json_decode($data);
         
            if ($result->success) {
                
                unset($_POST["g-recaptcha-response"]);
                
                foreach ($_POST as $key => $post) {
                    
                    $_POST[$key] = filter_var($post, FILTER_SANITIZE_STRING);
                }
                
                $files = null;
                $emails = [];                
                // Suportar ficheiros
                $myf = array();          
                if(isset($_FILES['files'])) {
                    $file = $_FILES['files'];                

                    $fileName = $_FILES['files']['name'];
                    $fileTmpName = $_FILES['files']['tmp_name'];
                    $fileSize = $_FILES['files']['size'];
                    $fileError = $_FILES['files']['error'];
                    $fileType = $_FILES['files']['type'];

                    $fileExt = explode('.', $fileName);
                    $fileActualExt = strtolower(end($fileExt));

                    $allowed = array('jpg', 'jpeg', 'png', 'pdf');                        

                    if(in_array($fileActualExt, $allowed)) {
                        if($fileError === 0) {
                            if($fileSize < 500000) {
                                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                                $fileDestination = ROOT . 'public/static/uploads/' . $fileNameNew;
                                $_POST['attachment'] = $fileNameNew;
                                move_uploaded_file($fileTmpName, $fileDestination);   
                                if (!empty($_FILES["files"])) {
                                    $myf[] = array("name" => $fileNameNew, "path" => $fileDestination);
                                }                                 
                            } else {
                                header("Location: /". $app->selected_language->code ."/booking?&error=Arquivo muito grande!".$save_url);                                     
                            }
                        } else {
                            header("Location: /". $app->selected_language->code ."/booking?&error=Falha no upload, tente novamente.".$save_url); 
                        }
                    } elseif($fileActualExt != "") {
                        header("Location: /". $app->selected_language->code ."/booking?&error=Somente são permitidos arquivos jpg, jpeg, png e pdf.".$save_url); 
                    }

                }

                if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    //Criar notificação de novo Contacto
                    $admins = $this->dependencies->users->getAdmins();

                    foreach ($admins as $id) {

                        $data_notification = array(
                            "id_user" => $id,
                            "type" => "contact",
                            "link" => URL . "adm/contacts/",
                        );

                        $this->dependencies->notifications->insert($data_notification);
                    }

                    // Obter os administradores que recebem pedidos de contacto
                    $emails = $this->dependencies->users->getEmailsForNotifications("notification_new_contact");

                    if(isset($_POST['email'])) {
                        $emails[] = $_POST['email'];
                    }
          
                    // Enviar os emails
                    $this->dependencies->library->email->send($emails, "Nova solicitação de inscrição", "emailBookingRequest", $_POST, 0, $myf);

                    $this->response(true, "API REQUEST SUCCESS", $this->dependencies->info_form->insert($_POST));

                }else {

                    $this->response(false, "Email invalido");
                }

            } else {
                
                $this->response(false, "GOOGLE RECAPTCHA ERROR");
            }
        
        } else {

            $this->response(false, "GOOGLE RECAPTCHA ERROR");
        }
    }

}