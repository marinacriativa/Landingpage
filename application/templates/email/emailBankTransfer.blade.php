@extends('layouts.master')
@section('content')


<table data-outer-table border="0" align="center" cellpadding="0" cellspacing="0" class="outer-table row" role="presentation" width="640" style="width:640px;max-width:640px;" data-module="colibri-header-18">
  <!-- colibri-header-18 -->
  <tr>
    <td align="center" data-fallback-color="Fallback Color" bgcolor="#fafafa">

<v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:640px;">
<v:fill origin="0.5, 0.5" position="0.5, 0.5" src="images/header-18-back.png" type="tile" size="1,1" aspect="atleast"></v:fill>
<v:textbox style="mso-fit-shape-to-text:true;" inset="0,0,0,0">



</v:textbox></v:rect>

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
       {{ ucfirst($translations["mail"]["order_nib"]) }}

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
          {{ ucfirst($translations["mail"]["order_greetings"]) }}
          {{ $name }}
          <br>
          {{ ucfirst($translations["mail"]["order_nib_message"])  }}
          <br>
                   
          </div>
        
                  
        </singleline>

    </td>
  </tr>

  <tr data-element="colibri-bm-usercode" data-label="Order Number">
    <td align="center">
      <!-- Use Code -->
      <table border="0" cellspacing="0" cellpadding="0" role="presentation" align="center" class="row" width="89.66%" style="width:89.66%;max-width:89.66%;">
        <tr>
          <td align="center" data-border-radius-default="0,6,36" data-border-radius-custom="User Code" data-bgcolor="User Code" bgcolor="#F1F1F1" style="border-radius: 10px;border: 2px dotted #AAAAAA;">
            <!-- Content -->
            <table border="0" cellspacing="0" cellpadding="0" role="presentation" align="center" class="row" width="100%" style="width:100%;max-width:100%;">
              <tr>
                <td height="20" style="font-size:20px;line-height:20px;">&nbsp;</td>
              </tr>
              <tr>
                <td class="center-text" data-text-style="Use Code" align="center" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:22px;line-height:26px;font-weight:400;font-style:normal;color:#666666;text-decoration:none;letter-spacing:0px;">
                    <singleline>
                      <div mc:edit data-text-edit>
                         <strong style="color:#E38529;">{{ $pay_settings->IBAN }}</strong>
                      </div>
                    </singleline>
                </td>
              </tr>
              <tr>
                <td height="20" style="font-size:20px;line-height:20px;">&nbsp;</td>
              </tr>
            </table>
            <!-- Content -->
          </td>
        </tr>
      </table>
      <!-- User Code -->
    </td>
  </tr>
  <tr data-element="colibri-bm-paragraph" data-label="Paragraphs">
    <td class="center-text" data-text-style="Paragraphs" align="center" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:14px;line-height:24px;font-weight:400;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
        <singleline>
          <div mc:edit data-text-edit>
          <br>
          {!! ucfirst($translations["mail"]["order_nib_message2"]) !!}
          <br>
          {!! ucfirst($translations["mail"]["order_data_message"]) !!}
         
          </div>
        
                  
        </singleline>

    </td>
  </tr>


  <!-- MINI TABELA-->
  <tr data-element="colibri-bm-paragraph" data-label="Paragraphs">
    <td height="25" style="font-size:25px;line-height:25px;" data-height="Spacing under paragraph">&nbsp;</td>
  </tr>
  <tr data-element="colibri-invoice-info" data-label="Invoice Info">
    <td align="center" data-border-radius-default="0,6,36" data-border-radius-custom="Emoji Container" data-bgcolor="Emoji Container" bgcolor="#F4F4F4" style="border-radius: 6px; border: 2px dotted #EEEEEE;">
      <!-- Content -->
      <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" class="row" width="89.66%" style="width:89.66%;max-width:89.66%;">
        <tr>
          <td height="20" style="font-size:20px;line-height:20px;" data-height="Content spacing top">&nbsp;</td>
        </tr>
        <tr>
          <td align="center">
            <!-- rwd-col -->
            <table border="0" cellpadding="0" cellspacing="0" align="center" class="container-padding" width="100%" style="width:100%;max-width:100%;">
              <tr>
                <td class="rwd-col" align="center" valign="top" width="48.96%" style="width:48.96%;max-width:48.96%;">

                <!-- column -->
                <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" width="100%" style="width:100%;max-width:100%;">
                  <tr data-element="colibri-content-titles" data-label="Titles">
                    <td class="center-text" data-text-style="Titles" align="center" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:20px;line-height:24px;font-weight:700;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
                        <singleline>
                          <div mc:edit data-text-edit>
                            {!! ucfirst($translations["mail"]["order_number"]) !!}
                           <!--  Número de encomenda:  -->
                          </div>
                        </singleline>



                    </td>
                  </tr>
                  <tr data-element="colibri-content-titles" data-label="Titles">
                    <td height="10" style="font-size:10px;line-height:10px;" data-height="Spacing under titles">&nbsp;</td>
                  </tr>
                  <tr data-element="colibri-content-paragraph" data-label="Paragraphs">
                    <td class="center-text" data-text-style="Paragraphs" align="center" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:20px;font-weight:400;font-style:normal;color:#E38529;text-decoration:none;letter-spacing:0px;">
                        <singleline>
                          <div mc:edit data-text-edit>
                           
                            {{$order_number}}
                       
                          </div>
                        </singleline>
                    </td>
                  </tr>
                </table>
                <!-- column -->

            </td>
            <td class="rwd-col" align="center" width="2.08%" height="30" style="width:2.08%;max-width:2.08%;height: 30px;">&nbsp;</td>
            <td class="rwd-col" align="center" valign="top" width="48.96%" style="width:48.96%;max-width:48.96%;">

                <!-- column -->
                <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" width="100%" style="width:100%;max-width:100%;">
                  <tr data-element="colibri-content-titles" data-label="Titles">
                    <td class="center-text" data-text-style="Titles" align="center" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:20px;line-height:24px;font-weight:700;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
                        <singleline>
                          <div mc:edit data-text-edit>
                            {!! ucfirst($translations["mail"]["order_total"]) !!}
                        <!--    Total:   -->
                          </div>
                        </singleline>
                    </td>
                  </tr>
                  <tr data-element="colibri-content-titles" data-label="Titles">
                    <td height="10" style="font-size:10px;line-height:10px;" data-height="Spacing under titles">&nbsp;</td>
                  </tr>
                  <tr data-element="colibri-content-paragraph" data-label="Paragraphs">
                    <td class="center-text" data-text-style="Paragraphs" align="center" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:20px;font-weight:400;font-style:normal;color:#666666;text-decoration:none;letter-spacing:0px;">
                        <singleline>
                          <div mc:edit data-text-edit>
                            {{number_format((float)$pay_amount, 2, '.', '')}}€

                          </div>
                        </singleline>
                    </td>
                  </tr>
                </table>
                <!-- column -->
                
                </td>
              </tr>
            </table>
            <!-- rwd-col -->
          </td>
        </tr>
        <tr>
          <td height="20" style="font-size:20px;line-height:20px;" data-height="Content spacing bottom">&nbsp;</td>
        </tr>
      </table>
      <!-- Content -->
    </td>
  </tr>
  <tr data-element="colibri-invoice-info" data-label="Invoice Info">
    <td height="25" style="font-size:25px;line-height:25px;" data-height="Spacing under invoice info">&nbsp;</td>
  </tr>
@endsection
