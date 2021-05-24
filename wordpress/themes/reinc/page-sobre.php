<?php if (!function_exists('add_action')) exit;
/*
Template Name: Página Sobre
*/
?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="container">
        <div class="row">
            <section class="col-xs-12 col-sm-12 col-md-12 page-about">
                <h1 class="title-default under-line">
                    <?php _e('O que é a ReINC?', 'natio-lang'); ?>
                </h1>
                <div class="the-content">
                    <?php the_translate_content(); ?>
                    <div class="row">
                        <div class="custom-content link-download">
                            <a class="col-sm-4" href="<?php the_field('identidade_visual', get_the_ID());?>" target="_blank" title="<?php _e('Manual da Marca', 'natio-lang');?>">
                                <i class="fa fa-download"></i><?php _e('Manual da Marca', 'natio-lang');?>
                            </a>
                            <a class="col-sm-4" href="<?php the_field('logotipo', get_the_ID());?>" target="_blank" title="<?php _e('Logotipo', 'natio-lang');?>">
                                <i class="fa fa-download"></i><?php _e('Logotipo', 'natio-lang');?>
                            </a>
                            <a class="col-sm-4" href="<?php the_field('regimento_interno', get_the_ID());?>" target="_blank" title="<?php _e('Regimento Interno', 'natio-lang');?>">
                                <i class="fa fa-download"></i><?php _e('Regimento Interno', 'natio-lang');?>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.the-content -->
                <div class="content-tab">
                    <div id="tabs">
                        <ul>
                            <li class="title-tabs"><a href="#tabs-1"></i> <span><?php _e('O que Faz?', 'natio-lang');?></span></a></li>
                            <li class="title-tabs"><a href="#tabs-2"></i> <span><?php _e('Por que isso importa?', 'natio-lang'); ?></span></a></li>
                        </ul>
                        <div class="the-content">
                            <div id="tabs-1">
                               <p><?php the_translate_field('texto_missao', get_the_ID()); //_e(get_field('texto_missao'), 'natio-lang');?></p>
                            </div>
                            <div id="tabs-2">
                                <p><?php the_translate_field('text_visao', get_the_ID()); // _e(get_field('text_visao'), 'natio-lang'); ?></p>
                            </div>
                        </div>
                        <!-- /.the-content -->
                    </div>
                </div>
                <div class="the-content">
                    <h1 class="title-default under-line">
                        <?php _e('Logica de Estruturação dos Projetos Estratégicos', 'natio-lang'); ?>
                    </h1>
                    <div class="row">
                        <div class="content-text col-md-6">
                            <?php the_translate_field('texto_valores', get_the_ID()); ?>
                        </div>
                        <div class="content-accordion col-md-6">
                            <div class="accordion accordion-logica" id="accordion">
                                <?php $controller = 1; ?>
                                <?php $field_name = get_translate_field('logicas'); ?>
                                <?php if( have_rows($field_name) ): ?>
                                    <?php while ( have_rows($field_name) ) : the_row(); ?>
                                        <h3 class="h3 color-five skin-<?php echo $controller; ?>"><?php the_translate_sub_field('nome', get_the_ID() ); ?> <i class="fa fa-plus-circle"></i></h3>
                                        <div class="skin-<?php echo $controller; ?>"><?php the_translate_sub_field('conteudo', get_the_ID() ); ?></div>
                                        <?php ++$controller; ?>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.content-tab -->
            </section>
        </div>
        <div class="row">
            <!-- /.content-numbers -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h1 class="title-default under-line">
                    <?php _e('Objetivos da ReINC', 'natio-lang'); ?>
                </h1>
            </div>
            <ul class="list-default-site the-content col-xs-12 col-sm-12 col-md-6">
                <?php
                $current = 1;
                $controle = get_number_row('objetivos_reinc');
                $num = (int)two_columns($controle);
                $field_name = get_translate_field('objetivos_reinc');
                if( have_rows($field_name) ):
                    while ( have_rows($field_name) ) : the_row();
                    ?>
                        <li><?php the_translate_sub_field('objetivo_reinc', get_the_ID() ); ?></li>
                    <?php
                        if ($current == $num) :
                            echo ' </ul>';
                            echo '<ul class="list-default-site the-content col-xs-12 col-sm-12 col-md-6">';
                        endif;
                        ++$current;
                    endwhile;
                endif;
                ?>
            </ul>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h1 class="title-default under-line">
                    <?php _e('Coordenação', 'natio-lang'); ?>
                </h1>
            </div>
            <?php
            $current = 1;
            if( have_rows('cordenacao') ):
                while ( have_rows('cordenacao') ) : the_row();
                    ?>
                    <div class="col-xs-12 col-sm-12 col-md-6 profile position-<?php echo $current; ?>">
                        <img class="img-profile" src="<?php the_sub_field('imagem_membro');?>" alt="<?php the_sub_field('nome_membro');?>"/>
                        <h3 class="title-profile"><?php _e(get_sub_field('nome_membro'), 'natio-lang');?></h3>
                        <h4 class="subtitle-profile"><?php _e(get_sub_field('cargo_membro'), 'natio-lang');?></h4>
                        <hr/>
                        <ul class="social-profile">
                            <li>
                                <p>
                                    <i class="fa fa-envelope-o"></i>
                                    <span><?php _e(the_sub_field('email_membro'), 'natio-lang');?></span>
                                </p>
                            </li>
                            <li class="icon-linkedin-profile">
                                <a href="<?php the_sub_field('linkedin_membro');?>" title="Veja Perfil no Linkedin" target="_blank">
                                    <i class="fa fa-linkedin"></i>
                                    <span><?php echo sanitize_title(get_sub_field('nome_membro')); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <?php
                     ++$current;
                endwhile;
            endif;
            ?>
        </div>
    </div>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
