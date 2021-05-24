<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="container">
        <div class="row">
            <section class="col-xs-12 col-sm-12 col-md-12 page-incubadoras">
                <h1 class="pageTitleAssociated">
                    <?php echo _("Incubadora"); ?>
                </h1>
				<div class="row containerVoltar">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<a href="<?php echo get_permalink(get_page_by_path( 'associados' ) ); ?>" class="Voltar pull-right"><?php echo _("< Voltar"); ?></a>
					</div>
				</div>
                <div class="the-content">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<ul>
							<li class="row first-line">
								<div class="field_title col-xs-3 col-sm-3 col-md-3">
									<?php echo __("Nome:"); ?>
								</div>
								<div class="field_content col-xs-9 col-sm-9 col-md-9">
									<?php echo get_the_title(); ?>
								</div>
							</li>
							<li class="row">
								<div class="field_title col-xs-3 col-sm-3 col-md-3">
									<?php echo __("Descrição:"); ?>
								</div>
								<div class="field_content col-xs-9 col-sm-9 col-md-9 internDescription">
									<?php the_translate_field('incubadora_descricao', $post->ID); ?>
									<?php // $incubadoraDescription = get_post_custom_values("incubadora_descricao", $post->ID); echo wpautop($incubadoraDescription[0]); ?>
								</div>
							</li>
						</ul>
					</div>
					<div class="col-xs-5 col-sm-5 col-md-5 pull-right">
						<ul class="lateral-info">
							<?php
							$logotipo_associado = get_field("incubadora_logotipo", $post->id);
							if($logotipo_associado){
							?>
							<li>
								<h1 class="logoAssociado">
								<?php echo __("Logotipo"); ?>
								</h1>
								<?php
									echo sprintf("<img src=\"%s\" />", $logotipo_associado['sizes']['medium']);
								?>
							</li>
							<?php
							}
							?>
							<?php

								$contatos_associado = get_field("incubadora_contatos", $post->id);
								$telefone_associado = get_field("incubadora_telefone", $post->id);
								$email_associado = get_field("incubadora_email", $post->id);
								$endereco_associado = get_field("incubadora_endereco", $post->id);
								$site_associado = get_field("incubadora_site", $post->id);

								if($contatos_associado OR $telefone_associado OR $email_associado OR $endereco_associado OR $site_associado){
							?>
							<li class="info-contact">
									<ul>
							<?php
								if(!empty($contatos_associado) AND is_array($contatos_associado)){
									$exportedContatos = "<li><p><i class=\"fa fa-users\"></i>";
									foreach($contatos_associado AS $arraySingleContato){
										$exportedContatos .= sprintf("%2\$s<br />", !empty($arraySingleContato['contato_cargo'])?$arraySingleContato["contato_cargo"]." ":"", $arraySingleContato["contato_nome"]);
									}
									$exportedContatos .= "</p></li>";

									echo $exportedContatos;
								}
							?>
							<?php
								if($telefone_associado){
									echo "<li><p><i class=\"fa fa-phone\"></i>{$telefone_associado}</p></li>";
								}
							?>
							<?php
								if($email_associado){
									echo "<li><p><i class=\"fa fa-envelope-o\"></i>{$email_associado}</p></li>";
								}
							?>
							<?php
								if($site_associado){
									#$site_associado = make_clickable($site_associado);
									$site_associado = "<a target=\"_blanck\" href=\"http://{$site_associado}\" class=\"acesseAssociado\">"._("Acesse o associado")."</a>";
									echo "<li><p><i class=\"fa fa-television\"></i>{$site_associado}</p></li>";
								}
							?>
							<?php
								if($endereco_associado){
									echo "<li><p><i class=\"fa fa-home\"></i>{$endereco_associado}</p></li>";
								}
							?>
									</ul>
								</li>
							<?php
								}
							?>
						</ul>

						<h1 class="indicadoresAssociado">
							<?php echo __("Indicadores"); ?>
						</h1>
						<div class="row">
							<div class="content-numbers  col-xs-12 col-sm-12 col-md-12">
								<i class="icon-numbers icon-empresas-pre-incubadas"></i>
								<div class="content-text-reinc col-xs-8 col-sm-8 col-md-8">
									<span class="text-numbers-reinc"><?php echo __("Pré-incubadas"); ?></span>
								</div>
								<div class="col-xs-2 col-sm-2 col-md-2">
									<span class="numbers"><?php echo getEmpresasStatus("pre-incubadas", get_the_ID()); ?></span>
								</div>
							</div>
							<div class="content-numbers col-xs-12 col-sm-12 col-md-12">
								<i class="icon-numbers icon-empresas-incubadas"></i>
								<div class="content-text-reinc col-xs-12 col-sm-8 col-md-8">
									<span class="text-numbers-reinc"><?php echo __("Incubadas", get_the_ID()); ?></span>
								</div>
								<div class="col-xs-12 col-sm-2 col-md-2">
									<span class="numbers"><?php echo getEmpresasStatus("incubadas", get_the_ID()); ?></span>
								</div>
							</div>
							<div class="content-numbers col-xs-12 col-sm-12 col-md-12">
								<i class="icon-numbers icon-empresas-graduadas"></i>
								<div class="content-text-reinc col-xs-8 col-sm-8 col-md-8">
									<span class="text-numbers-reinc"><?php echo __("Graduadas"); ?></span>
								</div>
								<div class="col-xs-2 col-sm-2 col-md-2">
									<span class="numbers"><?php echo getEmpresasStatus("graduadas", get_the_ID()); ?></span>
								</div>
							</div>
							<div class="content-numbers col-xs-12 col-sm-12 col-md-12">
								<i class="icon-numbers icon-empresas-associadas"></i>
								<div class="content-text-reinc col-xs-8 col-sm-8 col-md-8">
									<span class="text-numbers-reinc"><?php echo __("Associadas"); ?></span>
								</div>
								<div class="col-xs-2 col-sm-2 col-md-2">
									<span class="numbers"><?php echo getEmpresasStatus("associadas", get_the_ID()); ?></span>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="the-content container-fluid">
					<ul class="inline-menu-associates">
						<li id="empresaChooseOptions" class="associate_type">
							<div class="pull-right retractileIcon">
								<i class="fa fa-minus-circle"></i>
							</div>
							<div id="associate_type_title" data-toggle="collapse" data-target="#empresa_subitens">
								<?php echo __("Empresas"); ?>
							</div>
							<ul id="empresa_subitens" class="subitens row collapse">
								<?php
									$buildAssociatesMenuForIncubadoras = buildAssociatesMenu("empresa_status", array('hide_empty' => false));
									foreach($buildAssociatesMenuForIncubadoras AS $associatedIncubadoraInfo){
										if(empty($associatedIncubadoraInfo)) continue;
										echo sprintf("<li class=\"col-xs-3 col-sm-3 col-md-3\"><div><a href=\"%1\$s\" data-associate_type=\"%5\$s\" data-associate_category=\"%3\$s\" class=\"requestAssociate %3\$s\" id=\"Empresa-%3\$s\">%4\$s</a></div></li>",/*$associatedIncubadoraInfo['link']*/"#", $associatedIncubadoraInfo['term_id'], (!empty($associatedIncubadoraInfo['slug'])?$associatedIncubadoraInfo['slug']:"all"), $associatedIncubadoraInfo['name'],
										get_the_ID());
									}
								?>
							</ul>
						</li>
					</ul>
				</div>
            </section>
			<section id="associates_result_stage" class="col-xs-12 col-sm-12 col-md-12">
				<div id="associate_loading">
					<button class="btn btn-lg" disabled><span class="fa fa-refresh fontawesome-refresh-animate"></span> <?php echo __("Carregando..."); ?></button>
				</div>
				<div id="associate_results" class="row-fluid"></div>
				<div id="associate_pagination" class="row-fluid clearitems">
                </div>
			</section>
		</div>
		<div class="row">
			<?php if (get_field("incubadora_slideshow", $post->id)) : ?>
				<?php $incubadora_slideshow = get_field("incubadora_slideshow", $post->id); ?>
				<section id="galeria" >
					<h1 class="indicadoresAssociado col-xs-12">
						<?php echo __("Galeria de Fotos", 'natio-lang'); ?>
					</h1>
					<ul>
						<?php foreach($incubadora_slideshow AS $individualPhoto){ ?>
							<li class="item-galeria col-xs-12 col-sm-6 col-md-3">
								<a href="<?php echo $individualPhoto['url']; ?>" class="fancybox" rel="gallery-fancybox">
									<img src="<?php echo $individualPhoto['sizes']['medium']; ?>" alt="<?php echo $individualPhoto['title']; ?>">
								</a>
							</li>
						<?php } ?>
					</ul>
				</section>
			<?php endif; ?>
			<?php /*
				$incubadora_slideshow = get_field("incubadora_slideshow", $post->id);
				if($incubadora_slideshow){
			?>
			<section id="carousel_stage" class="col-xs-12 col-sm-12 col-md-12">
				<div id="carouselIncubadora" class="carousel slide" data-ride="carousel">
					<!-- Wrapper for carousel items -->
					<div class="carousel-inner">
						<?php
						$i = 1;
						foreach($incubadora_slideshow AS $individualPhoto){
							$active = ($i==1) ? "active" : NULL;
						?>
						<div class="item <?php echo $active; ?>">
							<img src="<?php echo $individualPhoto['sizes']['large']; ?>" alt="<?php echo $individualPhoto['title']; ?>">
						</div>
						<?php
							$i++;
						}
						?>
					</div>
					<!-- Carousel indicators -->
					<ol class="carousel-indicators">
						<?php
						for($j=1;$j<=$i;$j++){
							$active = ($j==$i)?"active":NULL;
						?>
						<li data-target="#carouselIncubadora" data-slide-to="<?php echo ($j-1); ?>" class="<?php echo $active; ?>"></li>
						<?php
						}
						?>
					</ol>
				</div>
			</section>
			<?php
				}
				*/
			?>
        </div>
    </div>
