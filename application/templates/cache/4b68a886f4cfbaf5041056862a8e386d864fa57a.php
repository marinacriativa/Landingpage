
<?php $__env->startSection('content'); ?>
<link href="css/calendar.css" rel="stylesheet">

<style>
td {
    padding-bottom: 10px !important;
    padding-left: 10px !important;
}

.form-group>label
{
    font-weight: bold
}

</style>

<section class="page-title pattern" style="background-image: url(/static/images/bg/02.jpg);">
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-name">
                <h1 style="color:#fff";>INSCRIÇÃO</h1>
                <p></p>
            </div>
            <ul class="page-breadcrumb">
                <li><a href="#"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-double-right"></i></li>
                <li><a href="#">Inscrição</a> <i class="fa fa-angle-double-right"></i></li>
                <li><span>Inscrição Sócio</span> </li>
            </ul>
        </div>
    </div>
</div>
</section>

<div class="container">


<form method="post" id="form">



    <h2 class="title-effect" style="margin: 50px 0 50px 0 ;">Dados Biográficos</h2>

    <div class="form-group">
        <label>Nome da Empresa: *</label>
        <input type="text" class="form-control" id="company_name">
    </div>

    <div class="form-group">
        <label>Nome Comercial: *</label>
        <input type="text" class="form-control"  id="commercial_name">
    </div>

    <div class="form-group">
        <label>Distrito: *</label>
        <select class="form-control" id="district_id" style="height: 50px;">
            <? foreach($distritos as $distrito) :?>
                <option value="<? echo $distrito["id"]?>"><? echo $distrito["name"]?></option>
            <? endforeach;?>
        </select>
    </div>

    <div class="form-group">
        <label>Morada: *</label>
        <input type="text" class="form-control"  id="address">
    </div>

    <div class="row">
        <div class="col-6">

            <div class="form-group">
                <label>Código Postal: *</label>
                <input type="text" class="form-control" id="zip_code">
                </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label>Localidade: *</label>
                <input type="text" class="form-control"  id="locale">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label>Telefone/Telemóvel: *</label>
                <input type="number" class="form-control" id="phone_number">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>Fax:</label>
                <input type="number" class="form-control" id="fax">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label>Email: *</label>
                <input type="email" class="form-control" id="email">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>Numero de Contribuinte: *</label>
                <input type="number" class="form-control" id="tax_identification_number">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label>CAE: *</label>
                <input type="number" class="form-control" id="economic_activity_number">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>Livro de Reclamações Nº: *</label>
                <input type="number" class="form-control" id="complaint_book_number">
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label>Livro de Reclamações em: *</label>
                <input type="date" class="form-control" id="complaint_book_date">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>Registo na DGCC:</label>
                <input type="text" class="form-control" id="dgcc_register">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Sócios: *</label>
    </div>
    <div id="partners">
        <div class="form-group">
            <input onkeyup="decideNewPartner()" type="text" class="form-control" placeholder="1 - (insira o nome)"  name="partners[]" id="partner1">
        </div>
    </div>

    <div class="form-group">
        <label>Representante na Associação: *</label>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label>Nome:</label>
                <input type="text" class="form-control" id="representant_name">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>Cargo:</label>
                <input type="text" class="form-control" id="representant_function">
            </div>
        </div>
    </div>

    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="validity">
        <label class="form-check-label" for="exampleCheck1" id="validityLabel">Declaro que todas as informações são veridicas. </label>
    </div>
</form>
<button id="button" onclick="sendContact()" class="btn btn-primary" style="margin:20px 0px 20px 0px">Enviar Formulário</button>
<p id="reply"></p>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>




function sendContact() {

    var partners="";
    var p_ids = document.forms[0].elements["partners[]"];
    for (var i = 0, len = p_ids.length; i < len-1; i++) {
      partners+= p_ids[i].value+"|";
    }


    var valid;
    valid = validateData(); //validateContact();

    if(valid) {
        alert("Inscrição enviada com sucesso.");
        jQuery.ajax({
            url: "/Actions/Associados/doEnviaAssociado.php",
            data:{
                company_name:$("#company_name").val(),
                commercial_name:$("#commercial_name").val(),
                district_id:$("#district_id").val(),
                address:$("#address").val(),
                zip_code:$("#zip_code").val(),
                locale:$("#locale").val(),
                phone_number:$("#phone_number").val(),
                fax:$("#fax").val(),
                email:$("#email").val(),
                tax_identification_number:$("#tax_identification_number").val(),
                economic_activity_number:$("#economic_activity_number").val(),
                complaint_book_number:$("#complaint_book_number").val(),
                complaint_book_date:$("#complaint_book_date").val(),
                dgcc_register:$("#dgcc_register").val(),
                representant_name:$("#representant_name").val(),
                representant_function:$("#representant_function").val(),
                partners:partners
            },
            type: "POST",
            success:function(data){
                $("#reply").html(data);
                $("#btn-enviar").css("display","none");
                $("#form").css("display","none");
                $("#button").css("display","none");
            },
            error:function (){
                alert("ERRO");
            }
        });
    }

}

