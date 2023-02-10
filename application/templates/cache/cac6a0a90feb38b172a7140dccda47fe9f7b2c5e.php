
<?php $__env->startSection('content'); ?>
<section class="page-title pattern" style="background-image: url(/static/images/bg/01.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-name">
                    <h1>Agências Associadas</h1>
                </div>
                <ul class="page-breadcrumb">
                    <li><a href="#"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-double-right"></i></li>
                    <li><span>Agências Associadas</span></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row mt-50">
        <div class="col-lg-12">
            <input type="text" class="search" onkeyup="search(this)"  placeholder="Pesquisar"></input>
            <div id="grouped" class="accordion plus-icon shadow mb-30">
                <? foreach ($associados as $district => $agencias) :?>
                <div class="parent-group acd-group">
                    <a href="#" class="acd-heading"><? echo $district; ?> (<? echo count($agencias);?>)</a>
                    <div class="acd-des">
                        <div class="container">
                            <? foreach ($agencias as $agencia) :?>
                            <div class="acd-group">
                                <a href="#" class="acd-heading"><? echo $agencia["company_name"] ?></a>
                                <div class="acd-des row">
                                    <div class="col-6">
                                        <p><b>Nome:</b> <?echo $agencia["company_name"]?></p>
                                        <p><b>Morada:</b> <?echo $agencia["address"]?></p>
                                        <p><b>Código Postal:</b> <?echo $agencia["zip_code"]?> <?echo $agencia["locale"]?></p>
                                    </div>
                                    <div class="col-6">
                                        <p><b>Número Telemóvel:</b> <?echo $agencia["phone_number"]?></p>
                                        <p><b>Fax:</b> <?echo $agencia["fax"]?></p>
                                        <p><b>E-mail:</b> <?echo $agencia["email"]?></p>
                                    </div>
                                </div>
                            </div>
                        <? endforeach;?>
                    </div>

                </div>
            </div>
        <? endforeach; ?>

    </div>
    <div id="splited" style="display: none" class="accordion plus-icon shadow mb-30">

        <? foreach ($associados as $district => $agencias) :?>
        <? foreach ($agencias as $agencia) :?>
        <div class="acd-group filtered">
            <a href="#" class="acd-heading"><? echo $agencia["company_name"] ?></a>
            <div class="acd-des row">
                <div class="col-6">
                    <p><b>Nome:</b> <?echo $agencia["company_name"]?></p>
                    <p><b>Morada:</b> <?echo $agencia["address"]?></p>
                    <p><b>Código Postal:</b> <?echo $agencia["zip_code"]?> <?echo $agencia["locale"]?></p>
                </div>
                <div class="col-6">
                    <p><b>Número Telemóvel:</b> <?echo $agencia["phone_number"]?></p>
                    <p><b>Fax:</b> <?echo $agencia["fax"]?></p>
                    <p><b>E-mail:</b> <?echo $agencia["email"]?></p>
                </div>
            </div>
        </div>
        <? endforeach;?>
        <? endforeach; ?>

    </div>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function search(input) {
    var elements, element, i, filter, txtValue, heading, description;
    filter = input.value.toUpperCase();
    if(filter) {
        $('#splited').show();
        $('#grouped').hide();
    } else {
        $('#splited').hide();
        $('#grouped').show();
        $('.acd-des').hide();
    }
    elements = document.getElementsByClassName("filtered");
    for (i = 0; i < elements.length; i++) {
        element = elements[i];
        if (element) {
            heading = element.getElementsByTagName("a")[0]
            description = element.getElementsByTagName("div")[0]
            heading = heading.textContent || heading.innerText;
            description = description.textContent || description.innerText;
            txtValue = heading + description
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                elements[i].style.display = "";
            } else {
                elements[i].style.display = "none";
            }
        }
    }
    elements = document.getElementsByClassName("parent-group");
    for (i = 0; i < elements.length; i++) {
        element = elements[i];
        if(element.getElementsByClassName("filtered").length != 0) {
            if(!element.classList.contains('acd-active')) {
                element.classList.add('acd-active')
            }
        } else {
            element.classList.remove('acd-active')
        }
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/associates.blade.php ENDPATH**/ ?>