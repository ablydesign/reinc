<?php if (!function_exists('add_action')) exit;
/*
Template Name: Página Galeria
*/
?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="container">
        <div class="row">
            <section class="col-xs-12 col-sm-6 col-md-7 content-internal-pages">
                <h1><?php the_title()?></h1>
                <?php the_content(); ?>
                <small class="obs">CLIQUE NA IMAGEM PARA AMPLIÁ-LA</small>
                <!-- /.obs -->
                <div class="grid">
                    <?php
                    if( have_rows('galeria') ):
                        while ( have_rows('galeria') ) : the_row();
                            $image = get_sub_field('imagem_galeria');
                            ?>
                            <div class="grid-item  grid-<?php the_sub_field('largura_imagem'); ?>">
                                <a href="<?php echo $image['sizes']['imagem-lightbox']; ?>" data-lightbox="roadtrip">
                                    <img class="img-responsive" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"/>
                                </a>
                            </div>
                        <?php
                        endwhile;
                    endif;

                    ?>
                </div>
            </section>
            <!-- /.class="col-xs-12 col-sm-6 col-md-7 content-internal-pages" -->
        </div>
    </div>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
