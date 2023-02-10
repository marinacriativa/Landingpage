
<?php $__env->startSection('content'); ?>
    <table data-outer-table border="0" align="center" cellpadding="0" cellspacing="0" class="outer-table row"
        role="presentation" width="640" style="width:640px;max-width:640px;" data-module="colibri-header-18">
        <!-- colibri-header-18 -->
        <tr>
            <td align="center" data-fallback-color="Fallback Color" bgcolor="#fafafa">

                <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:640px;">
                    <v:fill origin="0.5, 0.5" position="0.5, 0.5" src="/images/header-18-back.png" type="tile"
                        size="1,1" aspect="atleast"></v:fill>
                    <v:textbox style="mso-fit-shape-to-text:true;" inset="0,0,0,0">

                    </v:textbox>
                </v:rect>

            </td>
        </tr>
        <!-- colibri-header-18 -->
    </table>

    <table data-outer-table border="0" align="center" cellpadding="0" cellspacing="0" class="outer-table row"
        role="presentation" width="640" style="width:640px;max-width:640px;" data-module="colibri-basic-message-18">
        <!-- colibri-basic-message-18 -->
        <tr>
            <td align="center" bgcolor="#fafafa" data-bgcolor="BgColor">


                <!-- CONTEUDO -->
                <table data-inner-table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation"
                    class="inner-table row container-padding" width="580" style="width:580px;max-width:580px;">
                    <tr>
                        <td height="15" style="font-size:15px;line-height:15px;" data-height="Spacing top">&nbsp;</td>
                    </tr>

                    <!-- TITULO -->
                    <tr data-element="colibri-bm-headline" data-label="Headlines">
                        <td class="center-text" data-text-style="Headlines" align="center"
                            style="font-family:'Mulish',Arial,Helvetica,sans-serif;font-size:38px;line-height:48px;font-weight:800;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
                            <singleline>
                                <div mc:edit data-text-edit>
                                    Pedido de Consulta
                                </div>
                            </singleline>
                        </td>
                    </tr>
                    <tr data-element="colibri-bm-headline" data-label="Headlines">
                    <td height="15" style="font-size:15px;line-height:15px;" data-height="Spacing under headline">&nbsp;</td>
                    </tr>
                    <tr data-element="colibri-bm-paragraph" data-label="Paragraphs">
                    <td class="center-text" data-text-style="Paragraphs" align="center" style="font-family:'Poppins',Arial,Helvetica,sans-serif;font-size:14px;line-height:24px;font-weight:400;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
                        <singleline>
                        <div mc:edit data-text-edit>
                            <?php echo e(ucfirst($translations["mail"]["welcome_message_text1"])); ?> <?php echo e($name); ?> <?php echo e(lcfirst($translations["mail"]["welcome_message_text2"])); ?><br><?php echo e(ucfirst($translations["mail"]["welcome_message_text3"])); ?>

                        </div>
                        </singleline>
                    </td>
                    </tr>
                    <!-- MENSAGEM -->
                    <tr data-element="colibri-bm-headline" data-label="Headlines">
                        <td height="15" style="font-size:15px;line-height:35px;" data-height="Spacing under headline">
                            &nbsp;</td>
                    </tr>
                    <tr data-element="colibri-content-titles" data-label="Titles">
                              <td class="center-text" data-text-style="Titles" align="left" style="font-family:'Poppins',Arial,Helvetica,sans-serif;padding: 25px 40px 25px;font-size:20px;line-height:24px;font-weight:700;font-style:normal;color:#333333;text-decoration:none;letter-spacing:0px;">
                                <singleline>
                                  <div mc:edit data-text-edit>
                                    <?php echo e(ucfirst($translations["mail"]["personal_data"])); ?>:<br><br>
                                  </div>
                                </singleline>
                              </td>
                            </tr>         
                    <tr>
                        <td style="overflow-wrap:break-word;word-break:break-word;padding:2px 40px 25px;font-family: 'Montserrat', sans-serif;"
                            align="left">


                            <?php if(isset($name)): ?>
                            <div class="v-text-align"
                                style="line-height: 170%; text-align: left; word-wrap: break-word;">
                                <p dir="ltr" style="font-size: 14px; line-height: 170%;">
                                    <b>Nome:</b> <?php echo e($name); ?>

                                </p>
                            </div>
                            <?php endif; ?>

                            <?php if(isset($phone)): ?>
                            <div class="v-text-align"
                                style="line-height: 170%; text-align: left; word-wrap: break-word;">
                                <p dir="ltr" style="font-size: 14px; line-height: 170%;">
                                    <b>Contacto:</b> <?php echo e($phone); ?>

                                </p>
                            </div>
                            <?php endif; ?>
                            
                            <?php if(isset($email)): ?>
                            <div class="v-text-align"
                                style="line-height: 170%; text-align: left; word-wrap: break-word;">
                                <p dir="ltr" style="font-size: 14px; line-height: 170%;">
                                    <b>Email:</b> <?php echo e($email); ?>

                                </p>
                            </div>
                            <?php endif; ?>

                            <?php if(isset($custom_1)): ?>
                            <div class="v-text-align"
                                style="line-height: 170%; text-align: left; word-wrap: break-word;">
                                <p dir="ltr" style="font-size: 14px; line-height: 170%;">
                                    <b>Data de Nascimento:</b> <?php echo e($custom_1); ?>

                                </p>
                            </div>
                            <?php endif; ?>

                            <?php if(isset($custom_2)): ?>
                                <div class="v-text-align"
                                    style="line-height: 170%; text-align: left; word-wrap: break-word;">
                                    <p dir="ltr" style="font-size: 14px; line-height: 170%;">
                                        <b>Data pretendida para consulta:</b> <?php echo e($custom_2); ?>

                                    </p>
                                </div>
                            <?php endif; ?>

                            <?php if(isset($custom_3)): ?>
                            <div class="v-text-align"
                                style="line-height: 170%; text-align: left; word-wrap: break-word;">
                                <p dir="ltr" style="font-size: 14px; line-height: 170%;">
                                    <b>É nosso Paciente?</b> <?php echo e($custom_3); ?>

                                </p>
                            </div>
                            <?php endif; ?>

                            <br> <br>
                            <?php if(isset($description)): ?>
                            <div class="v-text-align"
                                style="line-height: 170%; text-align: left; word-wrap: break-word;">
                                <p dir="ltr" style="font-size: 14px; line-height: 170%;">
                                    <b><?php echo e(ucfirst($translations["mail"]["message"])); ?>:</b><br><?php echo nl2br($description); ?>

                                </p>
                            </div>
                            <?php endif; ?>
                        </td>
                    </tr>


                    <tr data-element="colibri-invoice-info" data-label="Invoice Info">
                        <td height="25" style="font-size:25px;line-height:25px;"
                            data-height="Spacing under invoice info">&nbsp;</td>
                    </tr>

  <!-- Termina Tabela DADOS PESSOAIS -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\email/emailBookingRequest.blade.php ENDPATH**/ ?>