<?php if (!function_exists('add_action')) exit;?>
<?php
/*
Template Name: Página Login */
?>
<?php get_header('login'); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="container">
        <div class="row">
            <section class="col-xs-12 section-page_login">
                <div class="container-form-login">
                    <h1><?php _e(get_the_title(), 'natio-lang' ); ?></h1>
                    <div class="custom-content-login">
                        <?php the_content(); ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
<?php endwhile; endif; ?>

<?php get_footer('login'); ?>
