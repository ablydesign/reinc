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

	private function get_matriz_infor($eixo, $post_ID, $filter = 'incubadora') {
		switch ($eixo) {

			case 'tipo_de_empresa':
				$term = get_term(get_field('tipo_de_empresa', $post_ID));
				$infor['ID'] 	= $term->term_id;
				$infor['slug'] 	= $term->slug;
				$infor['name'] 	= $term->name;
			break;
			case 'status_da_empresa':
				if (get_field('empresa_'.$filter, $post_ID)) {
					$term = get_term(get_field('status_da_empresa', $post_ID));
					$infor['ID'] 	= $term->term_id;
					$infor['slug'] 	= $term->slug;
					$infor['name'] 	= $term->name;
				} else {
					return false;
				}
			break;
			case 'empresa_incubadora':
				if (get_field('empresa_incubadora', $post_ID)) {
					$rel_ID = (get_field('empresa_incubadora', $post_ID));
			   		$term = get_post($rel_ID[0]);
					$infor['ID'] 	= $term->ID;
					$infor['slug'] 	= $term->post_name;
					$infor['name'] 	= $term->post_title;
				} else {
					return false;
				}
			break;
			case 'empresa_parque':
				if (get_field('empresa_parque', $post_ID)) {
					$rel_ID = (get_field('empresa_parque', $post_ID));
					$term = get_post($rel_ID[0]);
					$infor['ID'] 	= $term->ID;
					$infor['slug'] 	= $term->post_name;
					$infor['name'] 	= $term->post_title;
				} else {
					return false;
				}
			break;
			case 'empresa_programa':
				if (get_field('empresa_programa', $post_ID)) {
					$rel_ID = (get_field('empresa_programa', $post_ID));
					$term = get_post($rel_ID[0]);
					$infor['ID'] 	= $term->ID;
					$infor['slug'] 	= $term->post_name;
					$infor['name'] 	= $term->post_title;
				} else {
					return false;
				}
			break;
			case 'tipo_de_incubadora':
				if (get_field('empresa_incubadora', $post_ID)) {
					$rel_ID = (get_field('empresa_incubadora', $post_ID));
			   		$empresa_incubadora = get_post($rel_ID[0]);
					$term_array = get_field('tipo_de_incubadora', $empresa_incubadora->ID);

					$term = $term_array[0];
					$infor['ID'] 	= $term->term_id;
					$infor['slug'] 	= $term->slug;
					$infor['name'] 	= $term->name;
				} else {
					return false;
				}
			break;
			case 'tipo_de_parque_tecnologico':
				if (get_field('empresa_parque', $post_ID)) {
					$rel_ID = (get_field('empresa_parque', $post_ID));
					$empresa_parque = get_post($rel_ID[0]);
					$tipo_ID = get_field('tipo_de_parque_tecnologico', $empresa_parque->ID);
					$term = get_term($tipo_ID[0]);

					$infor['ID'] 	= $term->term_id;
					$infor['slug'] 	= $term->slug;
					$infor['name'] 	= $term->name;
				} else {
					return false;
				}
			break;
			case 'tipo_programas':
				if (get_field('empresa_programa', $post_ID)) {
					$rel_ID = (get_field('empresa_programa', $post_ID));
					$empresa_programa = get_post($rel_ID[0]);
					$tipo_ID = get_field('tipo_de_parque_tecnologico', $empresa_programa->ID);
					$term = get_term($tipo_ID[0]);

					$infor['ID'] 	= $term->term_id;
					$infor['slug'] 	= $term->slug;
					$infor['name'] 	= $term->name;
				} else {
					return false;
				}
			break;
			case 'localizacao_geografica':
				if ((get_field('localizacao_geografica', $post_ID)) && (get_field('empresa_'.$filter, $post_ID))) {
					$term = get_term(get_field('localizacao_geografica', $post_ID));
					$infor['ID'] 	= $term->term_id;
					$infor['slug'] 	= $term->slug;
					$infor['name'] 	= $term->name;
				} else {
					return false;
				}
			break;
			default:
			break;
		}
		return $infor;

	}

	public function get_indicadores($parameter = array(), $type = 'empresas') {
		/**
		 * Define the array of defaults
		 */
		$defaults = array(
			'request' => 'json',
			'filter' => 'incubadora',
			'relation_y' => '',
			'relation_x' => '',
		);

		 $indicadores = new WP_Query( array(
			  'post_type'     => $type, //post type, I used 'product'
			  'post_status'   => 'publish', // just tried to find all published post
			  'posts_per_page' => -1,
			  'orderby' => array( 
			        $args['relation_x'] => 'ASC',
			        $args['relation_y'] => 'ASC',
			    ),
		 ));

		 $reponse = array();
		 $reponse['table']['row'] = array();
		 $reponse['table']['col'] = array();

		 $args = wp_parse_args( $parameter, $defaults );

		if ($indicadores->have_posts()) {

			while ( $indicadores->have_posts() ) : $indicadores->the_post();

					$column = self::get_matriz_infor($args['relation_y'], get_the_ID(), $args['filter']);
					$row = self::get_matriz_infor($args['relation_x'], get_the_ID(), $args['filter']);

					if ($column && $row) {
						if (empty($reponse['infor'][$row['slug']]['name']) && !empty($row['name'])) {
							$reponse['infor'][$row['slug']]['name'] = $row['name'];
						}

						if (empty($reponse['infor'][$column['slug']]['name']) && !empty($column['name'])) {
							$reponse['infor'][$column['slug']]['name'] = $column['name'];
						}

						if (!in_array($row['slug'], $reponse['table']['row'])) {
							$reponse['table']['row'][] = $row['slug'];
						}

						if (!in_array($column['slug'], $reponse['table']['col'])) {
							$reponse['table']['col'][] = $column['slug'];
						}

						$reponse['infor'][$row['slug']][$column['slug']]['count'] = $reponse['infor'][$row['slug']][$column['slug']]['count'] + 1;
						$reponse['infor'][$row['slug']][$column['slug']]['post_rel'][] = get_the_ID();
					}

			  endwhile;
		 }
		 wp_reset_query();
		 return $reponse;
	}

	public function get_show_result($request_data) {

		$out = array();

		$data = $request_data->get_params();

		$data['relation_y'] = 'tipo_de_incubadora';
		$data['relation_x'] = 'status_da_empresa';


		$out = self::get_indicadores($data);

		wp_send_json($out);
	}

	public function the_biuld_table($eixo_x, $eixo_y, $filter = null, $title_x = null, $title_y = null) {
		$out = '';

		$scope_header = true;
		$scope_row = true;

		$html_header = '';
		$html_rows = '';

		$slug_row = '';

		$total_col = array();

		$column_count = 1;

		$data['relation_x'] = $eixo_x;
		$data['relation_y'] = $eixo_y;

		if (!empty($filter)){
			$data['filter'] = $filter;
		}

		$response = self::get_indicadores($data);

		$rows = $response['table']['row'];
		$cols = $response['table']['col'];

		$infor = $response['infor'];

		if (!empty($rows) && !empty($cols)) :

			foreach ($rows as $row) {
				if ($scope_header) {
					$html_header .= '<tr>';
					$html_header .= '<th class="title-row"><span>'.__($title_x, 'natio-lang').'</span></th>';
				}

				$html_rows .= '<tr>';

				$total_row = 0;

				foreach ($cols as $col) {
					if ($scope_header) {
						$html_header .= '<th data-column="'.$col.'">'.__($infor[$col]['name'], 'natio-lang').'</th>';
					}

					if ($scope_row) {
						$html_rows .= '<th data-row="'.$row.'"  scope="row">'.__($infor[$row]['name'], 'natio-lang').'</th>';
					}

					if (isset($infor[$row][$col]['count'])) {
						$html_rows .= '<td data-row="'.$row.'" data-column="'.$col.'">'.$infor[$row][$col]['count'].'</td>';
					} else {
						$html_rows .= '<td data-row="'.$row.'" data-column="'.$col.'">0</td>';
					}

					$scope_row = false;
					$total_row += $infor[$row][$col]['count'];
					$slug_row = $row;
					$total_col[$col]['slug'] = $col;
					$total_col[$col]['count'] += $infor[$row][$col]['count'];
				}
				$html_rows .= '<td data-row="'.$slug_row.'"  class="row-total">'.$total_row.'</td>';
				$html_rows .= '</tr>';

				if ($scope_header) {
					$html_header .= '<th><span>'.__('Total', 'natio-lang').'</span></th>';
					$html_header .= '</tr>';
				}

				$scope_row = true;
				$scope_header = false;
			}
			$out .= '<table class="table table-bordered">';
				$out .= '<thead>';
					if (!empty($title_y)) {
						$colspan = (count($cols));
						$out .= '<tr>';
							$out .= '<th class="empty"><span></span></th>';
							$out .= '<th class="title-column" colspan="'.$colspan.'"><span>'.__($title_y, 'natio-lang').'</span></th>';
						$out .= '</tr>';
					}
					$out .= $html_header;
			 	$out .= '</thead>';
				$out .= '<tbody>';
					$out .= $html_rows;
				$out .= '</tbody>';
				$out .= '<tfoot>';
					$out .= '<tr>';
						$out .= '<th data-column="total"><span>Total</span></th>';
						foreach ($total_col as $col) {
							 $out .= '<td data-column="'.$col['slug'].'" class="column-total">'.$col['count'].'</td>';
						}
					$out .= '</tr>';
				$out .= '</tfoot>';
			$out .= '</table>';
		endif;
		echo $out;

	}

	public function route_api () {
		register_rest_route(
			"reinc-api/v1",
			'/indicadores',
			array(
				'methods'         => \WP_REST_Server::READABLE,
				'callback'        => array($this, 'get_show_result'),
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
