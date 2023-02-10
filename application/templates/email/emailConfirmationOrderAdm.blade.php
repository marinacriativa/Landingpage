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
       {{ ucfirst($translations["mail"]["new_order_made_adm"]) }}

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
          {{ ucfirst($translations["mail"]["order_greetings_adm"]) }}
          {{$name}}
          <br>
          {{ ucfirst($translations["mail"]["new_order_message_adm"])  }}
          <br><br>

          <br><br>

          </div>
        </singleline>
    </td>
  </tr>


  <!-- TABELA 1-->

  <tr>
    <td align="center">
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
              <tr data-element="colibri-content-order-number" data-label="Order Number">
                <td class="center-text" data-text-style="Order Number" align="left" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:20px;font-weight:400;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
                    <singleline>
                      <div mc:edit data-text-edit>
                        {{ ucfirst($translations["mail"]["new_order_number"])  }} <strong style="color:#E38529;">{{$order_number}}</strong>
                      </div>
                    </singleline>
                </td>
              </tr>
              <tr data-element="colibri-content-order-number" data-label="Order Number">
                <td height="10" style="font-size:10px;line-height:10px;" data-height="Spacing under order number">&nbsp;</td>
              </tr>
              <tr data-element="colibri-content-titles" data-label="Titles">
                <td class="center-text" data-text-style="Titles" align="left" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:20px;line-height:24px;font-weight:700;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
                    <singleline>
                      <div mc:edit data-text-edit>
                        {{ ucfirst($translations["mail"]["new_order_client_data"])  }}
                      </div>
                    </singleline>
                </td>
              </tr>
              <tr data-element="colibri-content-titles" data-label="Titles">
                <td height="10" style="font-size:10px;line-height:10px;" data-height="Spacing under titles">&nbsp;</td>
              </tr>
              <tr data-element="colibri-content-paragraph" data-label="Paragraphs">
                <td class="center-text" data-text-style="Paragraphs" align="left" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:14px;line-height:20px;font-weight:400;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
                    <singleline>
                      <div mc:edit data-text-edit>
                                    {{$name}}<br>
                                    {{$nif}}<br>
                                    {{$phone}}<br>
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
                <td class="center-text" data-text-style="Titles" align="left" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:20px;line-height:24px;font-weight:700;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
                    <singleline>
                      <div mc:edit data-text-edit>
                        {{ ucfirst($translations["mail"]["new_order_client_address"])  }}
                      </div>
                    </singleline>
                </td>
              </tr>
              <tr data-element="colibri-content-titles" data-label="Titles">
                <td height="10" style="font-size:10px;line-height:10px;" data-height="Spacing under titles">&nbsp;</td>
              </tr>
              <tr data-element="colibri-content-paragraph" data-label="Paragraphs">
                <td class="center-text" data-text-style="Paragraphs" align="left" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:14px;line-height:20px;font-weight:400;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
                    <singleline>
                      <div mc:edit data-text-edit>
                        {{$address}}<br>
                        {{$zip}} - {{$city}} - {{$country}}<br>
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
          <td height="10" style="font-size:10px;line-height:10px;" data-height="Content spacing bottom">&nbsp;</td>
        </tr>
      </table>
      <!-- Content -->
    </td>
  </tr>

<!-- FIM TABELA 1 -->

</table>
<!-- Content -->

</td>
</tr>




<!--                 divider-4                    -->
<table data-outer-table border="0" align="center" cellpadding="0" cellspacing="0" class="outer-table row" role="presentation" width="640" style="width:640px;max-width:640px;" data-module="colibri-divider-4">
  <tr>
    <td align="center" bgcolor="#fafafa" data-bgcolor="BgColor" height="50" style="font-size:50px;line-height:50px;">
      <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" class="container-padding" width="100%" style="width:100%;max-width:100%;">
        <tr>
          <td align="center" height="3" data-bgcolor="Dividers" style="font-size:3px;line-height:3px;border-top: 3px dotted #AAAAAA;">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<!--                 divider-4                 -->


<!-- INÍCIO TABELA PRINCIPAL -                                 -->
<table data-outer-table border="0" align="center" cellpadding="0" cellspacing="0" class="outer-table row" role="presentation" width="640" style="width:640px;max-width:640px;" data-module="colibri-invoice-product-row-1">
  <!-- colibri-invoice-product-row-1 -->
  <tr>
    <td align="center" bgcolor="#fafafa" data-bgcolor="BgColor">

