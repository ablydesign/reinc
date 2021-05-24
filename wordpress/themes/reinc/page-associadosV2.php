<?php
/*
Template Name: Página Associados V2
*/
?>
<?php get_header(); ?>
<?php global $associados_infor; ?>
<?php /*if (have_posts()) : while (have_posts()) : the_post();*/ ?>
    <div class="container">
        <div class="row">
            <section class="col-xs-12 col-sm-12 col-md-12 page-associados">
                <h1 class="title-default">
					<?php echo __("Associados", 'natio-lang'); ?>
                </h1>
                <div class="the-content">
                    <?php
                        $text = __("A ReINC conta com %s incubadoras associadas, %s parques tecnológicos, com mais de %s empreendimentos incubados e %s graduados ou associados. Conheça os participantes da ReINC:", "natio-lang");
                        $incubadoras_count = wp_count_posts("incubadoras");
                        $total_01 = (empty($associados_infor['incubadoras']['count']))?$incubadoras_count->publish: $associados_infor['incubadoras']['count'];
                        $total_02 = $associados_infor['parques_tecnologicos']['count'] ;
                        $total_03 = $associados_infor['empresas']['incubadas']['count'];
                        $total_04 = $associados_infor['empresas']['graduadas']['count'] + $associados_infor['empresas']['associadas']['count'];
                    ?>

                    <p><?php echo sprintf($text, $total_01, $total_02, $total_03, $total_04); ?></p>
					<div class="inline-menu-associates accordion-container">
                        <?php $wp_associados->the_menu_accordion_html('Incubadoras de Empresas', 'tipo_incubadora', 'Incubadoras', 'col-xs-12 col-sm-6 col-md-4 col-lg-3'); ?>
                        <?php $wp_associados->the_menu_accordion_html('Parques Tecnológicos', 'tipo_parques', 'Parques', 'col-xs-12 col-sm-6 col-md-4 col-lg-3'); ?>
                        <?php $wp_associados->the_menu_accordion_html('Programas de Aceleração', 'tipo_programas', 'Programas', 'col-xs-12 col-sm-6 col-md-4 col-lg-3'); ?>
                        <?php $wp_associados->the_menu_accordion_html('Empresas', 'tipo_empresas', 'Empresas', 'col-xs-12 col-sm-6 col-md-4 col-lg-3'); ?>
					</div>
                </div>
                <!-- /.the-content -->
            </section>
			<section class="col-xs-12 col-sm-12 col-md-12">
                    <div class="type-menu">
                        <div class="filter-empresas">
                            <div class="menu-tipo">
                                <div class="checkbox-container">
                                    <span>Relacionada:</span>
                                    <label>
                                        <i class="check"></i>
                                        <input type="radio" name="type" value="incubadoras" />
                                        Incubadara
                                    </label>
                                    <label>
                                        <i class="check"></i>
                                        <input type="radio" name="type" value="parques_tecnologicos" />
                                        Parques Tecnológicos
                                    </label>
                                </div>
                            </div>
                            <div class="menu-tipo-child menu-tipo-incubadoras">
                                <?php $wp_associados->the_filter_html('incubadoras', 'tipo_incubadora', 'Escolha uma Incubadora'); ?>
                            </div>
                            <div class="menu-tipo-child menu-tipo-parques_tecnologicos">
                                <?php $wp_associados->the_filter_html('parques_tecnologicos', 'tipo_parques', 'Escolha um Parque'); ?>
                            </div>
                        </div>
                        <div class="buttons">
                            <button type="button" name="imagem"><span><?php _e('Visualizar por imagem', 'natio-lang'); ?></span> <i class="dashicons dashicons-screenoptions"></i></button>
                            <button type="button" name="mapa"><span><?php _e('Visualizar no Mapa', 'natio-lang'); ?></span> <i class="dashicons dashicons-location-alt"></i></button>
                        </div>
                    </div>

                <div id="associates_result_stage" class="associates-list"></div>
				<div class="associate_loading">
					<button class="btn btn-lg" disabled><span class="fa fa-refresh fontawesome-refresh-animate"></span> <?php echo __("Carregando..."); ?></button>
				</div>
				<div id="associate_results" class="row-fluid"></div>
				<div id="associate_pagination" class="row-fluid clearitems">
                </div>
			</section>
        </div>
    </div>
    <div class="container-fluid" id="mapa-container">
        <div class="associate_loading">
            <button class="btn btn-lg" disabled><span class="fa fa-refresh fontawesome-refresh-animate"></span> <?php echo __("Carregando..."); ?></button>
        </div>
        <div class="row">
            <div id="mapa-associados" style="height: 650px;"></div>
        </div>
    </div>
<?php /*endwhile; endif;*/ ?>

<?php
	wp_enqueue_script( 'wp-api' );

	//add_filter('wp_footer', 'reincCustomFooterAssociadosCode');

?>
<?php get_footer(); ?>
