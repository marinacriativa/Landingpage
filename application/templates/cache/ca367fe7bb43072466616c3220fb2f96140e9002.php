
<?php $__env->startSection('content'); ?>
    <main class="default-transition pt-5 mb-5 collapsable-main no-load">
        <div class="p-desktop-5">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <h1><?php echo e(ucfirst($translations["backoffice"]["homepage"])); ?></h1>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="/adm"><?php echo e(ucfirst($translations["backoffice"]["store"])); ?></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?php echo e(ucfirst($translations["backoffice"]["homepage"])); ?>                                    
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="separator mb-5"></div>
                </div>
            </div>


            <div class="row">
                <div class="col-12 list sortable" data-check-all="checkAll" id="items-list">
                </div>
                <div class="col-12">

                    <nav class="mt-4 mb-3">
                        <ul class="pagination justify-content-center mb-0">
                        </ul>
                    </nav>
                </div>
            </div>                
            
        
        </div>
    </main>
            
<?php $__env->stopSection(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php $__env->startSection('scripts'); ?>
    <script>   

        homepage();

        function homepage() {
            
            initHomePages();

            function initHomePages() {             

                $.ajax({
                    url: "/api/homepage",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {

                        if (!response.success) {

                            // Output do erro
                            console.error(response);

                            $.alert({
                                title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                                theme: "supervan",
                                content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                            });

                            // Não deixar a função executar mais
                            return;
                        }                 
                                    
                        
                        populatehomepage(response.data);                              
                        
                        // Ativar os listners 
                        listenershomepage();

                        setTimeout(() => {
                            $( ".sortable" ).sortable({                        
                                cursor: "move",
                                dropOnEmpty: true,
                                tolerance: "pointer",
                                opacity: 0.7,
                                revert: 300,
                                delay: 150,
                                placeholder: "movable-placeholder",
                                start: function(e, ui) {
                                    ui.placeholder.height(ui.helper.outerHeight());
                                },
                                stop:function () {
                                    var ids = '';
                                    $('.ui-sortable-handle').each(function () {                                
                                        id = $(this).attr("data-id");                        
                                        if(ids == '') {
                                            ids = id;
                                        } else {
                                            ids = ids + ',' + id;
                                        }
                                    })
                                
                                    $.ajax({
                                        url: "/api/homepage/sortable",
                                        type: "POST",
                                        data: {ids: ids},
                                        dataType: "json",
                                        success: function (response) {
                                            if (!response.success) {
                                            // Output do erro
                                            console.error(response);
                                            $.alert({
                                                title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                                                theme: "supervan",
                                                content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                                            });
                                            // Não deixar a função executar mais
                                            return;
                                            }
                                        }
                                    })
                                }
                            })
                        }, 500)                       
                        
                        
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                        console.log(textStatus, errorThrown);

                        $.alert({
                            title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                            theme: "supervan",
                            content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                        });
                    }
                });
                
            }  
            
            
            
            function populatehomepage(items) {
                $(`#items-list`).html("");

                $.each(items, function (key, homepage) {
                    let is_checked = homepage.active == 1 ? 'checked' : '';
                    $(`#items-list`).append(`
                    <div class="card d-flex flex-row mb-3" data-id="` + homepage.id + `">                    
                        <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                            <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center">
                          
                                <p class="list-item-heading mb-0 truncate">` + homepage.name + `</p>
                          
                                <span class="custom-switch custom-switch-secondary mb-2 custom-switch-small vertical-align-center"> 
                                    <input class="custom-switch-input change_active_status" data-id="` + homepage.id + `" id="homepage-active-` + homepage.id + `" type="checkbox" name="active" ${is_checked}> 
                                    <label rel="tooltip" title="Desativado / Ativado" class="custom-switch-btn" for="homepage-active-` + homepage.id + `"></label> 
                                </span>
                            </div>
                        </div>
                    </div>
                    `);
                });
                
                //Caso os items estejam vazios
                if (items === undefined || items.length == 0) {

                    //Na listagem meter uma mensagem a dizer que está vazio
                    $(`#items-list`).html(`
                        <h4><?php echo e(ucfirst($translations["backoffice"]["not_found_male"])); ?> <?php echo e($translations["backoffice"]["homepage"]); ?></h4>
                        <p class="text-muted"><?php echo e(ucfirst($translations["backoffice"]["try_again_later_empty"])); ?></p>
                    `);
                }  
            } 

            $("#checkAll").click(function(){
                $('.checkbox-allowed').not(this).prop('checked', this.checked);
                
            });

            function edithomepage(id = "", data) {       
            
                $.ajax({
                    url: "/api/homepage/" + id,
                    type: "POST",
                    data: data,
                    dataType: "json",
                    success: function(response) {

                        if (!response.success) {

                            // Output do erro
                            console.error(response);

                            $.alert({
                                title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                                theme: "supervan",
                                content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                            });

                            initHomePages()

                            // Não deixar a função executar mais
                            return;
                        }                       
                        
                        // Obter dados novos do servidor
                        initHomePages();


                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                        console.log(textStatus, errorThrown);

                        $.alert({
                            title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                            theme: "supervan",
                            content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                        });
                    }
                });
            }

            function listenershomepage() {              

                $(".change_active_status").off("click");
                $(".change_active_status").on("click", function() {

                    let id  = $(this).attr("data-id");

                    $.ajax({
                        url: "/api/homepageActive/" + id,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {

                            if (!response.success) {

                                // Output do erro
                                console.error(response);

                                $.alert({
                                    title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                                    theme: "supervan",
                                    content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                                });

                                initHomePages()

                                // Não deixar a função executar mais
                                return;
                            }                       
                            
                            // Obter dados novos do servidor
                            initHomePages();


                        },
                        error: function(jqXHR, textStatus, errorThrown) {

                            console.log(textStatus, errorThrown);

                            $.alert({
                                title: '<?php echo e(ucfirst($translations["backoffice"]["error"])); ?>',
                                theme: "supervan",
                                content: '<?php echo e(ucfirst($translations["backoffice"]["error_console"])); ?>',
                            });
                        }
                    });
                    
                });

            }          

        }
    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\backoffice/pages/homepage/index.blade.php ENDPATH**/ ?>