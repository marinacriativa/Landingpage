<?php

/**
*   Controller vivawallet ( Backoffice )
*
*   Extends: core/Controller.php
*   Author: Vlad
**/

namespace Fyre\Controller;

class vivawallet extends \Fyre\Core\Controller {

    function success() {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(["key" => "45C47F1BD72A1AAD71232C01E75C60E82FBFDB82"]);
        exit();
        global $app;

        // Dependencies
        $this->dependencies(array("orders", "users", "notifications", "translation", "historic"), array("email"));

        $data = json_decode('
        {
          "EventData":{
            "Amount": 100.50,
            "CardNumber": "411111XXXXXX1111",
            "CardTypeId": 0,
            "ClientId": "90a7114f-3a7a-466b-8a45-000111222555",
            "CompanyName": "Viva Ηλεκτρονικές Υπηρεσίες",
            "CurrencyCode": 978,
            "CurrentInstallment": 0,
            "CustomerTrns": "Customer description",
            "Email": "customer@viva.gr",
            "FullName": "Customer FullName",
            "InsDate": "2014-06-18T14:20:30.45+03:00",
            "MerchantId": "90a7114f-3a7a-466b-8a45-000111222666",
            "MerchantTrns": "Merchant Reference",
            "OrderCode": 2391104124794188,
            "ParentId": "90a7114f-3a7a-466b-8a45-000111222777",
            "ResellerCompanyName": "Παπασωτηρίου",
            "ResellerId": "90a7114f-3a7a-466b-8a45-000111222888",
            "ResellerSourceAddress": "Πανεπιστημίου 37 και Κοραή, Αθήνα",
             "ResellerSourceCode": "2233",
            "ResellerSourceName": "Πανεπιστημίου",
            "SourceCode": "[4-digit code of your payment source]",
            "StatusId": "F",
            "TotalCommission": 2.71,
            "TotalFee": 0.50,
            "TotalInstallments": 0,
            "TransactionId": "90a7114f-3a7a-466b-8a45-000111222888",
            "TransactionTypeId": 5
          },
          "EventTypeId": 1796,
          "Created": "2014-06-18T14:20:30.45+03:00"
        }', true);

        // Obter a encomenda
        $order = $this->dependencies->orders->getOrderByTransactionID($data['EventData']['OrderCode']);

        if (empty($order)) {

            echo 'Error';
            exit();
        }

        $lang = $this->dependencies->translation->singleByCode($order->lang);

        //Adicionar status de pagamento ao historico
        $this->dependencies->historic->insert(array(
            "idOrder" => $order->id,
            "status" => $lang->default_state2
        ));

        // Obter os administradores que recebem pedidos de contacto
        $emails = $this->dependencies->users->getEmailsForNotifications("notification_payment_received");

        // Enviar os email
        $this->dependencies->library->email->send($order->customer_email, "Confirmação de Encomenda", "emailPaymentReceived", array("order" => $order));
        $this->dependencies->library->email->send($emails, "Confirmação de Encomenda", "emailPaymentReceivedAdm", array("order" => $order));
    }

    function error() {


    }

    function key() {

      global $app;

      // Dependencies
      $this->dependencies(array("payment"), array());

      $payment_method = $this->dependencies->payment->multiple();

      foreach ($payment_method as $payment) {
        if($payment->checkout_page == "vivawallet") {
          $json = json_decode($payment->settings, true);
          $merchantID = $json['MERCHANT_ID'];
          $apiKey =  $json['API_KEY'];
          break;
        }
      }


      if(!isset($merchantID))
      {
        echo 'KEYS NOT FOUND!';
        exit();
      }

      $access = base64_encode($merchantID . ":" . $apiKey);

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.vivapayments.com/api/messages/config/token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'Authorization: Basic ' . $access
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      echo $response;

    }
}
