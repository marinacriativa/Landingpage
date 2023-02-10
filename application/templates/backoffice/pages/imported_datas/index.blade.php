@extends('layouts.master')
@section('content')
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <h1>{{ ucfirst($translations["backoffice"]["imported_datas"]) }}</h1>                        
                    </div>                   
                </div>
            </div>


            <div class="row">
                <div class="col-12 list sortable" data-check-all="checkAll" id="items-list">
                    <form id="sendFile">
                        <input class="form-control" id="file_input" name="file_input" type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        <br>
                        <input class="form-control btn btn-primary" id="btn-text" type="submit" value="Enviar">
                    </form>
                </div>               
            </div>                
            
            <div class="row">
                <div class="col-12 list" data-check-all="checkAll">
                    <div class="card col-12 p-0">
                        <div class="card-body">
                            <div class="table-responsive">
                                <h4 class="inline">Histórico</h4> 
                                <hr>
                                <div class="table-responsive">
                                    <table id="thetable2" class="dt-responsive stripe languages-table dataTable no-footer dtr-inline" >
                                        <thead>
                                            <tr role="row">
                                                <th class="pl-0">#</th>
                                                <th class="pl-0">Ficheiro</th>
                                                <th class="pl-0">Usuário</th>                                               
                                                <th class="pl-0">Data</th>
                                                <th class="pl-0"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="historic-table">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>               
            </div>     
        
        </div>
    </main>
            
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@section('scripts')
    <script>  
            $('#sendFile').submit(function (e) {
                e.preventDefault();
                
                var data = new FormData(this);
                $('#btn-text').val('Aguarde, importando...');
                $.ajax({
                    url: "/api/imported_datas/",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        if (!response.success) {

                            $('#btn-text').val('Erro! tente novamente.');

                            setTimeout(function(){
                                $('#btn-text').val('Enviar');
                            }, 3000)

                            // Output do erro
                            console.error(response);

                            $.alert({
                                title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                theme: "supervan",
                                content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                            });

                            // Não deixar a função executar mais
                            return;
                        }                       
                        
                        console.log(response);
                        $('#btn-text').val('Enviado com sucesso!');

                        setTimeout(function(){
                            $('#btn-text').val('Enviar');
                        }, 3000)

                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                        console.log(textStatus, errorThrown);

                        $.alert({
                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                            theme: "supervan",
                            content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                        });
                    }
                });            

            })

            load();
        
            function load() {

                $.ajax({
                    url: "/api/historic/get",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        if (!response.success) {

                            $.alert({
                                title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                                theme: "supervan",
                                content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                            });

                            // Não deixar a função executar mais
                            return;
                        }

                        populate(response.data);

                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                        console.log(textStatus, errorThrown);

                        $.alert({
                            title: '{{ ucfirst($translations["backoffice"]["error"]) }}',
                            theme: "supervan",
                            content: '{{ ucfirst($translations["backoffice"]["error_console"]) }}',
                        });
                    }
                });
            }

            function populate(items) {

                // Limpar a lista de items que temos
                $("tbody").html("");

                $.each(items, function(key, item) {

                    let template = `
                        <tr class="text-muted" id="tblData"  data-id="`+ item.id + `">
                            <th scope="row">` + item.id + `</th>
                            <td class="pr-3">` + item.name + `</td>
                            <td class="pr-3"><span class="badge badge-light w-100">` + item.user + `</span></td>                         
                            <td class="pr-3"><span class="badge badge-primary">` + item.data + `</span></td>
                        </tr>`;

                    $("tbody").append(template);
                });

                // Caso o items esteja vazio

                if (items === undefined || items.length == 0) {

                    // Na listagem meter uma mensagem a dizer que está vazio
                    $("tbody").html(`
                    <br><br>
                        <h4>{{ ucfirst($translations["backoffice"]["not_found_male"]) }} registros. </h4>
                        <p class="text-muted">{{ ucfirst($translations["backoffice"]["try_again_later_empty"]) }}</p>
                    `);
                }
            }
    </script>
@endsection


