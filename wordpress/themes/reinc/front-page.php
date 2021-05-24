<?php if (!function_exists('add_action')) exit;?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="container">
        <div class="row">
            <section class="map col-xs-12">
                <div class="mapa-title">
                    <h2><?php _e('Passe o mouse sobre o mapa <br>e <strong>veja os nossos associados</strong>', 'natio-lang'); ?></h2>
                </div>
               <?php echo do_shortcode('[mapa]');?>
            </section>
            <!-- /.map -->
        </div>
        <div class="row">
            <div class="negative-margin">
                <section class="next-events col-xs-12 col-sm-6 col-md-6">
                    <h1 class="title-default">
                        <?php echo __('Destaques', 'natio-lang'); ?>
                    </h1>
                    <?php $destaques = new WP_Query( array(
                            'post_type' => array('custom_biblioteca', 'custom_atividades'),
                            'posts_per_page' => 5,
                            'tax_query' => array(
                                'relation' => 'OR',
                                array( 'taxonomy' => 'custom_atividades_segmentos', 'field'  => 'slug', 'terms' => 'exibir-home'),
                                array( 'taxonomy' => 'custom_biblioteca_segmentos', 'field'  => 'slug', 'terms' => 'exibir-home' )
                            )
                        )); ?>
                    <div id="accordion" class="accordion">
                        <?php if ( $destaques->have_posts() ) : ?>
                            <?php while ( $destaques->have_posts() ) : $destaques->the_post(); ?>
                                    <h3 class="h3 color-five"><?php the_title(); ?> <i class="fa fa-plus-circle"></i></h3>
                                    <div>
                                        <p>
                                            <?php echo wp_trim_words(get_field('resumo')); ?>
                                            <?php if (get_field('link_externo')) : ?>
                                                <a class="link-more" target="_blank" href="<?php the_field('link_externo'); ?>" title="Mais informações sobre <?php the_title(); ?>"><?php _e('Mais informações', 'natio-lang'); ?></a>
                                            <?php else :?>
                                                <a class="link-more" href="<?php the_permalink(); ?>" title="Mais informações sobre <?php the_title(); ?>"><?php _e('Mais informações', 'natio-lang'); ?></a>
                                            <?php endif; ?>
                                        </p>
                                        <!-- /.link-more -->
                                    </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php wp_reset_postdata(); ?>
                    </div>
                </section>
                <!-- /.next-events -->
                <section class="numbers-reinc col-xs-12 col-sm-6 col-md-6">
                    <h1 class="title-default">
                        <?php _e('Indicadores ReINC', 'natio-lang'); ?>
                        <?php
                            $incubadorasObj = wp_count_posts("incubadoras");
                            $totalIncubadoras = !empty($incubadorasObj->publish)?$incubadorasObj->publish:0;

                            $parquesObj = wp_count_posts("parques_tecnologicos");
                            $totalParques = !empty($parquesObj->publish)?$parquesObj->publish:0;

                            $empresasIncubadasObj = countEmpresasByStatus("incubadas");
                            $totalEmpresasIncubadas = !empty($empresasIncubadasObj)?$empresasIncubadasObj:0;

                            $totalEmpresasGraduadasObj =  countEmpresasByStatus("graduadas");
                            $totalEmpresasGraduadas = !empty($totalEmpresasGraduadasObj)?$totalEmpresasGraduadasObj:0;
                        ?>
                    </h1>
                    <?php global $associados_infor; ?>
                	<div class="content-numbers content-numbers--incubadoras">
                        <div class="row">
                            <div class="no-padding col-xs-2">
            				    <i class="icon-numbers icon-incubadoras"></i>
                            </div>
            				<div class="content-text-reinc col-xs-8">
            					<span class="text-numbers-reinc"><?php echo __("Incubadoras", "natio-lang"); ?></span>
            				</div>
            				<div class="number col-xs-2">
            					<span class="numbers"><?php echo $totalIncubadoras; ?></span>
                            </div>
            			</div>
            		</div>
                    <div class="content-numbers">
                        <div class="row">
                            <div class="no-padding col-xs-2">
            				    <i class="icon-numbers icon-parques-tecnologicos"></i>
                            </div>
            				<div class="content-text-reinc col-xs-8">
            					<span class="text-numbers-reinc"><?php echo __("Parques<br />Tecnol&oacute;gicos", 'natio-lang'); ?></span>
            				</div>
            				<div class="number col-xs-2">
            					<span class="numbers"><?php echo $totalParques; ?></span>
            				</div>
            			</div>
                    </div>
            		<div class="content-numbers">
                        <div class="row">
                            <div class="no-padding col-xs-2">
                        	   <i class="icon-numbers icon-empresas-incubadas"></i>
                            </div>
            				<div class="content-text-reinc col-xs-8">
            					<span class="text-numbers-reinc"><?php echo __("Programas de<br>Aceleração", 'natio-lang'); ?></span>
            				</div>
            				<div class="number col-xs-2">
            					<span class="numbers"><?php echo $associados_infor['programas']['count'] ?></span>
            				</div>
            			</div>
                    </div>
                </section>
            </div>
            <section class="associados col-xs-12 col-sm-12 col-md-12">
                <h1 class="title-default under-line">
                    <?php echo __("Associados", 'natio-lang'); ?>
                </h1>
                <?php $carousel_associados = new WP_Query(array('post_type' => array('parques_tecnologicos', 'incubadoras'), 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC')); ?>
                <?php if( $carousel_associados->have_posts()) : ?>
                <div class="owl-carousel carousel-associados">
                        <?php while (  $carousel_associados->have_posts() ) : $carousel_associados->the_post(); ?>
                            <div class="item">
                                <a class="link" href="<?php the_permalink(); ?>">
                                    <div class="hover-img">
                                        <?php
                                            if (get_post_type() === 'incubadoras') {
                                                $image = get_field("incubadora_logotipo", get_the_ID());
                                            } else if (get_post_type() === 'parques_tecnologicos') {
                                                $image = get_field("parque_tecnologico_logotipo", get_the_ID());
                                            }
                                        ?>
                                        <img src="<?php echo ($image['sizes']['thumbnail']) ? ($image['sizes']['thumbnail']) : (get_bloginfo('template_url') . '/assets/img/thumb-default-150.png'); ?>" alt="<?php the_title(); ?>">
                                    </div>
                                    <h3 class="h3"><?php the_title(); ?></h3>
                                </a>
                            </div>
                        <?php
                        endwhile;
                    endif;
                    wp_reset_postdata();
                    ?>
                </div>
            </section>
            <section class="associados col-xs-12 col-sm-12 col-md-12">
                <h1 class="title-default under-line">
                    <?php _e('Apoio', 'natio-lang'); ?>
                </h1>
                <ul class="all-apoio owl-carousel" key="<?php echo get_the_ID();?>">
                    <?php if( have_rows('apoio_home') ): ?>
                        <?php while ( have_rows('apoio_home') ) : the_row(); ?>
                            <li class="icons-apoio">
                                <a href="<?php the_sub_field('link_para_o_site');?>" target="_blank">
                                    <img src="<?php the_sub_field('logo_default'); ?>" alt="apoio_home">
                                </a>
                            </li>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </ul>
            </section>
            <!-- /.associados -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
<?php endwhile; endif; ?>
<?php get_footer(); ?>
