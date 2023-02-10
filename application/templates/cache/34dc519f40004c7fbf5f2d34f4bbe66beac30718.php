<div id="sitemap_settings">
    <h4 class="inline"><?php echo e(ucfirst($translations["backoffice"]["sitemap_title"])); ?></h4>
    <div class="top-right-button-container d-flex">
        <?php if(file_exists(ROOT . "public/sitemap.xml")): ?>
            <a href="/sitemap.xml" target="_blank" download>
                <button type="button" class="btn btn-outline-primary btn-xs">Download</button>
            </a>
        <?php endif; ?>
        <button type="button" class="btn btn-outline-primary btn-xs new-sitemapurl">Adicionar página</button>
    </div>
    <hr>

    <div class="row" id="siteMapUrls">
        <div class="col-6">
            <label class="form-group has-float-label">
                <input class="form-control" type="text" placeholder="URL da página ex: en/contact" value="">
                <span>Página</span>
            </label>
        </div>
    </div>


    

    <button type="button" class="btn btn-outline-primary btn-xs float-right generate" data-settings="pg_index,pg_index_priority,pg_aboutus,pg_aboutus_priority,pg_contact,pg_contact_priority"><?php echo e(ucfirst($translations["backoffice"]["generate_sitemap"])); ?></button>
</div>


<script>

    function sitemap () {

    }

    $(".new-sitemapurl").on("click", function() {
        $("#siteMapUrls").append(`
            <div class="col-6">
                <label class="form-group has-float-label">
                    <input class="form-control" type="text" placeholder="URL da página" value="">
                    <span>Página</span>
                </label>
            </div>
        `);
    })

    $(".generate").off("click");
        $(".generate").on("click", function() {

            generate_sitemap();
    });

    
    function generate_sitemap () {
      

        var allPages = [];

        $("#siteMapUrls input").each(function() {
            allPages.push($(this).val());
        });
        
        var data = {allPages};


        $.ajax({
			url: "/api/sitemap/",
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

					// Não deixar a função executar mais
					return;
				}
                
				$.alert({
                    title: `Sitemap gerado com sucesso`,
                    theme: "supervan",
                    content: 'Pode acessar o sitemap em: <?php echo e(URL); ?>sitemap.xml',
                });
           
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

</script><?php /**PATH C:\wamp64\www\CRIATIVA\application\templates\backoffice/pages/config/items/sitemap.blade.php ENDPATH**/ ?>