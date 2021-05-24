<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="container">
        <div class="row">
            <section class="col-xs-12 col-sm-12 col-md-12 page-incubadoras">
                <h1 class="pageTitleAssociated">
                    <?php echo __("Incubadora", "natio-lang"); ?>
                </h1>
				<div class="row containerVoltar hidden-print">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<a href="<?php echo get_permalink(get_page_by_path( 'associados' ) ); ?>" class="Voltar pull-right"><?php echo __("< Voltar", "natio-lang"); ?></a>
					</div>
				</div>
                <div class="the-content">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<ul>
							<li class="row first-line">
								<div class="field_title col-xs-3 col-sm-3 col-md-3">
									<?php echo __("Nome", "natio-lang"); ?>:
								</div>
								<div class="field_content col-xs-9 col-sm-9 col-md-9">
									<?php echo get_the_title(); ?>
								</div>
							</li>
							<li class="row">
								<div class="field_title col-xs-3 col-sm-3 col-md-3">
									<?php echo __("Descrição", "natio-lang"); ?>:
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
										if($telefone_associado){
											echo "<li><p><i class=\"fa fa-phone\"></i>{$telefone_associado}</p></li>";
										}
										if($email_associado){
											echo "<li><p><i class=\"fa fa-envelope-o\"></i>{$email_associado}</p></li>";
										}
										if($site_associado){
											#$site_associado = make_clickable($site_associado);
											$site_associado = "<a target=\"_blanck\" href=\"http://{$site_associado}\" class=\"acesseAssociado\">".__("Acesse o associado", "natio-lang")."</a>";
											echo "<li><p><i class=\"fa fa-television\"></i>{$site_associado}</p></li>";
										}
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
							<?php echo __("Indicadores", "natio-lang"); ?>
						</h1>
						<div class="row">
							<div class="content-numbers  col-xs-12 col-sm-12 col-md-12">
								<i class="icon-numbers icon-empresas-pre-incubadas"></i>
								<div class="content-text-reinc col-xs-8 col-sm-8 col-md-8">
									<span class="text-numbers-reinc"><?php echo __("Pré-incubadas", "natio-lang"); ?></span>
								</div>
								<div class="col-xs-2 col-sm-2 col-md-2">
									<span class="numbers"><?php echo getEmpresasStatus("pre-incubadas", get_the_ID()); ?></span>
								</div>
							</div>
							<div class="content-numbers col-xs-12 col-sm-12 col-md-12">
								<i class="icon-numbers icon-empresas-incubadas"></i>
								<div class="content-text-reinc col-xs-12 col-sm-8 col-md-8">
									<span class="text-numbers-reinc"><?php echo __("Incubadas", "natio-lang"); ?></span>
								</div>
								<div class="col-xs-12 col-sm-2 col-md-2">
									<span class="numbers"><?php echo getEmpresasStatus("incubadas", get_the_ID()); ?></span>
								</div>
							</div>
							<div class="content-numbers col-xs-12 col-sm-12 col-md-12">
								<i class="icon-numbers icon-empresas-graduadas"></i>
								<div class="content-text-reinc col-xs-8 col-sm-8 col-md-8">
									<span class="text-numbers-reinc"><?php echo __("Graduadas", "natio-lang"); ?></span>
								</div>
								<div class="col-xs-2 col-sm-2 col-md-2">
									<span class="numbers"><?php echo getEmpresasStatus("graduadas", get_the_ID()); ?></span>
								</div>
							</div>
							<div class="content-numbers col-xs-12 col-sm-12 col-md-12">
								<i class="icon-numbers icon-empresas-associadas"></i>
								<div class="content-text-reinc col-xs-8 col-sm-8 col-md-8">
									<span class="text-numbers-reinc"><?php echo __("Associadas", "natio-lang"); ?></span>
								</div>
								<div class="col-xs-2 col-sm-2 col-md-2">
									<span class="numbers"><?php echo getEmpresasStatus("associadas", get_the_ID()); ?></span>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="row">
					<?php if (get_field("incubadora_slideshow", $post->id)) : ?>
						<?php $incubadora_slideshow = get_field("incubadora_slideshow", $post->id); ?>
						<section id="galeria" class="gallery-container col-xs-12">
							<h1 class="pageTitleAssociated">
								<?php echo __("Galeria de Fotos", 'natio-lang'); ?>
							</h1>
							<ul class="row">
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
				</div>
				<section class="row filter-associados filter-associados-incubadoras">
					<div class="filters-container col-xs-12 hidden-print">
						<?php $wp_associados->the_menu_accordion_html('Empresas', 'empresa_status', get_the_ID(), 'col-xs-12 col-sm-6 col-md-4 col-lg-3'); ?>
					</div>
					<div class="the-content col-xs-12">
						<div id="associates_result" class="associates-list"></div>
						<div class="associate_loading">
							<button class="btn btn-lg" disabled><span class="fa fa-refresh fontawesome-refresh-animate"></span> <?php echo __("Carregando..."); ?></button>
						</div>
					</div>
				</section>
            </section>
		</div>
    </div>
	<?php endwhile; ?>
	<?php wp_enqueue_script( 'wp-api' ); ?>
<?php endif; ?>
<?php get_footer(); ?>
