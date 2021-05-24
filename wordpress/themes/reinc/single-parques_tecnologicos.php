<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="container">
        <div class="row">
            <section class="col-xs-12 col-sm-12 col-md-12 page-incubadoras">
                <h1 class="pageTitleAssociated">
                    <?php echo __("Parque Tecnológico", "natio-lang"); ?>
                </h1>
				<div class="row containerVoltar">
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
									<?php the_translate_field('parque_tecnologico_descricao', $post->ID); ?>
									<?php //$incubadoraDescription = get_post_custom_values("parque_tecnologico_descricao", $post->ID); echo wpautop($incubadoraDescription[0]); ?>
								</div>
							</li>
						</ul>
					</div>
					<div class="col-xs-5 col-sm-5 col-md-5 pull-right">
						<ul class="lateral-info">
							<?php
							$logotipo_associado = get_field("parque_tecnologico_logotipo", $post->id);
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

								$contatos_associado = get_field("parque_tecnologico_contatos", $post->id);
								$telefone_associado = get_field("parque_tecnologico_telefone", $post->id);
								$email_associado = get_field("parque_tecnologico_email", $post->id);
								$endereco_associado = get_field("parque_tecnologico_endereco", $post->id);
								$site_associado = get_field("parque_tecnologico_site", $post->id);

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
									$site_associado = "<a href=\"{$site_associado}\" class=\"acesseAssociado\">".__("Acesse o associado", "natio-lang")."</a>";
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
							<?php echo __("Indicadores", "natio-lang"); ?>
						</h1>
						<div class="row">
							<div class="content-numbers col-xs-12 col-sm-12 col-md-12">
								<i class="icon-numbers icon-empresas-associadas"></i>
								<div class="content-text-reinc col-xs-8 col-sm-8 col-md-8">
									<span class="text-numbers-reinc"><?php echo __("Instaladas", "natio-lang"); ?></span>
								</div>
								<div class="col-xs-2 col-sm-2 col-md-2">
									<span class="numbers"><?php echo $wp_parques->get_count_empresas_by_id(get_the_ID()); ?></span>
								</div>
							</div>
						</div>

					</div>
				</div>
			</section>
			<section class="row filter-associados" id="empresas_parques" data-parque-id="<?php the_ID(); ?>">
				<div class="filters-container col-xs-12">
					<h3 class="accordion-title"><?php _e('Empresas', 'natio-lang')?><i class="fa-accordion-icon fa"></i></h3>
				</div>
				<div class="the-content col-xs-12">
					<div id="associates_result" class="associates-list"></div>
					<div class="associate_loading">
						<button class="btn btn-lg" disabled><span class="fa fa-refresh fontawesome-refresh-animate"></span> <?php echo __("Carregando..."); ?></button>
					</div>
				</div>
			</section>

        </div>
    </div>
<?php endwhile; ?>

<?php
	wp_enqueue_script( 'wp-api' );
?>

<?php endif; ?>

<?php get_footer(); ?>
