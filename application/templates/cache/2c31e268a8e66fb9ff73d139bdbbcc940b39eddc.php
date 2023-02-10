
<?php $__env->startSection('content'); ?>

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

                    Pedido de Contacto

                    </div>
                </singleline>
            </td>
        </tr>
        <!-- MENSAGEM -->
        <tr data-element="colibri-bm-headline" data-label="Headlines">
            <td height="15" style="font-size:15px;line-height:35px;" data-height="Spacing under headline">&nbsp;</td>
        </tr>
        <tr>
            <td style="overflow-wrap:break-word;word-break:break-word;padding:2px 40px 25px;font-family: 'Montserrat', sans-serif;"
                align="left">

                <?php if(isset($name)): ?>
                <div class="v-text-align"
                        style="color: #7a7676; line-height: 170%; text-align: left; word-wrap: break-word;">
                    <p dir="ltr"
                        style="font-size: 14px; line-height: 170%; text-align: center;">
                        <span style="font-size: 16px; line-height: 27.2px;">Nome: <?php echo e($name); ?></span>
                    </p>
                </div>
                <?php endif; ?>
                
                <?php if(isset($email)): ?>
                <div class="v-text-align"
                        style="color: #7a7676; line-height: 170%; text-align: left; word-wrap: break-word;">
                    <p dir="ltr"
                        style="font-size: 14px; line-height: 170%; text-align: center;">
                        <span style="font-size: 16px; line-height: 27.2px;">Email: <?php echo e($email); ?></span>
                    </p>
                </div>
                <?php endif; ?>

                <?php if(isset($description)): ?>
                <div class="v-text-align"
                        style="color: #7a7676; line-height: 170%; text-align: left; word-wrap: break-word;">
                    <p dir="ltr"
                        style="font-size: 14px; line-height: 170%; text-align: center;">
                        <span style="font-size: 16px; line-height: 27.2px;">Mensagem: <?php echo e($description); ?></span>
                    </p>
                </div>
                <?php endif; ?>
            </td>
        </tr>


        <tr data-element="colibri-invoice-info" data-label="Invoice Info">
            <td height="25" style="font-size:25px;line-height:25px;" data-height="Spacing under invoice info">&nbsp;</td>
        </tr>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\email/emailContactRequest.blade.php ENDPATH**/ ?>