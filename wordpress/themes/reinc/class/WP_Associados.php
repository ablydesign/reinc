<?php
/**
 * Class que implementa recursos utilizados pela categoria associados
 * @author Lucas Ramos
 */

 class WP_Associados{

     function __construct($argument =  NULL) {
          add_action('init', array($this, 'global_associados'));
     }

     public function get_menu($taxonomy){
          $controll = 1;
          $out = array();

          $arg = array(
               'hide_empty' => FALSE,
               'show_all_button' => TRUE,
          );

          $all_terms = get_terms($taxonomy,$arg);

          $out[0]['ID'] = 0;
          $out[0]['name'] = __('Todos', 'natio-lang');
          $out[0]['slug'] = 'all';
          $out[0]['link'] = 'javascript:void(0);';

          foreach ($all_terms as $term) {
               $out[$controll]['ID'] = $term->term_id;
               $out[$controll]['name'] = $term->name;
               $out[$controll]['slug'] = $term->slug;
               $out[$controll]['link'] = get_term_link($term, $taxonomy);
               ++$controll;
          }

          $object = (object) array('number' => $controll, 'menu' => $out);

          return $object;
     }

     private function get_terms_post($post_ID, $tax = '', $return = 'names'){
          $post_terms = wp_get_post_terms($post_ID, $tax, array("fields" => $return));
          return join(' ', $post_terms);
     }

     public function get_type_list ($type, $taxonomy) {
          $query = new WP_Query(array(
               'post_type'       => $type,
               'post_status'     => 'publish',
               'posts_per_page'  => -1,
               'orderby'         => "title",
     		'order'           => "ASC"
          ));

          if($query->have_posts()) :
     		$out_custom = array();
     		while ($query->have_posts()): the_post();
                    $out_custom[] = array(
                         'title'        => get_the_title(get_the_ID()),
                         'title_slug'   => sanitize_title(get_the_title(get_the_ID())),
                         // 'tax_name'     => self::get_terms_post(get_the_ID(), $taxonomy, 'names'),
                         // 'tax_slug'     => self::get_terms_post(get_the_ID(), $taxonomy, 'slug'),
                    );
               endwhile;
          endif;
          wp_reset_postdata();
          return $out_custom;
     }


     public function get_posts_year ($post_type) {
          $year = array();
          $posts = new WP_Query(array('post_type' => $post_type, 'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'ASC') );
          while ( $posts->have_posts() ) : $posts->the_post();
               $current_year = get_the_date('Y',  get_the_ID());
               if (!in_array($current_year, $year)) {
                    $year[] = $current_year;
               }
          endwhile;
          wp_reset_query();
          return $year;
     }


     public function the_menu_accordion_html ($label, $taxonomy, $term_associate, $class = '') {
          $out = '';

          if (!empty($taxonomy)) :

               $menu_list = self::get_menu($taxonomy);
               $out .= "<h3 class='accordion-title' data-associate='".$term_associate."'>".__($label, 'natio-lang')."<i class='fa-accordion-icon fa'></i></h3>";
               $out .= "<div class='accordion-content'>";
                    $out .= "<ul class='accordion-content__list'>";
                    foreach($menu_list->menu as $menu_item):
                         $out .= "<li class='accordion-content__list_item ".$class."'>";
                              $out .= "<a href='" . $menu_item['link'] . "' class='bt-link' data-associate='".$term_associate."' data-type='".$menu_item['slug']."'>";
                                   $out .= __($menu_item['name'], 'natio-lang');
                              $out .= "</a>";
                         $out .= "</li>";
                    endforeach;
                    $out .= "</ul>";
               $out .= "</div>";
          endif;

          echo $out;
     }

     public function the_filter_html ($type, $taxonomy, $placeholder = '') {
          $out .= "<div class='filter-container dropdown filter-$type'>";
               $out .= "<div class='input-container' data-toggle='dropdown'>";
                    $out .= "<input type='text' name='filter-$type' class='input' placeholder='$placeholder' readonly>";
               $out .= "</div>";
               $out .= "<ul class='dropdown-menu dropdown-content__list'>";
               $the_query = new WP_Query(array(
                    'post_type'       => $type,
                    'post_status'     => 'publish',
                    'posts_per_page'  => -1,
                    'orderby'         => "title",
                    'order'           => "ASC"
               ));
               $out .= "<li class='dropdown-content__list_item'>";
                    $out .= "<a href='javascript:void(0);' class='bt-link' data-filter_child='all' data-type='$type'>";
                         $out .= __('Mostrar todos', 'natio-lang');
                    $out .= "</a>";
               $out .= "</li>";
               while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    $title = get_the_title(get_the_ID());
                    $out .= "<li class='dropdown-content__list_item'>";
                         $out .= "<a href='javascript:void(0);' class='bt-link' data-filter_child='".sanitize_title($title)."' data-type='$type'>";
                              $out .= __($title, 'natio-lang');
                         $out .= "</a>";
                    $out .= "</li>";
               }
               wp_reset_postdata();
               $out .= "</ul>";
          $out .= "</div>";

          echo $out;
     }

     public function get_count_associados_by($type, $tax_query){
          $args = array(
              'post_type'     => $type, //post type, I used 'product'
              'post_status'   => 'publish', // just tried to find all published post
              'posts_per_page' => -1,  //show all
              'tax_query' => array(
                   'relation' => 'AND',
                   array(
                        'taxonomy' => 'empresa_status',  //taxonomy name  here, I used 'product_cat'
                        'field' => 'slug',
                        'terms' => array( $value )
                   )
              )
          );

          $query = new WP_Query( $args);
          return (int)$query->post_count;
      }

      public function get_thumb_type($type, $post_ID) {
        $src = null;

        switch($type){
          case 'incubadoras':
            $field_name = "incubadora_logotipo";
          break;
          case 'parques_tecnologicos':
            $field_name = "parque_tecnologico_logotipo";
          break;
          case 'empresas':
            $field_name = "empresa_logotipo";
          break;
        }

        $thumb_logotipo = get_field($field_name, $post_ID);

        if (!empty($thumb_logotipo['sizes']['thumbnail'])) {
          $src = $thumb_logotipo['sizes']['thumbnail'];
        } else {
          $src = "http://www.reinc.org.br/wp-content/themes/reinc/assets/img/thumb-default-150.png";
        }

        return $src;
      }

      public function get_path_thumb($type, $post_ID) {
        $src = null;

        switch($type){
          case 'incubadoras':
            $field_name = "incubadora_logotipo";
          break;
          case 'parques_tecnologicos':
            $field_name = "parque_tecnologico_logotipo";
          break;
          case 'empresas':
            $field_name = "empresa_logotipo";
          break;
        }

        $thumb_logotipo = get_field($field_name, $post_ID);
        $upload_dir = wp_upload_dir();

        if (!empty($thumb_logotipo['sizes']['thumbnail'])) {
          $thumb = explode('/', $thumb_logotipo['sizes']['thumbnail']);
          $length = count($thumb);
          $src = $upload_dir['basedir'] . '/'.$thumb[$length-3] .'/'.$thumb[$length-2] .'/'.$thumb[$length-1];
        } else {
          $theme_dir = get_template_directory();
          $src = $theme_dir."/assets/img/thumb-default.png";
        }
        return $src;
      }

      public function get_prefix_field($type) {
        $prefix = null;

        switch($type){
          case 'incubadoras':
            $prefix = "incubadora";
          break;
          case 'parques_tecnologicos':
            $prefix = "parque_tecnologico";
          break;
          case 'empresas':
            $prefix = "empresa";
          break;
        }
        return $prefix;
      }

      public function global_associados() {

          global $associados_infor;

          $incubadoras = wp_count_posts("incubadoras");
          $associados_infor['incubadoras']['count'] = (!empty($incubaras->publish)) ? $incubaras->publish : 0;

          $incubadoras = WP_Incubadoras::get_count('base-tecnologica');
          $associados_infor['incubadoras']['base-tecnologica']['count'] = (!empty($incubaras)) ? $incubaras : 0;

          $incubadoras = WP_Incubadoras::get_count('design-economia-criativa');
          $associados_infor['incubadoras']['design-economia-criativa']['count'] = (!empty($incubaras)) ? $incubaras : 0;

          $incubadoras = WP_Incubadoras::get_count('economia-solidaria');
          $associados_infor['incubadoras']['economia-solidaria']['count'] = (!empty($incubaras)) ? $incubaras : 0;

          $parques = wp_count_posts("parques_tecnologicos");
          $associados_infor['parques_tecnologicos']['count']  = (!empty($parques->publish)) ? $parques->publish : 0;

          $empresas = wp_count_posts("empresas");
          $associados_infor['empresas']['count']  = (!empty($empresas->publish)) ? $empresas->publish : 0;

          $programas = wp_count_posts("programas_aceleracao");
          $associados_infor['programas']['count']  = (!empty($programas->publish)) ? $programas->publish : 0;

          $empresas = WP_Empresas::get_count('incubadas');
          $associados_infor['empresas']['incubadas']['count'] = (!empty($empresas)) ? $empresas : 0;

          $empresas = WP_Empresas::get_count('graduadas');
          $associados_infor['empresas']['graduadas']['count'] = (!empty($empresas)) ? $empresas : 0;

          $empresas = WP_Empresas::get_count('associadas');
          $associados_infor['empresas']['associadas']['count'] = (!empty($empresas)) ? $empresas : 0;

          $empresas = WP_Empresas::get_count('instaladas');
          $associados_infor['empresas']['instaladas']['count'] = (!empty($empresas)) ? $empresas : 0;

     }

 }

$wp_associados = new WP_Associados();
