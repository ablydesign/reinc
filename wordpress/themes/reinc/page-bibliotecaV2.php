<?php if (!function_exists('add_action')) exit;?>
<?php
/*
Template Name: Página Biblioteca V2
*/
?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="container">
        <div class="row">
            <section class="col-xs-12 col-sm-12 col-md-12 content-internal-pages">
                <h1 class="title-default under-line"><?php _e(get_the_title(get_the_ID()), 'natio-lang'); ?></h1>
                <div class="content">
                    <?php the_translate_content(); ?>
                </div>
                <div class="filter-content">
                    <a href="#documentos" class="filter-documentos">
                        <i class="icon"></i>
                        <span><?php _e('Documentos', 'natio-lang'); ?></span>
                    </a>
                    <a href="#artigos-e-publicacoes" class="filter-artigos">
                        <i class="icon"></i>
                        <span><?php _e('Artigos e Publicações', 'natio-lang'); ?></span>
                    </a>
                    <a href="#cerne" class="filter-cerne">
                        <i class="icon"></i>
                        <span><?php _e('Cerne', 'natio-lang'); ?></span>
                    </a>
                </div>
                <div class="tabs-container">
                    <div class="tabs-content">
                        <div class="inner_documentos inner-content" data-content="documentos">
                            <?php WP_Biblioteca::the_menu_accordion_html(array(34, 36, 54)); ?>
                        </div>
                        <div class="inner_artigos inner-content" data-content="artigos-e-publicacoes">
                            <?php WP_Biblioteca::the_menu_accordion_html(array(35, 36, 54)); ?>
                        </div>
                        <div class="inner_cerne inner-content" data-content="cerne">
                            <?php WP_Biblioteca::the_menu_accordion_html(array(35, 34, 54)); ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
