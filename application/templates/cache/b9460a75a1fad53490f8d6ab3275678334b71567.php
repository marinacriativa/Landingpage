
<?php $__env->startSection('content'); ?>
<section class="page-title pattern" style="background-image: url(/static/images/bg/01.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-name">
                    <h1>LEGISLAÇÃO</h1>
                </div>
                <ul class="page-breadcrumb">
                    <li><a href="#"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-double-right"></i></li>
                    <li><span>Legislação</span></li>
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
                <? foreach ($files as $grupo => $ficheiros) :?>
                    <div class="parent-group acd-group">
                        <a href="#" class="acd-heading"><? echo $grupo; ?> (<? echo count($ficheiros);?>)</a>
                        <div class="acd-des">
                            <div class="container">
                                <? foreach ($ficheiros as $ficheiro) :?>
                                <div class="acd-group">
                                    <a href="#" class="acd-heading"><? echo $ficheiro["name"] ?></a>
                                    <div class="acd-des"><? echo $ficheiro["description"] ?>
                                      <br><a href="<? echo URL ?>/static/storage/assets/files/laws/<? echo $ficheiro["id"] ?>.pdf" target="_blank"> <i class="fa fa-eye not-click btn "></i> Visualizar</a>
                                      <a href="<? echo URL ?>/static/storage/assets/files/laws/<? echo $ficheiro["id"] ?>.pdf" download="<? echo URL ?>/static/storage/assets/files/laws/<? echo $ficheiro["id"] ?>.pdf"> <i class="fa fa-download not-click btn"></i> Baixar</a>
                                    </div>
                                </div>
                                <? endforeach;?>
                            </div>

                        </div>
                    </div>
                <? endforeach; ?>

            </div>
            <div id="splited" style="display: none" class="accordion plus-icon shadow mb-30">

                <? foreach ($files as $grupo => $ficheiros) :?>
                <? foreach ($ficheiros as $ficheiro) :?>
                <div class="acd-group filtered">
                    <a href="#" class="acd-heading"><? echo $ficheiro["name"] ?></a>
                    <div class="acd-des"><? echo $ficheiro["description"] ?>
                        <br><a href="<? echo URL ?>/static/storage/assets/files/laws/<? echo $ficheiro["id"] ?>.pdf" target="_blank"> <i class="fa fa-eye not-click btn "></i> Visualizar</a>
                        <a href="<? echo URL ?>/static/storage/assets/files/laws/<? echo $ficheiro["id"] ?>.pdf" download="<? echo URL ?>/static/storage/assets/files/laws/<? echo $ficheiro["id"] ?>.pdf"> <i class="fa fa-download not-click btn"></i> Baixar</a>
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/legislation.blade.php ENDPATH**/ ?>