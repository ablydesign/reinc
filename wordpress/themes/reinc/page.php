<?php if (!function_exists('add_action')) exit;?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="container">
        <div class="row">
            <section class="col-xs-12 col-sm-6 col-md-7 content-internal-pages">
                <h1 class="title-default"><?php _e(get_the_title(get_the_ID()), "natio-lang" ); ?></h1>
                <?php the_content(); ?>
        </div>
    </div>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