<?php endwhile; ?>

<?php
	wp_enqueue_script( 'wp-api' );
?>
<script type="application/javascript">

	/**
	 * Variable to hold the ajax request
	 */
	var xhr;
	/**
	 * Array to hold the current filters
	 */
	var currentTermsToFilter = [];

	function isEmpty(str) {
		return typeof str == 'string' && !str.trim() || typeof str == 'undefined' || str === null;
	}

	function generateResultGrid(currentIncubadora, paged, terms, removeTerm, moreContent){
		if(typeof currentIncubadora === 'undefined') return false;
		var postsPerPage = "<?php echo !empty($maxPageRestAPI)?$maxPageRestAPI:"5"; ?>";
		var paged=(isNaN(paged) || paged==0)?1:paged;
		var removeTerm = (typeof removeTerm !== 'undefined')?removeTerm:false;
		var moreContent = (typeof removeTerm !== 'undefined')?moreContent:false;

		if(xhr) xhr.abort();

		if(typeof terms !== 'undefined'){
			if(removeTerm==true){
				currentTermsToFilter = jQuery.grep(currentTermsToFilter, function(value) {
				  return value != terms;
				});
			}else{
				if(!isEmpty(terms)){
					currentTermsToFilter.push(jQuery.trim(terms));
				}
			}
		}

		currentTermsToFilter = currentTermsToFilter.filter(function(v){return v!==''});

		if(currentTermsToFilter.length==0){
			jQuery('.all[data-associate_type="'+currentPostType+'"]').closest("li").addClass("in");
			console.log('selecting all');
		}

		console.log("current post type "+currentIncubadora);
		console.log("current terms to filter "+currentTermsToFilter);
		console.log("current terms to filter length "+currentTermsToFilter.length);

		jQuery("#associate_loading").show();

		xhr = jQuery.getJSON("<?php echo esc_url( home_url( '/wp-json/reinc-api/v1/get_empresas_per_incubadora' ) );  ?>",
			{
				"inc_id": currentIncubadora,
				"filter": {
					"terms": currentTermsToFilter,
					"paged": paged,
					"posts_per_page": postsPerPage
				}
			});
		xhr.done(function(data){
			console.log("Done");
			console.log(data);
			jQuery(".associates_not_found").remove();

			if(isEmpty(data.posts)){
				jQuery("#associate_results").append("<div class=\"col-xs-12 col-sm-12 col-md-12 associates_not_found\"><button class=\"btn btn-lg\" disabled><span class=\"fa fa-close\"></span> <?php echo __("Nenhum resultado encontrado."); ?></button></div>");
				jQuery(".requestMoreAssociate").hide();
				jQuery("#associate_loading").hide();
				return false;
			}

			if(moreContent!=true){
				jQuery("#associate_results").empty();
			}

			/**
			 * Cleaning HTML target div
			 */
			jQuery.each(data.posts, function(index, post){

				if(post.logotipo.thumbnail){
					var frontContent = "<img src=\""+post.logotipo.thumbnail+"\" alt=\""+post.title+"\"/>";
				}else{
					//var frontContent = "<h3 class=\"hover-title-associate\">"+post.title+"</h3>";
					var frontContent = "<img src=\"<?php echo get_bloginfo('template_url') . '/assets/img/thumb-default-150.png';  ?>\" alt=\""+post.title+"\"/>";
				}

				jQuery("#associate_results").append(""+
				"<div class=\"associate_item col-xs-3 col-sm-3 col-md-3\">"+
					"<div class=\"item-container "+post.type +" \" ontouchstart=\"this.classList.toggle('hover');\">"+
						"<a class=\"link\" href=\""+post.link+"\">"+
							frontContent +
							"<h3 class=\"h3\">"+post.title+"</h3>"+
						"</a>"+
					"</div>"+
				"</div>"+
				"");
			});

			if(data.pagination.hasMore){
				jQuery("#associate_pagination").empty().append("<div class=\"col-xs-12 col-sm-12 col-md-12\"><button type=\"button\" class=\"btn btn-default btn-lg requestMoreAssociate\" data-associate_type=\""+type+"\" data-associate_category=\""+terms+"\" data-paged=\""+data.pagination.next+"\"><?php echo __("Carregar mais resultados"); ?></button></div>");
			}else{
				jQuery(".requestMoreAssociate").hide();
			}

		});

		jQuery("#associate_loading").hide();

	}

