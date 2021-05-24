<?php if (!function_exists('add_action')) exit;
/*
Template Name: Página Serviços
*/
?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="container">
        <div class="row">
            <section class="col-xs-12 col-sm-12 col-md-12 page-about">
                <h1 class="title-default under-line">
                    <?php _e('Serviços da REINC', 'natio-lang'); ?>
                </h1>
                <div class="the-content">
                    <?php the_translate_content(); ?>
                </div>
            </section>
        </div>
        <div class="row">
            <!-- /.content-numbers -->
                <?php
                $current = 1;
                $controle = get_number_row('objetivos_reinc');
                $num = (int)two_columns($controle);
                $field_name = get_translate_field('objetivos_reinc');
                if( have_rows($field_name) ): ?>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h1 class="title-default">
                            <?php _e('Os Serviços da ReINC', 'natio-lang'); ?>
                        </h1>
                    </div>
                    <ul class="list-default-site the-content col-xs-12 col-sm-12 col-md-6">
                    <?php while ( have_rows($field_name) ) : the_row(); ?>
                        <li><?php the_translate_sub_field('objetivo_reinc', get_the_ID() ); ?></li>
                        <?php if ($current == $num) : ?>
                            <?php echo ' </ul>'; ?>
                            <?php echo '<ul class="list-default-site the-content col-xs-12 col-sm-12 col-md-6">'; ?>
                        <?php endif; ?>
                        <?php ++$current; ?>
                    <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
        </div>
    </div>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
