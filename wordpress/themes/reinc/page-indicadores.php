<?php
/**
 * Template Name: Página Indicadores
 */
?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="container indicadores-page">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h1 class="title-default under-line"><?php _e(get_the_title(get_the_ID()), 'natio-lang'); ?></h1>
                <p><?php _e('**Todas as informações tem como base as Empresas cadastradas e suas relações', 'natio-lang');?></p>
                <div class="content">
                    <?php
                        $design = WP_Incubadoras::get_count('design-economia-criativa');
                        $economia = WP_Incubadoras::get_count('economia-solidaria');
                        $base = WP_Incubadoras::get_count('base-tecnologica');
                    ?>
                    <div class="indicadores indicadores-incubadora">
                        <h2><?php _e('Incubadoras', 'natio-lang');?> - <?php _e('Empresas por status', 'natio-lang');?></h2>
                        <p><?php _e(sprintf('Número de Incubadoras por Area de Atuação: Base Tecnológica (%s), Design/Economia Criativa (%s) e Economia Solidária (%s)', $base, $design, $economia), 'natio-lang');?></p>
                        <div class="indicadores-accordion accordion-content accordion-incubadora-content">
                            <div class="table-responsive">
                                <?php $wp_indicadores->the_biuld_table('tipo_de_incubadora', 'status_da_empresa', 'incubadora', 'Tipos de Incubadoras', 'Status das Empresas'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="indicadores indicadores-incubadora">
                        <h2><?php _e('Incubadoras', 'natio-lang');?> - <?php _e('Empresas por área de atuação', 'natio-lang');?></h2>
                        <div class="indicadores-accordion accordion-content accordion-incubadora-content">
                            <div class="table-responsive" id="incubadora-tipo_empresa">
                                <?php $wp_indicadores->the_biuld_table('tipo_de_empresa', 'tipo_de_incubadora', null, 'Tipos de Empresas', 'Tipos de Incubadoras'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="indicadores indicadores-parques">
                        <h2><?php _e('Parques Tecnológicos', 'natio-lang');?></h2>
                        <div class="indicadores-accordion accordion-content accordion-parques-content">
                            <div class="table-responsive">
                                <?php $wp_indicadores->the_biuld_table('tipo_de_parque_tecnologico', 'status_da_empresa', 'parque', 'Tipos de Parques Tecnológicos', 'Status das Empresas'); ?>
                            </div>
                            <div class="table-responsive" id="parques-tipo_empresa">
                                <?php $wp_indicadores->the_biuld_table('tipo_de_parque_tecnologico', 'tipo_de_empresa', null, 'Tipos de Parques Tecnológicos', 'Tipos de Empresas'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="indicadores indicadores-programas">
                        <h2><?php _e('Programas de Aceleração', 'natio-lang');?></h2>
                        <div class="indicadores-accordion accordion-content accordion-programas-content">
                            <div class="table-responsive">
                                <?php $wp_indicadores->the_biuld_table('tipo_programas', 'status_da_empresa', 'programa', 'Tipos de Programas de Aceleração', 'Status das Empresas'); ?>
                            </div>
                            <div class="table-responsive" id="programa-tipo_empresa">
                                <?php $wp_indicadores->the_biuld_table('tipo_programas', 'tipo_de_empresa', null, 'Tipos de Programas de Aceleração', 'Tipos de Empresas'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <p><?php _e('Por incubadora, parque e programa de aceleração', 'natio-lang');?></p>
                    <div class="indicadores indicadores-incubadora">
                        <h2><?php _e('Incubadoras', 'natio-lang');?> - <?php _e('Empresas por incubadora', 'natio-lang');?></h2>
                        <div class="indicadores-accordion accordion-content accordion-incubadora-content">
                            <div class="table-responsive">
                                <?php $wp_indicadores->the_biuld_table('empresa_incubadora', 'status_da_empresa',  'incubadora', 'Incubadoras', 'Status das Empresas'); ?>
                            </div>
                            <div class="table-responsive" id="empresa_incubadora-tipo_empresa">
                                <?php $wp_indicadores->the_biuld_table('empresa_incubadora', 'tipo_de_empresa', null, 'Incubadoras', 'Tipos de Empresas'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="indicadores indicadores-parques">
                        <h2><?php _e('Parques Tecnológicos', 'natio-lang');?></h2>
                        <div class="indicadores-accordion accordion-content accordion-parques-content">
                            <div class="table-responsive">
                                <?php $wp_indicadores->the_biuld_table('empresa_parque', 'status_da_empresa',  'parque', 'Parques Tecnológicos', 'Status das Empresas'); ?>
                            </div>
                            <div class="table-responsive" id="empresa_parque-tipo_empresa">
                                <?php $wp_indicadores->the_biuld_table('empresa_parque', 'tipo_de_empresa', null, 'Parques Tecnológicos', 'Tipos de Empresas'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="indicadores indicadores-programas">
                        <h2><?php _e('Programas de Aceleração', 'natio-lang');?></h2>
                        <div class="indicadores-accordion accordion-content accordion-programas-content">
                            <div class="table-responsive">
                                <?php $wp_indicadores->the_biuld_table('empresa_programa', 'status_da_empresa',  'programa', 'Programas de Aceleração', 'Status das Empresas'); ?>
                            </div>
                            <div class="table-responsive" id="empresa_programa-tipo_empresa">
                                <?php $wp_indicadores->the_biuld_table('empresa_programa', 'tipo_de_empresa', 'Programas de Aceleração', 'Tipos de Empresas'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <p><?php _e('Por Localização', 'natio-lang');?></p>
                    <div class="indicadores indicadores-incubadora">
                        <h2><?php _e('Incubadoras', 'natio-lang');?> - <?php _e('Empresas por Região', 'natio-lang');?></h2>
                        <div class="indicadores-accordion accordion-content accordion-incubadora-content">
                            <div class="table-responsive">
                                <?php $wp_indicadores->the_biuld_table('localizacao_geografica', 'status_da_empresa', 'incubadora', 'Localização', 'Status das Empresas'); ?>
                            </div>
                            <div class="table-responsive" id="localizacao_incubadora-tipo_empresa">
                                <?php $wp_indicadores->the_biuld_table('localizacao_geografica', 'tipo_de_empresa', 'incubadora', 'Localização', 'Tipos de Empresas'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="indicadores indicadores-parques">
                        <h2><?php _e('Parques Tecnológicos', 'natio-lang');?></h2>
                        <div class="indicadores-accordion accordion-content accordion-parques-content">
                            <div class="table-responsive">
                                <?php $wp_indicadores->the_biuld_table('localizacao_geografica', 'status_da_empresa',  'parque', 'Localização', 'Status das Empresas'); ?>
                            </div>
                            <div class="table-responsive" id="localizacao_parque-tipo_empresa">
                                <?php $wp_indicadores->the_biuld_table('localizacao_geografica', 'tipo_de_empresa', 'parque', 'Localização', 'Tipos de Empresas'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="indicadores indicadores-programas">
                        <h2><?php _e('Programas de Aceleração', 'natio-lang');?></h2>
                        <div class="indicadores-accordion accordion-content accordion-programas-content">
                            <div class="table-responsive" id="">
                                <?php $wp_indicadores->the_biuld_table('localizacao_geografica', 'status_da_empresa',  'programa', 'Localização', 'Status das Empresas'); ?>
                            </div>
                            <div class="table-responsive" id="localizacao_programa-tipo_empresa">
                                <?php $wp_indicadores->the_biuld_table('localizacao_geografica', 'tipo_de_empresa', 'programa', 'Localização', 'Tipos de Empresas'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/datatables.min.js"></script>
    <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() ?>/assets/js/jquery.indicadores.js"></script>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
