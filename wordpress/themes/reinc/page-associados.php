<?php
/*
Template Name: Página Associados
*/
?>
<?php get_header(); ?>
<?php /*if (have_posts()) : while (have_posts()) : the_post();*/ ?>
    <div class="container">
        <div class="row">
            <section class="col-xs-12 col-sm-12 col-md-12 page-associados">
                <h1 class="title-default">
					<?php echo __("Associados"); ?>
                    <div class="type-menu">
                        <div class="buttons">
                            <button type="button" name="imagem"><span>Visualizar por imagem</span> <i class="dashicons dashicons-screenoptions"></i></button>
                            <button type="button" name="mapa"><span>Visualizar no Mapa</span> <i class="dashicons dashicons-location-alt"></i></button>
                        </div>
                    </div>
                </h1>
                <div class="the-content">
                    <p><?php
						$incubadorasObj = wp_count_posts("incubadoras");
						$totalIncubadoras = !empty($incubadorasObj->publish)?$incubadorasObj->publish:0;

						$parquesObj = wp_count_posts("parques_tecnologicos");
						$totalParques = !empty($parquesObj->publish)?$parquesObj->publish:0;

						$empresasIncubadasObj = countEmpresasByStatus("incubadas");
						$totalEmpresasIncubadas = !empty($empresasIncubadasObj)?$empresasIncubadasObj:0;

						$totalEmpresasGraduadasObj =  countEmpresasByStatus("graduadas");
						$totalEmpresasGraduadas = !empty($totalEmpresasGraduadasObj)?$totalEmpresasGraduadasObj:0;

						$totalEmpresasAssociadasObj =  countEmpresasByStatus("associadas");
						$totalEmpresasAssociadas = !empty($totalEmpresasAssociadasObj)?$totalEmpresasAssociadasObj:0;

					echo sprintf(__("A ReINC conta com %s incubadoras associadas, com mais de %s empreendimentos incubados e %s graduados ou associados. Conheça os participantes da ReINC:"), ($totalIncubadoras+$totalParques), $totalEmpresasIncubadas, ($totalEmpresasGraduadas+$totalEmpresasAssociadas)); ?></p>
					<ul class="inline-menu-associates">
						<li id="incubadoraChooseOptions" class="associate_type">
							<div class="pull-right retractileIcon">
								<i class="fa fa-minus-circle"></i>
							</div>
							<div class="associate_type_title" data-toggle="collapse" data-target="#incubadora_subitens" aria-expanded="true">
								<?php echo __("Incubadoras de Empresas"); ?>
							</div>
							<ul id="incubadora_subitens" class="subitens row collapse in" aria-expanded="true">
								<?php
									$buildAssociatesMenuForIncubadoras = buildAssociatesMenu("tipo_incubadora", array('hide_empty' => false));
									foreach($buildAssociatesMenuForIncubadoras AS $associatedIncubadoraInfo){
										if(empty($associatedIncubadoraInfo)) continue;
										echo sprintf("<li class=\"col-xs-3 col-sm-3 col-md-3\"><div class=\"hover-efect\"><a href=\"#\" data-associate_type=\"Incubadoras\" data-associate_category=\"%3\$s\" class=\"requestAssociate\">%4\$s</a></div></li>",$associatedIncubadoraInfo['link'], $associatedIncubadoraInfo['term_id'], $associatedIncubadoraInfo['slug'], mb_strtoupper($associatedIncubadoraInfo['name'], 'UTF-8'));
									}
								?>
							</ul>
						</li>
						<li id="parqueChooseOptions" class="associate_type">
							<div class="pull-right retractileIcon">
								<i class="fa fa-minus-circle"></i>
							</div>
							<div class="associate_type_title" data-toggle="collapse" data-target="#parque_subitens" aria-expanded="true">
								<?php echo __("Parques Tecnol&oacute;gicos"); ?>
							</div>
							<ul id="parque_subitens" class="subitens row collapse in" aria-expanded="true">
								<?php
									$buildAssociatesMenuForParques = buildAssociatesMenu("tipo_parques", array('hide_empty' => false));
									foreach($buildAssociatesMenuForParques AS $associatedParqueInfo){
										echo sprintf("<li class=\"col-xs-3 col-sm-3 col-md-3\"><div class=\"hover-efect\"><a href=\"%1\$s\" data-associate_type=\"Parques\" data-associate_category=\"%3\$s\" class=\"requestAssociate\">%4\$s</a></div></li>",$associatedParqueInfo['link'], $associatedParqueInfo['term_id'], $associatedParqueInfo['slug'], mb_strtoupper($associatedParqueInfo['name'], 'UTF-8'));
									}
								?>
							</ul>
						</li>
						<li id="empresaChooseOptions" class="associate_type">
							<div class="pull-right retractileIcon">
								<i class="fa fa-minus-circle"></i>
							</div>
							<div class="associate_type_title" data-toggle="collapse" data-target="#empresa_subitens"  aria-expanded="true">
								<?php echo __("Empresas"); ?>
							</div>
							<ul id="empresa_subitens" class="subitens row collapse in"  aria-expanded="true">
								<?php
									$buildAssociatesMenuForEmpresas = buildAssociatesMenu("tipo_empresas", array('hide_empty' => false));
									foreach($buildAssociatesMenuForEmpresas AS $associatedEmpresaInfo){
										echo sprintf("<li class=\"col-xs-3 col-sm-3 col-md-3\"><div class=\"hover-efect\"><a href=\"%1\$s\" data-associate_type=\"Empresas\" data-associate_category=\"%3\$s\" class=\"requestAssociate\">%4\$s</a></div></li>",$associatedEmpresaInfo['link'], $associatedEmpresaInfo['term_id'], $associatedEmpresaInfo['slug'], mb_strtoupper($associatedEmpresaInfo['name'], 'UTF-8'));
									}
								?>
							</ul>
						</li>
					</ul>
                </div>
                <!-- /.the-content -->
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
    </div>
    <div class="container-fluid" id="mapa-container">
        <div class="row">
            <div id="mapa-associados" style="height: 650px;"></div>
        </div>
    </div>
<?php /*endwhile; endif;*/ ?>

<?php
	wp_enqueue_script( 'wp-api' );

	add_filter('wp_footer', 'reincCustomFooterAssociadosCode');

?>
<?php get_footer(); ?>
