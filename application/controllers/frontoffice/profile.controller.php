<?php

/**
 * Controller main ( Backoffice )
 *
 *   Extends: core/Controller.php
 *   Author: Pseudo Serginho
 **/

namespace Fyre\Controller;

class profile extends \Fyre\Core\Controller
{

    function profile()
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_LOGGED_USER_ONLY);

        $this->dependencies(array("orders", "orderStatus", "translation", "countries"), array());

        $orders         = $this->dependencies->orders->getOrdersByClient($this->user["id"]);
        $orderStatus    = $this->dependencies->orderStatus->multiple();
        $lang           = $this->dependencies->translation->singleByCode($app->selected_language->code);
        $countries      = $this->dependencies->countries->multiple(0);
       
        echo $this->template("pages/profile/page", compact("orders", "orderStatus", "countries"));
    }

    function edit($id)
    {
        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_LOGGED_USER_ONLY);

        // Dependencies
        $this->dependencies(array("users"));

        $data = $_POST;
        $data["id"] = $id;

        // Insert the data
        $status = $this->dependencies->users->edit($data);

        if ($status["success"]) {

            $user = $this->dependencies->users->single($id);

            header("Location: /profile");
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);

    }

    function ordersIndex() {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_LOGGED_USER_ONLY);

        $this->dependencies(array("orders", "orderStatus", "translation", "countries"), array());
        $orders = $this->dependencies->orders->getOrdersByClient($this->user["id"]);
        $orderStatus    = $this->dependencies->orderStatus->multiple();
        $lang           = $this->dependencies->translation->singleByCode($app->selected_language->code);

        echo $this->template("pages/profile/orders/index", compact("orders", "orderStatus"));
    }

    function ordersDetails($id)
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_LOGGED_USER_ONLY);

        $this->dependencies(array("orders", "orderStatus", "personalization_items", "advanced_products", "personalization", "payment", "shipping", "translation"), array());

        $order = $this->dependencies->orders->singleAll($id);
        
        if ($order->order_data->user_id !== $this->user["id"]) {

            // Erro no checkout
            header("Location: /orders");
            exit();
        }

        foreach ($order->order_products_data as $product) {
            $personalization = json_decode($product->personalization);
            $personalization_item_array = array();
            if ($product->type == 2) {
                foreach ($personalization as $key => $item_personalization) {
                    $item = $this->dependencies->personalization_items->single($item_personalization);
                    $group = $this->dependencies->personalization->single($key);
                    $personalization_item = (object)array(
                        'item' => $item,
                        "group" => $group,
                    );

                    array_push($personalization_item_array, $personalization_item);

                    $product->personalization = $personalization_item_array;
                }
            }
            if ($product->type == 1) {
                $item = $this->dependencies->advanced_products->single($personalization);
                $product->personalization = $item;
            }
        }

        if (empty($order->order_data)) {

            // Erro no checkout
            header("Location: /orders");
            exit();
        }

        $status = $this->dependencies->orderStatus->byLang($order->order_data->lang);
        $payment_method = $this->dependencies->payment->single($order->order_data->method);
        $shipping = $this->dependencies->shipping->single($order->order_data->shipping);
        $order->order_status_data = $status;

        $order->order_data->lang = $app->selected_language->code;
        $lang = $this->dependencies->translation->singleByCode($order->order_data->lang);

        $isPaid = $order->order_data->payment_status;


        $order->order_data->method = $payment_method->name;
        $order->order_data->shipping = $shipping->title;

        echo $this->template("pages/profile/orders/details", compact("order"));
    }

    function tickets()
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_LOGGED_USER_ONLY);

        $this->dependencies(array("tickets"), array());

        $idUser = $this->user["id"];

        $tickets = $this->dependencies->tickets->getTicketsByClient(null, null, null, null, null, $idUser);

        echo $this->template("pages/profile/tickets/index", compact("tickets"));
    }

    function ticketsDetails($id)
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_LOGGED_USER_ONLY);

        $this->dependencies(array("tickets", "ticket_messages"), array());

        $ticket = $this->dependencies->tickets->single($id);

        $idUser = $this->user["id"];
        $userType = $this->user["type"];
        $idTicketUser = $ticket->user_id;

        if($userType !== "2" && $idUser !== $idTicketUser){

            $app->redirect("/");
        }

        $ticket = $this->dependencies->tickets->single($id);

        $ticket_messages = $this->dependencies->ticket_messages->getMessagesByTicket(null, null, null, null, null, $id);

        echo $this->template("pages/profile/tickets/details", compact("ticket", "idUser", "ticket_messages"));
            
    }

    function insertTicket()
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_LOGGED_USER_ONLY);

        // Dependencies
        $this->dependencies(array("tickets", "ticket_messages", "users", "notifications"), array("email"));

        // Obter os administradores que recebem pedidos de contacto
        $email = $this->user["email"];
        $idUser = $this->user["id"];
        $_POST["user_id"] = $idUser;
        $message = $_POST["messages"];


        $status = $this->dependencies->tickets->insert($_POST);

        if ($status["success"]) {

            $this->dependencies->tickets->edit(array("id" => $status["data"], "ticket_number" => $this->dependencies->tickets->randomTicketNumber()));

            $ticket = $this->dependencies->tickets->single($status["data"]);

            $id = (int)$ticket->id;

            $data_messages = (object)[
                "id_ticket" => $id,
                "id_sender" => $idUser,
                "message" => $message
            ];

            $this->dependencies->ticket_messages->insert($data_messages);

            $data_email = array(
                "number_ticket" => $ticket->ticket_number,
                "name_sender" => $this->user["name"],
                "message" => $message,
                "subject" => $ticket->subject,
                "status" => $ticket->status,
                "date" => $ticket->create_date,
                "link" => URL . "tickets/" . $ticket->id,
                "linkContact" => URL . $app->selected_language->code . "/contact",
                "other" => $app->config,
            );

            $data_email_admin = array(
                "number_ticket" => $ticket->ticket_number,
                "name_sender" => $this->user["name"],
                "message" => $message,
                "subject" => $ticket->subject,
                "status" => $ticket->status,
                "date" => $ticket->create_date,
                "link" => URL . "adm/tickets/" . $ticket->id,
                "linkContact" => URL . $app->selected_language->code . "/contact",
                "other" => $app->config,
            );

            // Obter os administradores
            $emails = $this->dependencies->users->getEmailsForNotifications("notification_new_ticket");

            if (!empty($emails) || !empty($email)) {

                // Enviar os emails
                $this->dependencies->library->email->send($email, "Confirmação de envio de Ticket", "emailConfirmationTicket", $data_email);
                $this->dependencies->library->email->send($emails, "Receção de novo ticket", "emailConfirmationTicketAdmin", $data_email_admin);
            }

            $admins = $this->dependencies->users->getAdmins();
            foreach ($admins as $idAdmin) {
                $data_notification = array(
                    "id_user" => $idAdmin,
                    "type" => "ticket",
                    "identifier" => $ticket->ticket_number,
                    "link" => URL . "adm/tickets/" . $ticket->id,
                );

                $this->dependencies->notifications->insert($data_notification);
            }


            header("Location: /tickets/" . $id);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }

    function changePassword()
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_LOGGED_USER_ONLY);

        if (!isset($_POST["curpassword"])) {

            $app->redirect("/auth");
        }

        if (!isset($_POST["password"])) {

            $app->redirect("/auth");
        }

        if (!isset($_POST["password-repeat"])) {

            $app->redirect("/auth");
        }

        if ($_POST["password"] !== $_POST["password-repeat"]) {

            $app->redirect("/profile" . "&message=" . "Palavras-passes não coincidem");
        }

        if ($_POST["password"] == $_POST["curpassword"]) {

            $app->redirect("/profile" . "&message=" . "A Palavra-passe nova não pode ser igual à antiga");
        }

        $status = $app->auth->changePassword($this->user["id"], $_POST["curpassword"], $_POST["password"], $_POST["password-repeat"]);

        if ($status["success"]) {

            $app->redirect("/profile" . "?success=true&message=" . $status["message"]);

        } else {

            // Deu erro
            $app->redirect("/profile" . "&message=" . $status["message"]);
        }
    }

    function insertMessage()
    {

        global $app;

        // Middleware
        $this->middleware(MIDDLEWARE_LOGGED_USER_ONLY);

        // Dependencies
        $this->dependencies(array("ticket_messages", "tickets", "users", "notifications"), array("email"));

        // Insert the data
        $status = $this->dependencies->ticket_messages->insert($_POST);

        if ($status["success"]) {

            $ticket = $this->dependencies->tickets->single($_POST['id_ticket']);
            $user = $this->dependencies->users->single($ticket->user_id);
            $emails = $this->dependencies->users->getEmailsForNotifications("notification_new_ticket");
            $message = $this->dependencies->ticket_messages->single($status["data"]);


            $data_email = array(
                "number_ticket" => $ticket->ticket_number,
                "name" => $user->client_data->name,
                "message" => $_POST['message'],
                "subject" => $ticket->subject,
                "status" => $ticket->status,
                "date" => $message->date,
                "link" => URL . "adm/tickets/" . $ticket->id,
            );
            // Enviar os email
            $this->dependencies->library->email->send($emails, "Resposta ao Ticket" . $ticket->ticket_number, "emailTicketReplayAdm", $data_email);


            //Criar notificação de nova Mensagen
            $admins = $this->dependencies->users->getAdmins();
            foreach ($admins as $idAdmin) {
                $data_notification = array(
                    "id_user" => $idAdmin,
                    "type" => "message",
                    "identifier" => $_POST['message'],
                    "link" => URL . "adm/tickets/" . $ticket->id,
                );

                $this->dependencies->notifications->insert($data_notification);
            }

            $this->response(true, "API REQUEST SUCCESS", $message);
        }

        // Send json response
        $this->response(false, "API REQUEST ERROR", $status["message"]);
    }
}