function validateData(){

    $("#company_name").css("border","0px");
    $("#commercial_name").css("border","0px");
    $("#district_id").css("border","0px");
    $("#address").css("border","0px");
    $("#zip_code").css("border","0px");
    $("#locale").css("border","0px");
    $("#phone_number").css("border","0px");
    $("#fax").css("border","0px");
    $("#email").css("border","0px");
    $("#tax_identification_number").css("border","0px");
    $("#economic_activity_number").css("border","0px");
    $("#complaint_book_number").css("border","0px");
    $("#complaint_book_date").css("border","0px");
    $("#dgcc_register").css("border","0px");
    $("#representant_name").css("border","0px");
    $("#representant_function").css("border","0px");
    $("#partner1").css("border","0px");
    $("#validityLabel").css("color","#626262");

    var erros=false;
        //alert("Erro! Campos inválidos ou de preenchimento obrigatório. Por favor, conferir e reenviar.");

    if(!($("#company_name").val().length >0)){
        $("#company_name").css("border","solid 1px red");
        erros=true;
    }
    if(!($("#commercial_name").val().length >0)){
        $("#commercial_name").css("border","solid 1px red");
        erros=true;
    }
    if(!($("#district_id").val().length >0)){
        $("#district_id").css("border","solid 1px red");
        erros=true;
    }
    if(!($("#address").val().length >0)){
        $("#address").css("border","solid 1px red");
        erros=true;
    }
    if(!($("#zip_code").val().length >0)){
        $("#zip_code").css("border","solid 1px red");
        erros=true;
    }
    if(!($("#locale").val().length >0)){
        $("#locale").css("border","solid 1px red");
        erros=true;
    }
    if(!($("#phone_number").val().length >0)){
        $("#phone_number").css("border","solid 1px red");
        erros=true;
    }
    if(!($("#fax").val().length >0)){
        $("#fax").css("border","solid 1px red");
        erros=true;
    }
    if(!($("#tax_identification_number").val().length >0)){
        $("#tax_identification_number").css("border","solid 1px red");
        erros=true;
    }
    if(!($("#economic_activity_number").val().length >0)){
        $("#economic_activity_number").css("border","solid 1px red");
        erros=true;
    }
    if(!($("#complaint_book_number").val().length >0)){
        $("#complaint_book_number").css("border","solid 1px red");
        erros=true;
    }
    if(!($("#complaint_book_date").val().length >0)){
        $("#complaint_book_date").css("border","solid 1px red");
        erros=true;
    }
    if(!($("#dgcc_register").val().length >0)){
        $("#dgcc_register").css("border","solid 1px red");
        erros=true;
    }
    if(!($("#representant_name").val().length >0)){
        $("#representant_name").css("border","solid 1px red");
        erros=true;
    }
    if(!($("#representant_function").val().length >0)){
        $("#representant_function").css("border","solid 1px red");
        erros=true;
    }
    if(!($("#partner1").val().length >0)){
        $("#partner1").css("border","solid 1px red");
        erros=true;
    }
    if(!($("#email").val().indexOf("@")>0)){
        $("#email").css("border","solid 1px red");
        erros=true;
    }
    if(!$("#validity").is(':checked')){
        $("#validityLabel").css("color","red");
        erros=true;
    }

    return !erros;
}




function decideNewPartner() {

    var partners = document.getElementById('partners')
    var children = partners.children
    clearEmptyChildren(children)
    if(getInput(children[children.length-1]).value) {
        insertField(partners)
        refreshPlaceHolders(children)
    }

}
function clearEmptyChildren(children) {
    for (var i = 0; i < children.length-1; i++) {
        var child = children[i];
        if(getInput(child).value == "") {
            var parent = child.parentNode;
            parent.removeChild(child);
            refreshPlaceHolders(parent.children)
        }
    }
}
function getInput(div) {
    return div.children[0]
}
function insertField(partners) {
    var div = document.createElement('div')
    div.classList.add("form-group")
    var input = document.createElement('input')
    input.classList.add("form-control")

    input.setAttribute('onkeyup', 'decideNewPartner()')
    input.setAttribute('name', 'partners[]')
    div.appendChild(input)
    partners.appendChild(div)
}

function refreshPlaceHolders(children) {
    for (var i = 0; i < children.length; i++) {
        getInput(children[i]).setAttribute('placeholder', (i+1) +' - (insira o nome)')
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\frontoffice/pages/associatesform.blade.php ENDPATH**/ ?>