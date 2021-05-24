<?php
/**
 * Class que implementa recursos utilizados pela categoria associados
 * @author Lucas Ramos
 */

 class WP_Parques{

     function __construct($argument =  null) {

     }


     public function get_count_empresas_by_id($post_ID = null){
          $args = array(
              'post_type'     => 'empresas', //post type, I used 'product'
              'post_status'   => 'publish', // just tried to find all published post
              'posts_per_page' => -1,  //show all
              'meta_query' => array(
                   'relation' => 'AND',
                   array(
                         'key'     => 'empresa_parque',
			          'value'   => $post_ID,
		               'compare' => 'LIKE',
                   )
              )
          );

          $query = new WP_Query( $args);

          return (int) $query->post_count;
     }

 }


 $wp_parques = new WP_Parques();
