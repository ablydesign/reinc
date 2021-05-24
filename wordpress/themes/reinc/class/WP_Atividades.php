<?php
/**
 * Class que implementa recursos utilizados pelo Custom Post Type ATIVIDADES
 * @author Lucas Ramos
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class WP_Atividades{

    function __construct($argument =  null) {

        //shortcode
    	add_shortcode( 'intranet_atividades_lista', array( $this, 'intranet_shortcode_lista' ) );
    }

    public function get_agroup_content ($exclude_tree) {
        $content = array();
        $all_terms = get_terms('custom_atividades_segmentos', array('exclude_tree' => $exclude_tree, 'orderby' => 'term_group', 'order'=>'DESC', 'childless' => true));
        $parent = self::get_agroup_menu_filter($exclude_tree);
        if (!empty($all_terms)) :
            foreach ($all_terms as $term) :
                $rel_posts = array();
                $content[] = array(
                    'ID' => $term->term_id,
                    'name' => __($term->name, 'natio-lang'),
                    'slug' => $term->slug,
                    'slug_parent' => $parent[$term->parent]['slug'],
                );
            endforeach;
        endif;
        return $content;
    }

    private function get_agroup_menu_filter ($exclude_tree) {
        $menu = array();
        $all_terms = get_terms('custom_atividades_segmentos', array('exclude_tree' => $exclude_tree, 'orderby' => 'term_group', 'order'=>'DESC', 'hide_empty' => false));
        if (!empty($all_terms)) {
            foreach ($all_terms as $term) :
                if ($term->parent === 0) {
                    $menu[$term->term_id] = array(
                        'ID' => $term->term_id,
                        'name' => __($term->name, 'natio-lang'),
                        'slug' => $term->slug,
                        'link' =>  get_term_link($term),
                    );
                }
            endforeach;
        }
        return $menu;
    }


    public function the_menu_filter ($exclude_tree) {

        $menu = self::get_agroup_menu_filter($exclude_tree);

        $out = '';
        $out .= '<ul class="filter-atividades">';
        foreach ($menu as $menu_item ) :
          $out .= '<li class="cat-item cat-item-'.$menu_item['ID'].' col-md-3">';
                $out .= '<a href="'.$menu_item['link'].'" data-filter="'.$menu_item['slug'].'">'.$menu_item['name'].'</a>';
            $out .= '</li>';
        endforeach;
        $out .= '</ul>';
        echo $out;
    }

    public function the_menu_accordion_html ($exclude_tree, $filter = '') {
      $out = '';

      $out_inner = array();

      $filters = self::get_menu($exclude_tree);

      $out .= '<div class="accordion-container '.$filter.'">';
        foreach ( $filters as $filter ) :
          $filter_inner = '';
          $filter_inner .= "<h3 class='accordion-title'>". __($filter->name, 'natio-lang') . "<i class='fa-accordion-icon fa'></i></h3>";
          $filter_inner .= "<div class='accordion-content'>";
            $query = new WP_Query(array(
              'post_type' => 'custom_atividades',
              'posts_per_page' => -1,
              'tax_query' => array(
                array(
                  'taxonomy' => 'custom_atividades_segmentos',
                  'field' => 'slug',
                  'terms' => $filter->slug
                )
              )
            ));
            while ( $query->have_posts() ) : $query->the_post();
              $filter_inner .= '<a href="'.get_permalink(get_the_ID()).'" title="'.get_the_title(get_the_ID()).'">'.get_the_title(get_the_ID()).'</a>';
            endwhile;
          $filter_inner .= "</div>";
        endforeach;
    }

 }

$wp_atividades = new WP_Atividades();
