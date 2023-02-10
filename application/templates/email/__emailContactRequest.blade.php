@extends('layouts.master')
@section('content')
<table data-outer-table border="0" align="center" cellpadding="0" cellspacing="0" class="outer-table row" role="presentation" width="640" style="width:640px;max-width:640px;" data-module="colibri-header-18">
   <!-- colibri-header-18 -->
   <tr>
      <td align="center" data-fallback-color="Fallback Color" bgcolor="#fafafa">
         <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:640px;">
            <v:fill origin="0.5, 0.5" position="0.5, 0.5" src="images/header-18-back.png" type="tile" size="1,1" aspect="atleast"></v:fill>
            <v:textbox style="mso-fit-shape-to-text:true;" inset="0,0,0,0">
            </v:textbox>
         </v:rect>
      </td>
   </tr>
   <!-- colibri-header-18 -->
</table>
<table data-outer-table border="0" align="center" cellpadding="0" cellspacing="0" class="outer-table row" role="presentation" width="640" style="width:640px;max-width:640px;" data-module="colibri-basic-message-18">
<!-- colibri-basic-message-18 -->
<tr>
   <td align="center" bgcolor="#fafafa" data-bgcolor="BgColor">
      <!-- CONTEUDO -->
      <table data-inner-table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" class="inner-table row container-padding" width="580" style="width:580px;max-width:580px;">
         <tr>
            <td height="15" style="font-size:15px;line-height:15px;" data-height="Spacing top">&nbsp;</td>
         </tr>
         <!-- TITULO -->
         <tr data-element="colibri-bm-headline" data-label="Headlines">
            <td class="center-text" data-text-style="Headlines" align="center" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:38px;line-height:48px;font-weight:800;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
               <singleline>
                  <div mc:edit data-text-edit>
                     <!--     Obrigado pelo seu contacto! -->
                     {{ ucfirst($translations["mail"]["contact_request"]) }}
                  </div>
               </singleline>
            </td>
         </tr>
         <!-- MENSAGEM -->
         <tr data-element="colibri-bm-headline" data-label="Headlines">
            <td height="15" style="font-size:15px;line-height:35px;" data-height="Spacing under headline">&nbsp;</td>
         </tr>
         <tr data-element="colibri-bm-paragraph" data-label="Paragraphs">
            <td class="center-text" data-text-style="Paragraphs" align="center" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:14px;line-height:24px;font-weight:400;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
               <singleline>
               <div mc:edit data-text-edit>
                    <b>{{ ucfirst($translations["mail"]["name"]) }}:</b> {{ $name }} {{ $surname }}
                    <b>{{ ucfirst($translations["mail"]["email"]) }}:</b> {{ $email }}
                    <b>{{ ucfirst($translations["mail"]["contact"]) }}:</b> {{ $contact }}
                    <b>{{ ucfirst($translations["mail"]["subject"]) }}:</b> {{ $subject }}
                    <b>{{ ucfirst($translations["mail"]["message"]) }}:</b> {{ $description }}
                </div>
               </singleline>
            </td>
         </tr>
      </table>
      <!-- Content -->
   </td>
</tr>



      @endsection
      <!--
         public 'id' => string '28' (length=2)
          public 'user_id' => string '3' (length=1)
          public 'method' => string '1' (length=1)
          public 'shipping' => string '18' (length=2)
          public 'pay_amount' => string '47.20' (length=5)
          public 'payment_info' => string '1623784928223531' (length=16)
          public 'order_number' => string 'E-GfTgsdq' (length=9)
          public 'payment_status' => string '0' (length=1)
          public 'status' => string '1' (length=1)
          public 'customer_email' => string 'pedro@criativatek.com' (length=21)
          public 'customer_name' => string 'Web' (length=3)
          public 'customer_country' => string 'PT' (length=2)
          public 'customer_phone' => string '960070055' (length=9)
          public 'customer_address' => string 'Rua verde Pinho, Vale Sepal n133' (length=32)
          public 'customer_fiscal' => string '960070055' (length=9)
          public 'customer_city' => string 'Leiria' (length=6)
          public 'customer_zip' => string '2415-609' (length=8)
          public 'billing_name' => string '' (length=0)
          public 'billing_nif' => string '' (length=0)
          public 'billing_phone' => string '' (length=0)
          public 'billing_address' => string '' (length=0)
          public 'billing_city' => string '' (length=0)
          public 'billing_country' => string 'PT' (length=2)
          public 'order_note' => string '' (length=0)
          public 'coupon_code' => null
          public 'coupon_discount' => null
          public 'created_at' => string '2021-10-30 22:44:06' (length=19)
          public 'shipping_cost' => string '4.20' (length=4)
          public 'tax' => null
          public 'lang' => string 'pt' (length=2)
         
          -->