<!-- Content -->
<table data-inner-table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" class="inner-table row container-padding" width="580" style="width:580px;max-width:580px;">
  <tr>
    <td height="10" style="font-size:10px;line-height:10px;" data-height="Spacing top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" data-border-color="Dividers" style="border-bottom: 1px solid #DDDDDD;">
      <!-- Content -->
      <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" class="row" width="89.66%" style="width:89.66%;max-width:89.66%;">
        <tr data-element="colibri-content-invoice-titles" data-label="Invoice Titles">
          <td align="center">
            <!-- Invoice Titles -->
            <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" width="100%" style="width:100%;max-width:100%;">
              <tr>
                <td colspan="5" height="15" style="font-size:15px;line-height:15px;">&nbsp;</td>
              </tr>
              <tr>
                <td data-text-style="Invoice Titles" align="left" width="40%" style="width:40%;max-width:40%;font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:20px;line-height:24px;font-weight:700;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
                    <singleline>
                      <div mc:edit data-text-edit>
                        {{ ucfirst($translations["mail"]["order_item"])  }}
                      </div>
                    </singleline>
                </td>
                <td align="left" width="4%" style="width:4%;max-width:4%;"></td>
                <td data-text-style="Invoice Titles" align="center" width="8%" style="width:8%;max-width:8%;font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:20px;line-height:24px;font-weight:700;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
                    <singleline>
                      <div mc:edit data-text-edit>
                        {{ ucfirst($translations["mail"]["order_qt"])  }}
                      </div>
                    </singleline>
                </td>
                <td align="left" width="4%" style="width:4%;max-width:4%;"></td>
                <td data-text-style="Invoice Titles" align="right" width="44%" style="width:44%;max-width:44%;font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:20px;line-height:24px;font-weight:700;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
                    <singleline>
                      <div mc:edit data-text-edit>
                        {{ ucfirst($translations["mail"]["order_price"])  }}
                      </div>
                    </singleline>
                </td>
              </tr>
              <tr>
                <td colspan="5" height="15" style="font-size:15px;line-height:15px;">&nbsp;</td>
              </tr>
            </table>
            <!-- Invoice Titles -->
          </td>
        </tr>
      </table>
      <!-- Content -->
    </td>
  </tr>
  <tr>
    <td height="10" style="font-size:10px;line-height:10px;" data-height="Spacing bottom">&nbsp;</td>
  </tr>
</table>
<!-- Content -->

    </td>
  </tr>
  <!-- colibri-invoice-product-row-1 -->
</table>

<table data-outer-table border="0" align="center" cellpadding="0" cellspacing="0" class="outer-table row" role="presentation" width="640" style="width:640px;max-width:640px;" data-module="colibri-invoice-product-row-2">
  <!-- colibri-invoice-product-row-2 -->
  <tr>
    <td align="center" bgcolor="#fafafa" data-bgcolor="BgColor">



<!-- LINHA POR PRODUTO -->
@foreach($products as $product)
<table data-inner-table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" class="inner-table row container-padding" width="580" style="width:580px;max-width:580px;">
  <tr>
    <td height="10" style="font-size:10px;line-height:10px;" data-height="Spacing top">&nbsp;</td>
  </tr>
 <tr>
    <td align="center" data-border-color="Dividers" style="border-bottom: 1px solid #DDDDDD;">
      <!-- Content -->
      <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" class="row" width="89.66%" style="width:89.66%;max-width:89.66%;">
        <tr>
          <td align="center" valign="top" width="40%" style="width:40%;max-width:40%;">
            <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" width="100%" style="width:100%;max-width:100%;">
              <tr>
                <td data-text-style="Invoice Content" align="left" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:26px;font-weight:700;font-style:normal;color:#000000;text-decoration:none;letter-spacing:0px;">
                    <singleline>
                      <div mc:edit data-text-edit>
                        {{$product['product_name']}}
                      </div>
                    </singleline>
                </td>
              </tr>
              <tr>
                <td height="10" style="font-size:10px;line-height:10px;">&nbsp;</td>
              </tr>
              <tr>
                <td data-text-style="Product Info" align="left" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:13px;line-height:23px;font-weight:400;font-style:normal;color:#6e6e6e;text-decoration:none;letter-spacing:0px;">
                    <singleline>
                      <div mc:edit data-text-edit>
                        {{$product['sku']}} - {{$product['type']}}
                      </div>
                    </singleline>
                </td>
              </tr>
            </table>
          </td>
          <td align="left" width="4%" style="width:4%;max-width:4%;"></td>
          <td data-text-style="Invoice Content" align="center" valign="top" width="8%" style="width:8%;max-width:8%;font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:26px;font-weight:700;font-style:normal;color:#000000;text-decoration:none;letter-spacing:0px;">
              <singleline>
                <div mc:edit data-text-edit>
                  {{$product['qty_product']}}x{{$product['price']}}€
                </div>
              </singleline>
          </td>
          <td align="left" width="4%" style="width:4%;max-width:4%;"></td>
          <td data-text-style="Invoice Content" align="right" valign="top" width="44%" style="width:44%;max-width:44%;font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:26px;font-weight:700;font-style:normal;color:#000000;text-decoration:none;letter-spacing:0px;">
              <singleline>
                <div mc:edit data-text-edit>
                    @php
                        $total = $product['qty_product']*$product['price'];
                    @endphp
                    {{number_format((float)$total, 2, '.', '')}}€</span></p>
                </div>
              </singleline>
          </td>
        </tr>
        <tr>
          <td height="25" style="font-size:25px;line-height:25px;">&nbsp;</td>
        </tr>
      </table>
      <!-- Content -->
    </td>
  </tr>
  <tr>
    <td height="10" style="font-size:10px;line-height:10px;" data-height="Spacing bottom">&nbsp;</td>
  </tr>
