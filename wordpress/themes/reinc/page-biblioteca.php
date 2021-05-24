<?php if (!function_exists('add_action')) exit;?>
<?php
/*
Template Name: Página Biblioteca
*/
?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="container">
        <div class="row">
            <section class="col-xs-12 col-sm-12 col-md-12 content-internal-pages">
                <h1 class="title-default under-line"><?php the_title(); ?></h1>
                <div class="content">
                    <?php the_content(); ?>
                </div>
                <div class="filter-content">
                    <a href="#documentos" class="filter-documentos">
                        <i class="icon"></i>
                        <span>Documentos</span>
                    </a>
                    <a href="#artigos-e-publicacoes" class="filter-artigos">
                        <i class="icon"></i>
                        <span>Artigos e Publicações</span>
                    </a>
                    <a href="#cerne" class="filter-cerne">
                        <i class="icon"></i>
                        <span>Cerne</span>
                    </a>
                </div>
                <div class="tabs-container">
                    <div class="tabs-content">
                        <?php $documentos = get_terms('custom_biblioteca_segmentos', array('exclude_tree' => array(34, 36, 54), 'childless' => true)); ?>
                        <div class="inner_documentos inner-content" data-content="documentos">
                            <?php foreach ( $documentos as $inner_documentos ) { ?>
                                <div class="documentos-content">
                                    <h3 class="collapsed header-<?php echo $inner_documentos->slug; ?>" data-target="#target_<?php echo $inner_documentos->slug; ?>" data-toggle="collapse" aria-expanded="false"><?php echo $inner_documentos->name; ?></h3>
                                    <div class="collapse accordion-content" id="target_<?php echo $inner_documentos->slug; ?>"  aria-expanded="false" >
                                        <?php $query = null; ?>
                                        <?php $query = new WP_Query( array('post_type' => 'custom_biblioteca', 'posts_per_page' => -1, 'tax_query' => array(array( 'taxonomy' => 'custom_biblioteca_segmentos', 'field' => 'slug', 'terms' => $inner_documentos->slug ) ) ) ); ?>
                                        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        <?php endwhile; ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <?php $artigos = get_terms('custom_biblioteca_segmentos', array('exclude_tree' => array(35, 36, 54), 'childless' => true)); ?>
                        <div class="inner_artigos inner-content" data-content="artigos-e-publicacoes">
                            <?php foreach ( $artigos as $inner_artigos ) { ?>
                                <div class="artigos-content">
                                    <h3 class="collapsed header-<?php echo $inner_artigos->slug; ?>" data-target="#target_<?php echo $inner_documentos->slug; ?>" data-toggle="collapse" aria-expanded="false"><?php echo $inner_artigos->name; ?></h3>
                                    <div class="collapse accordion-content" id="target_<?php echo $inner_documentos->slug; ?>" aria-expanded="false">
                                        <?php $query = null; ?>
                                        <?php $query = new WP_Query( array('post_type' => 'custom_biblioteca', 'posts_per_page' => -1, 'tax_query' => array(array( 'taxonomy' => 'custom_biblioteca_segmentos', 'field' => 'slug', 'terms' => $inner_artigos->slug ) ) ) ); ?>
                                        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        <?php endwhile; ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <?php $cerne = get_terms('custom_biblioteca_segmentos', array('exclude_tree' => array(34, 35, 54), 'childless' => true)); ?>
                        <div class="inner_cerne inner-content" data-content="cerne">
                            <?php foreach ( $cerne as $inner_cerne ) { ?>
                                <div class="cerne-content">
                                    <h3 class="collapsed header-<?php echo $inner_cerne->slug; ?>" data-target="#target_<?php echo $inner_cerne->slug; ?>" data-toggle="collapse" aria-expanded="false"><?php echo $inner_cerne->name; ?></h3>
                                    <div class="collapse accordion-content" id="target_<?php echo $inner_cerne->slug; ?>" aria-expanded="false">
                                        <?php $query = null; ?>
                                        <?php $query = new WP_Query( array('post_type' => 'custom_biblioteca', 'posts_per_page' => -1, 'tax_query' => array(array( 'taxonomy' => 'custom_biblioteca_segmentos', 'field' => 'slug', 'terms' => $inner_cerne->slug ) ) ) ); ?>
                                        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        <?php endwhile; ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
