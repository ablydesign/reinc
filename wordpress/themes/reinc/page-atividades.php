<?php if (!function_exists('add_action')) exit;?>
<?php
/*
Template Name: Página Atividades
*/
?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="container">
        <div class="row">
            <section class="col-xs-12 col-sm-12 col-md-12 content-internal-pages">
                <h1 class="title-default under-line"><?php _e(get_the_title(get_the_ID()), "natio-lang" ); ?></h1>
                <div class="content">
                    <?php the_translate_content(); ?>
                    <?php $wp_atividades->the_menu_filter(53); ?>
                </div>
                <div class="tabs-container">
                    <div class="tabs-content">
                        <div class="list-atividades">
                            <ul>
                                <?php $segment_filter = $wp_atividades->get_agroup_content(53); ?>
                                <?php foreach ( $segment_filter as $inner_filter ) { ?>
                                    <li class="item <?php echo $inner_filter['slug_parent'] .' '. $inner_filter['slug']; ?>">
                                        <h3 class="header-<?php echo  $inner_filter['slug']; ?>"><?php echo $inner_filter['name'] ?></h3>
                                        <p class="accordion-content">
                                            <?php $query = new WP_Query( array('post_type' => 'custom_atividades', 'posts_per_page' => -1, 'tax_query' => array(array( 'taxonomy' => 'custom_atividades_segmentos', 'field' => 'slug', 'terms' =>  $inner_filter['slug'] ) ) ) ); ?>
                                            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            <?php endwhile; ?>
                                            <?php wp_reset_postdata(); ?>
                                        </p>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
