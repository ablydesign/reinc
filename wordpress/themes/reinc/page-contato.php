<?php if (!function_exists('add_action')) exit;
/*
Template Name: Página Contato
*/
?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="container contact-page">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h1 class="title-default under-line">
                    <?php _e('Contato', 'natio-lang'); ?>
                </h1>
            </div>
            <section class="col-xs-12 col-sm-8 col-md-8 form-content">
                <h3 class="h3"><?php _e('Para falar com a ReINC, basta preencher os campos abaixo que <br/>
                    logo entraremos em contato.', 'natio-lang'); ?>
                </h3>
                <?php the_form_contact();?>
            </section>
            <section class="col-xs-12 col-sm-4 col-md-4 infor-content">
                <div class="info-contact">
                    <p><i class="fa fa-phone"></i> 21 2533-3353 | 21 2533-3626</p>
                    <p><i class="fa fa-envelope-o"></i> contato@reinc.com.br </p>
                    <p><i class="fa fa-home"></i> Av. Beira Mar, <br/>
                        Ed. São Miguel 406, <br/>
                        Sala 1108 – Centro <br/>
                        20021-060</p>
                </div>
            </section>
            <!-- /.col-xs-12 col-sm-4 col-md-4 info-contact -->
        </div>
    </div>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
