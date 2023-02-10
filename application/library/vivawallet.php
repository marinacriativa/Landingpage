<?php

class Vivawallet {

    function pay($vivawallet_endpoint, $merchant_id, $api_key, $tag, $internal_reference, $amount, $buyer_name, $buyer_email, $language = "pt-PT") {



      $credentials = "ttbzv8c13652ktrovmilo4s5ah007jqpyg9y6t5nacu57.apps.vivapayments.com:4958a6aNOd4q119Ov8BJFt7fVhrVpN";
      $ch = curl_init();
      $options = array(
          CURLOPT_URL => 'https://accounts.vivapayments.com/connect/token',
          CURLOPT_POST => 1,
          CURLOPT_HEADER => false,
          CURLOPT_RETURNTRANSFER => true,
          // Set the auth type as `Basic`
          CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
          // Set login and password for Basic auth
          CURLOPT_USERPWD => $credentials,
          CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/x-www-form-urlencoded'
          ),
          // To send additional parameters in the POST body
          CURLOPT_POSTFIELDS => "grant_type=client_credentials"
      );

      curl_setopt_array($ch, $options);
      // This is the response for your request
      $result = curl_exec($ch);
      // This is the response status code (if you are interested)
      $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);
      $result = json_decode($result, true);



        if ($amount == 0) {

            return false;
        }



        // Bearer must be generated with OAuth 2 and scope: urn:viva:payments:core:api:redirectcheckout
        // https://developer.vivawallet.com/tutorials-for-payments/enable-oauth2-authentication/
        $accessToken = $result['access_token'];
        $postFields  = [
            'amount'              => intval(($amount * 100) . ''),
            'customerTrns'        => "Encomenda: " . $internal_reference,
            'customer'            => [
                'email'         =>  $buyer_email,
                "fullName"      =>  $buyer_name,
            ],
            'paymentTimeout'      => 65535,
            'preauth'             => true,
            'allowRecurring'      => true,
            'maxInstallments'     => 0,
            'paymentNotification' => true,
            'disableCash'         => false,
            'disableWallet'       => false,
            'sourceCode'          => 'Default',
            'merchantTrns'        => 'This is a short description that helps you uniquely identify the transaction',
            'tags'                => [$tag],
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => 'https://api.vivapayments.com/checkout/v2/orders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => json_encode($postFields),
            CURLOPT_HTTPHEADER     => array(
                "Authorization: Bearer $accessToken",
                'Content-Type: application/json'
            ),
        ));



        // Do the POST and then close the session
        $response = curl_exec($curl);

        curl_close($curl);

        // Parse the JSON response
        try {

            if (is_object(json_decode($response))) {

                return json_decode($response)->orderCode;

            } else {

                throw new Exception("API Call failed!");
            }

        } catch( Exception $e ) {
            return false;
        }
    }
}