jQuery(document).ready(function(){

	jQuery("#empresaChooseOptions").addClass("collapse-in");
	jQuery("#empresa_subitens").addClass("collapse in");

	jQuery("body").on("shown.bs.collapse hidden.bs.collapse", "#empresa_subitens", function(){
		console.log("Show Collapse fields");
		jQuery(".collapse-in").removeClass("collapse-in");
		jQuery(this).closest(".associate_type").addClass("collapse-in");
		jQuery(".associate_type").not(".collapse-in").find(".retractileIcon i").removeClass("fa-minus-circle").addClass("fa-plus-circle");
		jQuery(".associate_type.collapse-in").find(".retractileIcon i").addClass("fa-minus-circle").removeClass("fa-plus-circle");
		jQuery(".associate_type").not(".collapse-in").find(".in").removeClass("in");
	}).on("hidden.bs.collapse", '#empresa_subitens', function () {
		console.log("Hide Collapse fields");
		jQuery(".collapse-in").removeClass("collapse-in");
		jQuery(".associate_type").not(".collapse-in").find(".retractileIcon i").removeClass("fa-minus-circle").addClass("fa-plus-circle");
		jQuery(this).closest(".associate_type").removeClass("collapse-in");
	});

	jQuery("body").on("click", ".requestMoreAssociate", function(event){
		event.preventDefault();

		var associate_type = jQuery(this).data('associate_type');
		var associate_category = jQuery(this).data('associate_category');
		var paged_associate = (isNaN(jQuery(this).data('paged')))?0:jQuery(this).data('paged');

		generateResultGrid(associate_type, paged_associate, false, false, true);

	});

	jQuery("body").on("click", ".requestAssociate", function(event){
		event.preventDefault();

		var associate_type = jQuery(this).data('associate_type');
		var associate_category = jQuery(this).data('associate_category');
		var paged_associate = (isNaN(jQuery(this).data('paged')))?0:jQuery(this).data('paged');
		var removeTerm = false;

		if(jQuery(this).closest("li").hasClass("in")){
			jQuery(this).closest("li").removeClass("in");
			removeTerm=true;
		}else{
			jQuery(this).closest("li").addClass("in");
		}

		if(jQuery(this).hasClass('all')){
			currentPostType=associate_type;
			currentTermsToFilter=[];
			jQuery('[data-associate_type="'+associate_type+'"]').each(function(index, value){
				jQuery(this).closest("li").addClass("in");
				currentTermsToFilter.push(jQuery(this).data('associate_category'));
			});
		}else{
			jQuery('.all[data-associate_type="'+associate_type+'"]').closest("li").removeClass("in");
			currentTermsToFilter = jQuery.grep(currentTermsToFilter, function(value) {
			  return value != "all";
			});
		}

		generateResultGrid(associate_type, paged_associate, associate_category, removeTerm);

	});

});
</script>

<?php endif; ?>

<?php get_footer(); ?>
