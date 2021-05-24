<?php get_header(); ?>
    <?php global $wp_query; ?>
    <div class="container" id="tags-page">
        <div class="row">
            <section class="col-xs-12 content-internal-pages">
                <?php if (have_posts()) : ?>
                    <div class="loop-container post-loop search-loop">
                        <h2><?php _e('Todas as publicações maracadas com a tag', 'natio-lang'); ?><strong><?php the_title(); ?></strong></h2>
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="post-loop_item search-loop_item">
                             <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Ver <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                             <p><span><b><?php _e('Publicado em ');?></b><?php the_date(); ?></span> / <span> <?php _e( 'Tipo', 'natio-lang'); ?> <?php the_post_type_name(get_the_ID());?> </span></p>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <h2><?php echo (sprintf(__('Desculpe, nenhum resultado encontrado para: <b>%1$s</b>', 'natio-lang'), get_search_query()) );?></h2>
                <?php endif; ?>
            </section>
        </div>
    </div>
<?php get_footer(); ?>
