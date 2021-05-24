<div class="all-favorites">
    <span class="close-modal">X</span><h5 class="title-modal">Added property. </h5>
    <?php $favorites = get_user_favorites();


    if ( isset($favorites) && !empty($favorites) ) :
        foreach ( $favorites as $favorite ) :

        endforeach;
    endif;
    $favorites_query = new WP_Query(array(
        'post_type' => 'propriedades',
        'posts_per_page' => 3,
        'post__in' => $favorites
    ));
    if ( $favorites_query->have_posts() ) : while ( $favorites_query->have_posts() ) : $favorites_query->the_post();?>
        <div class="item-favorite">
            <?php
            echo '<a href="' . get_permalink() ."?lang=en". '">';
            ?>
            <?php the_post_thumbnail( 'home-galeria', array( 'class'=> ' img-responsive img-favorite' ));?>
            <h3 class="title-item-favorite"><?php the_field('titulo_propriedade_en'); ?></h3>
            <?php echo '</a>';?>
        </div>
    <?php
    endwhile; endif; wp_reset_postdata();
    ?>
    <span class="btn-light show-all" href="">See ALL</span>
    <a class="btn-light" href=""><i class="fa fa-envelope-o"></i> SHARE</a>
</div>

