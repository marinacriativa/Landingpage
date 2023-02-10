<?php 

/** 
*   Controller services ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class tickets extends \Fyre\Core\Controller {

    function index() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("tickets"), array());

        $page = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start = ($page - 1) * $limit;

        $tickets = $this->dependencies->tickets->multiple(null, $start, $limit, $search, $order);
        $total  = $this->dependencies->tickets->total(null, $search);

        $pagination = array (
            "page"      => (int) $page, 
            "limit"     => (int) $limit, 
            "total"     => (int) $total, 
            "start"     => (int) $start, 
        );
        if (empty($tickets)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $tickets, $pagination);

    }

    function ticketsByClient($clientId) {

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("tickets"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 5;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;

        $tickets = $this->dependencies->tickets->getTicketsByClient(null, $start, $limit, $search, $order, $clientId);
        if (empty($tickets)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $tickets);
    }

    function insert() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("tickets", "users", "ticket_messages"), array("email"));

        // Obter os administradores que recebem pedidos de contacto
        $idUser             = $_POST['idUser'];
        $message             = $_POST['ticket']['message'];
        $user = $this->dependencies->users->single($idUser);
        $email = $user->client_data->email;

        $dataTicket            = array(
            "user_id" => $idUser,
            "subject" => $_POST["ticket"]["subject"],
            "isSupport" => (int)$_POST['isSupport'],
        );

        $status = $this->dependencies->tickets->insert($dataTicket);

        if ($status["success"]) {

            $this->dependencies->tickets->edit(array("id" => $status["data"], "ticket_number" => $this->dependencies->tickets->randomTicketNumber()));

            $ticket = $this->dependencies->tickets->single($status["data"]);

            $id = (int)$ticket->id;

            $data_messages = (object)[
                "id_ticket" => $id,
                "id_sender" => $idUser,
                "message" => $message,
            ];

            $this->dependencies->ticket_messages->insert($data_messages);

            $data_email = array(
                "number_ticket" => $ticket->ticket_number,
                "name_client" => $user->client_data->name,
                "message" => $message,
                "subject" =>$ticket->subject,
                "status" =>$ticket->status,
                "date" =>$ticket->create_date,
                "link" => URL ."tickets/" . $ticket->id,
                "linkContact" => URL . $app->selected_language->code . "/contact",
                "other" => $app->config,
            );

            $data_email_admin = array(
                "number_ticket" => $ticket->ticket_number,
                "name_sender" => "Suporte",
                "message" => $message,
                "subject" =>$ticket->subject,
                "status" =>$ticket->status,
                "date" =>$ticket->create_date,
                "link" => URL ."adm/tickets/" . $ticket->id,
                "linkContact" => URL . $app->selected_language->code . "/contact",
                "other" => $app->config,
            );

            // Obter os administradores
            $emails   = $this->dependencies->users->getEmailsForNotifications("notification_new_ticket");

            if (!empty($emails)|| !empty($email)) {

                // Enviar os emails
                $this->dependencies->library->email->send($user->client_data->email, json_decode($app->config->title, true)[$app->selected_language->code] . " - " . $ticket->subject, "emailTicketSendByAdmin", $data_email);
                $this->dependencies->library->email->send($emails, "Abertura de novo ticket", "emailConfirmationTicketAdmin", $data_email_admin);
            }
            $this->response(true, "API REQUEST SUCCESS");
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function messagesByTicket($id){

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("ticket_messages"), array());

        $page       = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
        $limit      = (isset($_GET["length"])) ? intval($_GET["length"]) : 50;
        $search     = (isset($_GET["search"])) ? $_GET["search"] : null;
        $order      = (isset($_GET["order"])) ? $_GET["order"] : "id";
        $start      = ($page - 1) * $limit;

        $messages = $this->dependencies->ticket_messages->getMessagesByTicket(null, $start, $limit, $search, $order, $id);
        if (empty($messages)) {

            $this->response(true, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $messages);
    }


    function single($id) {
        
        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("tickets"), array());

        // Product array
        $tickets = $this->dependencies->tickets->single($id);

        if (empty($tickets)) {

            $this->response(false, "API REQUEST EMPTY");
        }

        $this->response(true, "API REQUEST SUCCESS", $tickets);
    }

    function editStatus($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("tickets"));

        // Data handling
        $data       = $_POST;
        $data["id"] = $id;

        // Edit the data
        $status = $this->dependencies->tickets->edit($data);

        // Send json response
        $this->response(true, "API REQUEST SUCCESS", $this->dependencies->tickets->single($id));
    }

    function delete($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("tickets"));

        // Delete the data
        $status_message = $this->dependencies->tickets->removeAllMessagesByTicket($id);
        $status = $this->dependencies->tickets->remove($id);
        if ($status["success"] && $status_message == true) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->tickets->single($id));
        }

        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function deleteMultiple() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("tickets"));

        $status = false;

        if(isset($_POST['selected'])) {

            $status = $this->dependencies->tickets->removeSelected($_POST['selected']);
        }
        
        // Delete the data
        if ($status == true) {
            $this->response(true, "API REQUEST SUCCESS", 'Todos os selecionados foram excluído com sucesso!');
        }
        
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function insertMessage() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("ticket_messages", "tickets", "users"), array("email"));

        // Insert the data
        $status = $this->dependencies->ticket_messages->insert($_POST);

        if ($status["success"]) {

            $ticket = $this->dependencies->tickets->single($_POST['id_ticket']);           
            $user = $this->dependencies->users->single($ticket->user_id);
            $email = $user->client_data->email;
            $message = $this->dependencies->ticket_messages->single($status["data"]);


            $data_email = array(
                "number_ticket" => $ticket->ticket_number,
                "name" => $user->client_data->name,
                "message" => $_POST['message'],
                "subject" =>$ticket->subject,
                "status" =>$ticket->status,
                "date" =>$message->date,
                "link" => URL . "/tickets/" . $ticket->id,
            );

            // Enviar os email
            $this->dependencies->library->email->send($email, "Resposta ao Ticket " . $ticket->ticket_number, "emailTicketReplay", $data_email);


            $this->response(true, "API REQUEST SUCCESS", $message);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }


    function deleteMessage($id) {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_ADMIN_ONLY);

        // Dependencies
        $this->dependencies(array("ticket_messages"));

        // Delete the data
        $status = $this->dependencies->ticket_messages->remove($id);

        if ($status["success"]) {

            $this->response(true, "API REQUEST SUCCESS", $this->dependencies->ticket_messages->single($id));
        }

        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}



