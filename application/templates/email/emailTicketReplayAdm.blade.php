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
    <td class="center-text" data-text-style="Headlines" align="center" style="font-family:'Mulish',Arial,Helvetica,sans-serif;font-size:38px;line-height:48px;font-weight:800;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
        <singleline>
          <div mc:edit data-text-edit>
       <!--     Obrigado pelo seu contacto! -->

       Aviso de resposta ao ticket {{$number_ticket}}.

          </div>
        </singleline>
    </td>
  </tr>

<!-- MENSAGEM -->
  <tr data-element="colibri-bm-headline" data-label="Headlines">
    <td height="15" style="font-size:15px;line-height:35px;" data-height="Spacing under headline">&nbsp;</td>
  </tr>
  <tr data-element="colibri-bm-paragraph" data-label="Paragraphs">
    <td class="center-text" data-text-style="Paragraphs" align="center" style="font-family: 'Mulish',Arial,Helvetica,sans-serif; font-size: 14px; line-height: 24px; font-weight: 400; font-style: normal; color: #333333; text-decoration: none; letter-spacing: 0px">
        <singleline>
          <div mc:edit data-text-edit>
            Recebeu a resposta do ticket {{$number_ticket}}.<br>Enviada por {{$name}}
            <br><br>
            <div style="color: #615e5e; line-height: 140%; ">
              <p style="font-size: 14px; line-height: 140%;">
                  <span style="font-size: 14px; line-height: 19.6px;"><b>Assunto:</b> {{$subject}}</span>
              </p>
            </div>
            <div style="color: #615e5e; line-height: 140%;">
              <p style="font-size: 14px; line-height: 140%;"><b>Resposta:</b> {{$message}}</p>
            </div>
            <br>
            <div style="color: #5c5757; line-height: 140%;">
              <p style="font-size: 14px; line-height: 140%;">
                <strong>
                  <span style="font-size: 14px; line-height: 19.6px;">Informações do Ticket:</span>
                </strong>
              </p>
              <p style="font-size: 14px; line-height: 140%;">
                <span style="font-size: 14px; line-height: 19.6px;">
                    {{$number_ticket}},<br>
                    @if($status == 0)
                      Aberto
                    @elseif($status == 1)
                      Fechado
                    @elseif($status == 2)
                      Urgente
                    @endif
                <br>{{$date}}</span>
              </p>
              <br><br>
              Para visualizar toda a informação correspondente ao ticket ou responder ao mesmo aceda a:
              <br><br>
              <a href="{{$link}}" target="_blank"
                style="box-sizing: border-box;display: inline-block;font-family: 'Montserrat', sans-serif;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #ffffff;
                background-color: #E38529; border-radius: 40px; -webkit-border-radius: 40px; -moz-border-radius: 40px; width:auto; max-width:100%; overflow-wrap: break-word; word-break: break-word; word-wrap:break-word; mso-border-alt: none;">
              <span style="display:block;padding:15px 40px;line-height:120%;">
                <strong>
                  <span style="font-size: 14px; line-height: 16.8px;">{{$link}}</span>
                </strong>
              </span>
              </a>
            </div>
          </div>
        </singleline>
    </td>
  </tr>


  <tr data-element="colibri-invoice-info" data-label="Invoice Info">
    <td height="25" style="font-size:25px;line-height:25px;" data-height="Spacing under invoice info">&nbsp;</td>
  </tr>

    @endsection
