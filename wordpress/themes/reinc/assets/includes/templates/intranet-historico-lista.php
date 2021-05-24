<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>
    <div class="accordion-element">
        <div class='header-accordion row'>
            <h2 class='col-xs-12'><?php _e($attributes['title'], 'natio-lang')?><i class='fa-accordion-icon fa'></i></h2>
        </div>
        <div class="content-accordion content-accordion__<?php echo $attributes['post_type'];?>" style="display: block;">
            <div class="row">
                <div class="filter">
                    <div class='col-md-2 col-xs-4'>
                        <div class='filter-container dropdown'>
                            <div class='input-container arq_tipo' data-toggle='dropdown'>
                                <input type='text' name='arq_tipo' class='input' placeholder='Ano' readonly>
                            </div>
                            <ul class='dropdown-menu'>
                                <li class='dropdown-item' data-value='0'>
                                    <a href='javascript:void(0);' data-action='select'>Outros</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class='col-md-5 col-xs-8'>
                        <div class='filter-container dropdown'>
                            <div class='input-container arq_tipo' data-toggle='dropdown'>
                                <input type='text' name='arq_tipo' class='input' placeholder='Tipo' readonly>
                            </div>
                            <ul class='dropdown-menu'>
                                <li class='dropdown-item' data-value='0'>
                                    <a href='javascript:void(0);' data-action='select'>Outros</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class='col-md-5 col-xs-12'>
                		<div class='filter-container search-container'>
                			<input type='text' name='search-text-$term_associate' class='input' data-rel='$term_associate' placeholder='Digite o que procura'>
                		</div>
                	</div>
                </div>
            </div>
            <?php $intra_query = new WP_Query( array('post_type' => ($attributes['post_type']), 'posts_per_page' => -1 ) ); ?>
            <?php while ( $intra_query->have_posts() ) : $intra_query->the_post(); ?>
                <?php $terms = wp_get_post_terms(get_the_ID(), ($attributes['tax']),  array("fields" => "names")); ?>
                <div class='content-item <?php join(' ', $terms);?>'>
                    <h4>
                        <strong><i class="fa- fa"></i><?php the_time('d/m/Y'); ?></strong>
                        <span><?php the_title(); ?></span>
                    </h4>
                    <p class="resumo">
                        <?php echo wp_trim_words(get_field('resumo', get_the_ID()));?>
                    </p>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_query(); ?>
        </div>
    </div>
