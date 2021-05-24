<?php get_header(); ?>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
    <div class="container">
        <div class="row">
            <section>
                <article class="text-content">
                    <div class="col-xs-12">
                        <h1 class="title-default under-line"><?php the_title(); ?></h1>
                        <div class="row containerVoltar">
    						<a href="<?php echo get_permalink(9); ?>" class="Voltar pull-right"><?php echo _("< Voltar"); ?></a>
        				</div>
                    </div>
                    <div class="col-xs-12 col-lg-3 resumo">
                        <?php the_field("resumo"); ?>
                        <p><?php the_date('d.m.Y', '<span>', '</span>'); ?></p>
                        <?php if (has_post_thumbnail()) :?>
                            <div class="thumbnail">
                                <?php the_post_thumbnail('medium');?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-xs-12 col-lg-9 descricao">
                        <h4><?php echo __("Descrição:", 'natio-lang'); ?></h4>
                        <?php the_field("descricao"); ?>
                        <p>
                            <?php the_terms( get_the_ID(), 'custom_tags', '<strong>Tags: </strong>', ',', '' ); ?>
                        </p>
                        <?php if( have_rows('saiba_mais')): ?>
                            <p class="saibamais-container">
                                <strong><?php echo __("Saiba Mais:", 'natio-lang'); ?></strong>
                                <?php while ( have_rows('saiba_mais') ) : the_row(); ?>
                                    <?php if (get_sub_field('texto')) : ?>
                                        <a href="<?php the_sub_field('link_externo'); ?>" target="_blank">
                                            <?php the_translate_sub_field('texto', get_the_ID()); ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            </p>
                        <?php endif; ?>
                        <?php if (have_rows('arquivos')) : ?>
                            <p class="single-container-arquivos">
                                <strong><?php _e('Arquivos para Baixar', 'natio-lang');?>:  </strong>
                                <?php while ( have_rows('arquivos') ) : the_row(); ?>
                                    <?php if (get_sub_field('nome')) : ?>
                                        <a href="<?php the_sub_field('arquivo'); ?>" target="_blank">
                                            <?php the_translate_sub_field('nome', get_the_ID()); ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="col-xs-12 gallery">
                        <h2 class="under-line">
    						<?php echo __("Galeria de Fotos", 'natio-lang'); ?>
    					</h1>
                        <?php $images = get_field('galeria'); ?>
                        <?php if( $images ): ?>
                            <ul class="row">
                                <?php foreach( $images as $image ): ?>
                                    <li class="col-xs-12 col-lg-3 col-md-6">
                                        <a href="<?php echo $image['url']; ?>" class="fancybox" rel="gallery-fancybox" >
                                             <img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" />
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </article>
            </section>
        </div>
    </div>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>
