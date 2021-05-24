<?php
/**
 * Class que implementa mostrar indicadores
 * @author Lucas Ramos
 */

 class WP_Indicadores {
	public static $instance;

	function __construct($argument =  NULL) {
		add_action( 'rest_api_init',array($this, 'route_api'));
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

	public function get_indicadores($request_data) {
		/**
		 * Define the array of defaults
		 */
		$defaults = array(
			'request' => 'json',
		);

		 $indicadores = new WP_Query( array(
			  'post_type'     => 'empresas', //post type, I used 'product'
			  'post_status'   => 'publish', // just tried to find all published post
			  'posts_per_page' => -1
		 ));

		 $reponse = array();

		 $data = $request_data->get_params();

		 $args = wp_parse_args( $data, $defaults );

		 if ($indicadores->have_posts()) {
			  while ( $indicadores->have_posts() ) : $indicadores->the_post();
				   if (get_field('tipo_de_empresa', get_the_ID())) {
						$term_tipo = get_term(get_field('tipo_de_empresa', get_the_ID()));
						if (empty($reponse['tipo'][$term_status->slug]['name'])){
							 $reponse['tipo'][$term_tipo->slug]['name'] = $term_tipo->name;
						}
						$reponse['tipo'][$term_tipo->slug]['count'] = $reponse['tipo'][$term_tipo->slug]['count'] + 1;
						$reponse['tipo'][$term_tipo->slug]['post_rel'][] = get_the_ID();
						if (get_field('status_da_empresa', get_the_ID())) {
							 $term_status = get_term(get_field('status_da_empresa', get_the_ID()));
							 if (empty($reponse['tipo'][$term_tipo->slug]['status'][$term_status->slug]['name'])){
								  $reponse['tipo'][$term_tipo->slug]['status'][$term_status->slug]['name'] = $term_status->name;
							 }
							 $reponse['tipo'][$term_tipo->slug]['status'][$term_status->slug]['count'] = $reponse['tipo'][$term_tipo->slug]['status'][$term_status->slug]['count'] + 1;
							 $reponse['tipo'][$term_tipo->slug]['status'][$term_status->slug]['post_rel'][] = get_the_ID();
						}
						if (get_field('empresa_incubadora', get_the_ID())) {
							 $rel_ID = (get_field('empresa_incubadora', get_the_ID()));
							 $empresa_incubadora = get_post($rel_ID[0]);
							 $term_rel = get_field('tipo_de_incubadora', $empresa_incubadora->ID);
							 if (!empty($term_rel[0])) {
								  $empresa_incubadora_tipo = $term_rel[0];
								  if (empty($reponse['tipo'][$term_status->slug]['incubadora_tipo'][$empresa_incubadora_tipo->slug]['name'])){
									   $reponse['tipo'][$term_tipo->slug]['incubadora_tipo'][$empresa_incubadora_tipo->slug]['name'] = $empresa_incubadora_tipo->name;
								  }
								  $reponse['tipo'][$term_tipo->slug]['incubadora_tipo'][$empresa_incubadora_tipo->slug]['count'] = $reponse['tipo'][$term_tipo->slug]['incubadora_tipo'][$empresa_incubadora_tipo->slug]['count'] + 1;
								  $reponse['tipo'][$term_tipo->slug]['incubadora_tipo'][$empresa_incubadora_tipo->slug]['post_rel'][] = get_the_ID();
							 }
						}
				   }

				   if (get_field('status_da_empresa', get_the_ID())) {
						$term_status = get_term(get_field('status_da_empresa', get_the_ID()));
						if (empty($reponse['status'][$term_status->slug]['name'])){
							 $reponse['status'][$term_status->slug]['name'] = $term_status->name;
						}
						$reponse['status'][$term_status->slug]['count'] = $reponse['status'][$term_status->slug]['count'] + 1;
						$reponse['status'][$term_status->slug]['post_rel'][] = get_the_ID();
						if (get_field('empresa_incubadora', get_the_ID())) {
							 $rel_ID = (get_field('empresa_incubadora', get_the_ID()));
							 $empresa_incubadora = get_post($rel_ID[0]);
							 $term_rel = get_field('tipo_de_incubadora', $empresa_incubadora->ID);
							 if (!empty($term_rel[0])) {
								  $empresa_incubadora_tipo = $term_rel[0];
								  if (empty($reponse['status'][$term_status->slug]['incubadora_tipo'][$empresa_incubadora_tipo->slug]['name'])){
									   $reponse['status'][$term_status->slug]['incubadora_tipo'][$empresa_incubadora_tipo->slug]['name'] = $empresa_incubadora_tipo->name;
								  }
								  $reponse['status'][$term_status->slug]['incubadora_tipo'][$empresa_incubadora_tipo->slug]['count'] = $reponse['status'][$term_status->slug]['incubadora_tipo'][$empresa_incubadora_tipo->slug]['count'] + 1;
								  $reponse['status'][$term_status->slug]['incubadora_tipo'][$empresa_incubadora_tipo->slug]['post_rel'][] = get_the_ID();
							 }
						}
				   }

				   if (get_field('empresa_incubadora', get_the_ID())) {
						$rel_ID = (get_field('empresa_incubadora', get_the_ID()));
						$empresa_incubadora = get_post($rel_ID[0]);
						if (empty($reponse['incudadoras'][$empresa_incubadora->post_name]['name'])){
							 $reponse['incudadoras'][$empresa_incubadora->post_name]['name'] = $empresa_incubadora->post_title;
						}
						$reponse['incudadoras'][$empresa_incubadora->post_name]['count'] = $reponse['incudadoras'][$empresa_incubadora->post_name]['count'] + 1;
						$reponse['incudadoras'][$empresa_incubadora->post_name]['post_rel'][] = get_the_ID();
						if (get_field('status_da_empresa', get_the_ID())) {
							 $term_status = get_term(get_field('status_da_empresa', get_the_ID()));
							 if (empty($reponse['incudadoras'][$empresa_incubadora->post_name]['status'][$term_status->slug]['name'])){
								  $reponse['incudadoras'][$empresa_incubadora->post_name]['status'][$term_status->slug]['name'] = $term_status->name;
							 }
							 $reponse['incudadoras'][$empresa_incubadora->post_name]['status'][$term_status->slug]['count'] = $reponse['incudadoras'][$term_tipo->slug]['status'][$term_status->slug]['count'] + 1;
							 $reponse['incudadoras'][$empresa_incubadora->post_name]['status'][$term_status->slug]['post_rel'][] = get_the_ID();
						}
				   }

				   if (get_field('empresa_parque', get_the_ID())) {
						$rel_ID = (get_field('empresa_parque', get_the_ID()));
						$empresa_parque = get_post($rel_ID[0]);
						if (empty($reponse['parque'][$empresa_parque->post_name]['name'])){
							 $reponse['parque'][$empresa_parque->post_name]['name'] = $empresa_parque->post_title;
						}
						$reponse['parque'][$empresa_parque->post_name]['count'] = $reponse['parque'][$empresa_parque->post_name]['count'] + 1;
						$reponse['parque'][$empresa_parque->post_name]['post_rel'][] = get_the_ID();
				   }
			  endwhile;
			  $reponse['all']['total'] = $indicadores->post_count;
		 }
		 wp_reset_query();
		 if ($args['request'] === 'json') {
			 wp_send_json($reponse);
		 } else {
			 return $reponse;
		 }
	}

	public function route_api () {
		register_rest_route(
			"reinc-api/v1",
			'/indicadores',
			array(
				'methods'         => \WP_REST_Server::READABLE,
				'callback'        => array($this, 'get_indicadores'),
				'args'            => array(
					'filter'=> array(
						'relation' => array(
							'default' => '',
						)
					)
				)
			)
		);
	}
 }
$wp_indicadores = WP_Indicadores::get_instance();
