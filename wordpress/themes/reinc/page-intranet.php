<?php
/*
Template Name: Página intranet */
?>
<?php get_header('intranet'); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div id="page-intranet" class="container">
        <div class="row">
            <section class="section-page_intranet">
                <div class="title-container col-xs-12">
                    <h1><?php _e(get_the_title(), 'natio-lang' ); ?></h1>
                </div>
                <div class="the-content">
                    <?php the_content(); ?>
                </div>
            </section>
        </div>
    </div>
<?php endwhile; endif; ?>
<?php get_footer('intranet'); ?>
