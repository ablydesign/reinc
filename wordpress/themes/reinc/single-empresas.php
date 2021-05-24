<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="container">
        <div class="row">
            <section class="col-xs-12 col-sm-12 col-md-12 page-incubadoras">
                <h1 class="pageTitleAssociatedEmpresa">
                    <?php echo __("Empresa", "natio-lang"); ?>
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
							<li class="row first-line">
								<div class="field_title col-xs-3 col-sm-3 col-md-3">
									<?php echo __("Área de atuação", "natio-lang"); ?>:
								</div>
								<div class="field_content col-xs-9 col-sm-9 col-md-9">
									<?php
										$tipoDeEmpresaArray1 = (get_post_custom_values("tipo_de_empresa", $post->ID));
										$tipoDeEmpresaArray = maybe_unserialize($tipoDeEmpresaArray1[0]);
										if (is_array($tipoDeEmpresaArray)) {
											foreach($tipoDeEmpresaArray AS $tipoDeEmpresa){
												$getTerm = get_term($tipoDeEmpresa, "tipo_empresas");
												echo sprintf("%s<br />",($getTerm->name));
											}
										} else {
											$getTerm = get_term($tipoDeEmpresaArray, "tipo_empresas");
											echo sprintf("%s<br />",($getTerm->name));
										}
									?>
								</div>
							</li>
							<li class="row first-line">
								<div class="field_title col-xs-3 col-sm-3 col-md-3">
									<?php echo __("Descrição", "natio-lang"); ?>:
								</div>
								<div class="field_content col-xs-9 col-sm-9 col-md-9 internDescription">
									<?php the_translate_field('empresa_descricao', $post->ID); ?>
									<?php //$incubadoraDescription = get_post_custom_values("empresa_descricao", $post->ID); echo wpautop($incubadoraDescription[0]); ?>
								</div>
							</li>
							<li class="row">
								<div class="field_title col-xs-3 col-sm-3 col-md-3">
									<?php
										echo __("Status:", "natio-lang");
									?>
								</div>
								<div class="field_content col-xs-9 col-sm-9 col-md-9">
									<?php
										$StatusEmpresa = get_field("status_da_empresa");
										echo $StatusEmpresa->name;
									?>
								</div>
							</li>
							<?php

							$incubadoraEmpresaObj = get_field("empresa_incubadora", $post->ID);
							$parquetecnEmpresaObj = get_field("empresa_parque", $post->ID);

							?>
							<li class="row">
								<div class="field_title col-xs-3 col-sm-3 col-md-3">
									<?php
										if($incubadoraEmpresaObj AND !$parquetecnEmpresaObj){
											echo __("Incubadora", "natio-lang") . ":";
										}elseif(!$incubadoraEmpresaObj AND $parquetecnEmpresaObj){
											echo __("Parque Tecnol&oacute;gico", "natio-lang");
										}else{
											echo __("Incubadora", "natio-lang") . ":";
										}
									?>
								</div>
								<div class="field_content col-xs-9 col-sm-9 col-md-9">
									<?php
										if($incubadoraEmpresaObj AND !$parquetecnEmpresaObj){
											echo sprintf("<a href=\"%s\">%s</a><br />",get_permalink($incubadoraEmpresaObj[0]), get_the_title($incubadoraEmpresaObj[0]));
										}elseif(!$incubadoraEmpresaObj AND $parquetecnEmpresaObj){
											echo sprintf("<a href=\"%s\">%s</a><br />",get_permalink($parquetecnEmpresaObj[0]), get_the_title($parquetecnEmpresaObj[0]));
										}
									?>
								</div>
							</li>

						</ul>
					</div>
					<div class="col-xs-5 col-sm-5 col-md-5 pull-right">
						<ul class="lateral-info">
							<?php
							$logotipo_associado = get_field("empresa_logotipo", $post->id);
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
								$contatos_associado = get_field("empresa_contatos", $post->id);
								$telefone_associado = get_field("empresa_telefone", $post->id);
								$email_associado = get_field("empresa_email", $post->id);
								$endereco_associado = get_field("empresa_endereco", $post->id);
								$site_associado = get_field("empresa_site", $post->id);

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
									$site_associado = "<a target=\"_blank\" href=\"http://{$site_associado}\" class=\"acesseAssociado\">".__("Acesse o associado", "natio-lang")."</a>";
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
					</div>
				</div>
            </section>

		</div>
		<div class="row">
			<?php if (get_field("empresa_slideshow", $post->id)) : ?>
				<?php $empresa_slideshow = get_field("empresa_slideshow", $post->id); ?>
				<section id="galeria" class="gallery-container">
					<h1 class="indicadoresAssociado col-xs-12">
						<?php echo __("Galeria de Fotos", 'natio-lang'); ?>
					</h1>
					<ul>
						<?php foreach($empresa_slideshow AS $individualPhoto){ ?>
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
    </div>
<?php endwhile; ?>

<?php endif; ?>

<?php get_footer(); ?>