</table>
@endforeach
<!-- FIM da LINHA POR PRODUTO -->



<table data-outer-table border="0" align="center" cellpadding="0" cellspacing="0" class="outer-table row" role="presentation" width="640" style="width:640px;max-width:640px;" data-module="colibri-divider-4">
  <!-- colibri-divider-4 -->
  <tr>
    <td align="center" bgcolor="#fafafa" data-bgcolor="BgColor" height="50" style="font-size:50px;line-height:50px;">
      <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" class="container-padding" width="100%" style="width:100%;max-width:100%;">
        <tr>
          <td align="center" height="3" data-bgcolor="Dividers" style="font-size:3px;line-height:3px;border-top: 3px dotted #AAAAAA;">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
  <!-- colibri-divider-4 -->
</table>

<table data-outer-table border="0" align="center" cellpadding="0" cellspacing="0" class="outer-table row" role="presentation" width="640" style="width:640px;max-width:640px;" data-module="colibri-order-placed-total">
  <!-- colibri-order-placed-total -->
  <tr>
    <td align="center" bgcolor="#fafafa" data-bgcolor="BgColor">

<!-- Content -->
<table data-inner-table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" class="inner-table row container-padding" width="580" style="width:580px;max-width:580px;">
  <tr>
    <td height="20" style="font-size:20px;line-height:20px;" data-height="Spacing top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
      <!-- Content -->
      <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" class="row" width="89.66%" style="width:89.66%;max-width:89.66%;">
        <tr>
          <td align="center">
            <!-- rwd-col -->
            <table border="0" cellpadding="0" cellspacing="0" align="center" class="container-padding" width="100%" style="width:100%;max-width:100%;">
              <tr>
                <td class="rwd-col" align="center" valign="top" width="41.38%" style="width:41.38%;max-width:41.38%;">
            <!-- column -->
            <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" width="100%" style="width:100%;max-width:100%;">
              <tr data-element="colibri-content-titles" data-label="Titles">
                <td class="center-text" data-text-style="Titles" align="left" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:18px;line-height:24px;font-weight:700;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
                    <singleline>
                      <div mc:edit data-text-edit>
                      {{ ucfirst($translations["mail"]["order_payment_method"])  }}

                      </div>
                    </singleline>
                </td>
              </tr>
              <tr data-element="colibri-content-paragraph" data-label="Paragraphs">
                <td class="center-text" data-text-style="Paragraphs" align="left" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:14px;line-height:30px;font-weight:400;font-style:normal;color:#666666;text-decoration:none;letter-spacing:0px;">
                    <singleline>
                      <div mc:edit data-text-edit>
                        {{$payment_method}}

                      </div>
                    </singleline>
                </td>
              </tr>
            </table>
            <!-- column -->

            </td>
            <td class="rwd-col" align="center" width="5.17%" height="30" style="width:5.17%;max-width:5.17%;height: 30px;">&nbsp;</td>
            <td class="rwd-col" align="center" valign="top" width="43.1%" style="width:43.1%;max-width:43.1%;">

            <!-- column -->
            <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation" width="100%" style="width:100%;max-width:100%;">
              <tr>
                <td align="center">
                  <!-- row -->
                  <table border="0" align="right" cellpadding="0" cellspacing="0" role="presentation" class="center-float">
                    <tr>
                      <td align="center">
                  <!--[if (gte mso 9)|(IE)]><table border="0" cellpadding="0" cellspacing="0"><tr><td><![endif]-->
                  <!-- column -->
                  <table border="0" align="left" cellpadding="0" cellspacing="0" role="presentation" width="100" style="width:100px;max-width:100px;">
                    <tr data-element="Colibri-content-titles" data-label="Subtotal">
                      <td data-text-style="Calculation" align="right" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:18px;line-height:30px;font-weight:700;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
                          <singleline>
                            <div mc:edit data-text-edit>
                            {{ ucfirst($translations["mail"]["order_subtotal"])  }}

                            </div>
                          </singleline>
                      </td>
                    </tr>
                    <tr data-element="Colibri-content-titles" data-label="Shipping">
                      <td data-text-style="Calculation" align="right" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:18px;line-height:30px;font-weight:700;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
                          <singleline>
                            <div mc:edit data-text-edit>
                            {{ ucfirst($translations["mail"]["order_shipping"])  }}
                            </div>
                          </singleline>
                      </td>
                    </tr>
                    <tr data-element="Colibri-content-titles" data-label="Tax">
                      <td data-text-style="Calculation" align="right" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:18px;line-height:30px;font-weight:700;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
                          <singleline>
                            <div mc:edit data-text-edit>
                            {{ ucfirst($translations["mail"]["order_tax"])  }}
                            </div>
                          </singleline>
                      </td>
                    </tr>
                    <tr data-element="Colibri-content-titles" data-label="Discount">
                      <td data-text-style="Calculation" align="right" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:18px;line-height:30px;font-weight:700;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
                          <singleline>
                            <div mc:edit data-text-edit>
                            {{ ucfirst($translations["mail"]["order_discount"])  }}
                            </div>
                          </singleline>
                      </td>
                    </tr>
                  </table>
                  <!-- column -->
                  <!--[if (gte mso 9)|(IE)]></td><td><![endif]-->
                  <!-- gap -->
                  <table border="0" align="left" cellpadding="0" cellspacing="0" role="presentation" width="20" style="width:20px;max-width:20px;">
                    <tr>
                      <td height="20" style="font-size:20px;line-height:20px;">&nbsp;</td>
                    </tr>
                  </table>
                  <!-- gap -->
                  <!--[if (gte mso 9)|(IE)]></td><td><![endif]-->
                  <!-- column -->
                  <table border="0" align="left" cellpadding="0" cellspacing="0" role="presentation" width="70" style="width:70px;max-width:70px;">
                    <tr data-element="Colibri-content-titles" data-label="Subtotal number">
                      <td data-text-style="Calculation" align="left" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:18px;line-height:30px;font-weight:400;font-style:normal;color:#666666;text-decoration:none;letter-spacing:0px;">
                          <singleline>
                            <div mc:edit data-text-edit>
                            {{number_format((float)$subtotal, 2, '.', '')}}€</span></p>
                          </div>
                          </singleline>
                      </td>
                    </tr>
                    <tr data-element="Colibri-content-titles" data-label="Shipping number">
                      <td data-text-style="Calculation" align="left" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:18px;line-height:30px;font-weight:400;font-style:normal;color:#666666;text-decoration:none;letter-spacing:0px;">
                          <singleline>
                            <div mc:edit data-text-edit>
                              {{number_format((float)$shipping_cost, 2, '.', '')}}€
                            </div>
                          </singleline>
                      </td>
                    </tr>
                    <tr data-element="Colibri-content-titles" data-label="Tax number">
                      <td data-text-style="Calculation" align="left" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:18px;line-height:30px;font-weight:400;font-style:normal;color:#666666;text-decoration:none;letter-spacing:0px;">
                          <singleline>
                            <div mc:edit data-text-edit>
                              {{number_format((float)$tax, 2, '.', '')}}€
                            </div>
                          </singleline>
                      </td>
                    </tr>

                    <tr data-element="Colibri-content-titles" data-label="discount number">
                      <td data-text-style="Calculation" align="left" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:18px;line-height:30px;font-weight:400;font-style:normal;color:#666666;text-decoration:none;letter-spacing:0px;">
                          <singleline>
                            <div mc:edit data-text-edit>
                              {{number_format((float)$coupon_discount, 2, '.', '')}}
                              @if($coupon_type != false && $coupon_type != 0)
                                %
                              @else
                                €
                              @endif
                            </div>
                          </singleline>
                      </td>
                    </tr>
                  </table>
                  <!-- column -->
                  <!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
                      </td>
                    </tr>
                  </table>
                  <!-- row -->
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
        <tr data-element="colibri-content-total" data-label="Total">
          <td align="center">
            <!-- Order number -->
            <table border="0" align="right" cellpadding="0" cellspacing="0" role="presentation" class="center-float">
              <tr>
                <td align="center" data-border-radius-default="0,6,36" data-border-radius-custom="Order Number" data-bgcolor="Order Number" bgcolor="#EEEEEE" style="border-radius: 3px; border: 2px solid #DDDDDD;">
                  <!-- Container -->
                  <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                      <td width="35" style="width: 35px;"></td>
                      <td align="center" height="54" style="font-family:'PT Sans',Arial,Helvetica,sans-serif;font-size:20px;line-height:24px;font-weight:700;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;height:54px;">
                          <singleline>
                            <div mc:edit data-text-edit>
                             {{ ucfirst($translations["mail"]["order_total"])  }} : {{number_format((float)$pay_amount, 2, '.', '')}}€
                            </div>
                          </singleline>
                      </td>
                      <td width="35" style="width: 35px;"></td>
                    </tr>
                  </table>
                  <!-- Container -->
                </td>
              </tr>
            </table>
            <!-- Order number -->
          </td>
        </tr>

        <tr data-element="colibri-content-total" data-label="Total">
          <td height="30" style="font-size:30px;line-height:30px;" data-height=" Spacing under total">&nbsp;</td>
        </tr>
        <tr data-element="colibri-content-divider" data-label="Dividers">
          <td height="1" bgcolor="#DDDDDD" data-bgcolor="Solid Divider" style="font-size:1px;line-height:1px;">&nbsp;</td>
        </tr>
        <tr data-element="colibri-content-divider" data-label="Dividers">
          <td height="20" style="font-size:20px;line-height:20px;" data-height="Spacing under divider">&nbsp;</td>
            <tr data-element="colibri-content-paragraphs" data-label="Paragraphs">
          <td align="center">
            <!-- Paragraphs -->
            <table border="0" cellspacing="0" cellpadding="0" role="presentation" align="center" class="row" width="480" style="width:480px;max-width:480px;">
              <tr>
                <td class="center-text" data-text-style="Paragraphs" align="center" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:14px;line-height:26px;font-weight:400;font-style:italic;color:#333333;text-decoration:none;letter-spacing:0px;">
                    <singleline>
                      <div mc:edit data-text-edit>

                        {{$order_note}}

                      </div>
                    </singleline>
                </td>
              </tr>
            </table>
            <!-- Paragraphs -->
          </td>
        </tr>
        <tr data-element="colibri-content-paragraphs" data-label="Paragraphs">
          <td height="20" style="font-size:20px;line-height:20px;" data-height="Spacing under paragraphs">&nbsp;</td>
        </tr>
        <tr data-element="colibri-button" data-label="Buttons">
          <td align="center">
            <!-- Button -->
            <table border="0" cellspacing="0" cellpadding="0" role="presentation" align="center" class="center-float">
              <tr>
                <td align="center" data-border-radius-default="0,6,36" data-border-radius-custom="Buttons" data-bgcolor="Buttons" bgcolor="#E38529" style="border-radius: 36px;">
            <!--[if (gte mso 9)|(IE)]>
              <table border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                  <td align="center" width="35"></td>
                  <td align="center" height="50" style="height:50px;">
                  <![endif]-->
                    <singleline>
                      <a href="{{$link}}" mc:edit data-button data-text-style="Buttons" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:16px;line-height:20px;font-weight:700;font-style:normal;color:#FFFFFF;text-decoration:none;letter-spacing:0px;padding: 15px 35px 15px 35px;display: inline-block;"><span>{{ ucfirst($translations["mail"]["new_order_link_adm"])  }}</span></a>
                    </singleline>
                  <!--[if (gte mso 9)|(IE)]>
                  </td>
                  <td align="center" width="35"></td>
                </tr>
              </table>
            <![endif]-->
                </td>
              </tr>
            </table>
            <!-- Buttons -->
          </td>
        </tr>
          <td height="15" style="font-size:15px;line-height:15px;" data-height="Content spacing bottom">&nbsp;</td>
        </tr>
      </table>
      <!-- Content -->
    </td>
  </tr>
  <tr>
    <td height="20" style="font-size:20px;line-height:20px;" data-height="Spacing bottom">&nbsp;</td>
  </tr>
</table>
<!-- Content -->



@endsection
