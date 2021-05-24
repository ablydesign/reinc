<?php
/**
 * Class que implementa recursos utilizados pela categoria associados
 * @author Lucas Ramos
 */

 class WP_Biblioteca{

     function __construct($argument =  null) {

     }

     public function get_menu ($exclude_tree, $type = null) {
       $controll = 1;
       $return = array();

      if ($type == 'all') {
        $all_terms = get_terms('custom_biblioteca_segmentos', array('exclude_tree' => $exclude_tree, 'orderby' => 'term_group'));
        foreach ($all_terms as $term) :

          if ($term->parent == 0) {
            $return[$term->term_id][0]['ID'] = $term->term_id;
            $return[$term->term_id][0]['name'] = $term->name;
            $return[$term->term_id][0]['slug'] = $term->slug;
          } else {
            $return[$term->parent][$term->term_id]['ID'] = $term->term_id;
            $return[$term->parent][$term->term_id]['name'] = $term->name;
            $return[$term->parent][$term->term_id]['slug'] = $term->slug;
          }
        endforeach;
      } else {
        $all_terms = get_terms('custom_biblioteca_segmentos', array('exclude_tree' => $exclude_tree, 'childless' => true));
         foreach ($all_terms as $term) :
             $return[$controll]['ID'] = $term->term_id;
             $return[$controll]['name'] = $term->name;
             $return[$controll]['slug'] = $term->slug;
         endforeach;
      }
       return $return;
     }

     public function the_menu_accordion_html ($exclude_tree, $filter_inner = '') {
          $out = '';

          $out_inner = array();

          $filters = self::get_menu($exclude_tree);

          $out .= '<div class="accordion-container '.$filter_inner.'">';

          foreach ( $filters as $filter ) :
               $out .= "<h3 class='accordion-title'>". __($filter['name'], 'natio-lang') . "<i class='fa-accordion-icon fa'></i></h3>";
               $out .= "<div class='accordion-content'>";
               $query = new WP_Query(array(
                    'post_type' => 'custom_biblioteca',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                         array(
                             'taxonomy' => 'custom_biblioteca_segmentos',
                             'field' => 'slug',
                             'terms' => $filter['slug']
                         )
                    )
               ));
               while ( $query->have_posts() ) : $query->the_post();
                    $out .= '<a href="'.get_permalink(get_the_ID()).'" title="'.get_the_title(get_the_ID()).'">'.get_the_title(get_the_ID()).'</a>';
               endwhile;
              $out .= "</div>";
         endforeach;

         $out .= "</div>";

         echo $out;
     }

}

$wp_biblioteca = new WP_Biblioteca();
