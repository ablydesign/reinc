<?php
/**
 * Class que implementa recursos utilizados pela categoria associados
 * @author Lucas Ramos
 */

 class WP_Empresas{
      public static $instance;

     function __construct($argument =  null) {

     }

     /**
	* Função para instancia um unico objeto;
	*/
	public static function get_instance(){
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}


     public function get_count($tax_terms){
          $args = array(
              'post_type'     => 'empresas', //post type, I used 'product'
              'post_status'   => 'publish', // just tried to find all published post
              'posts_per_page' => -1,  //show all
              'tax_query' => array(
                   'relation' => 'AND',
                   array(
                        'taxonomy' => 'empresa_status',  //taxonomy name  here, I used 'product_cat'
                        'field' => 'slug',
                        'terms' => $tax_terms
                   )
              )
          );

          $query = new WP_Query( $args);

          return (int) $query->post_count;
     }

}
