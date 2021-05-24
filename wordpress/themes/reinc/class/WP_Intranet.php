<?php
/**
 * Class que implementa recursos utilizados pela categoria associados
 * @author Lucas Ramos
 */
require_once('WP_Intranet_Excel.php');

class WP_Intranet{

    function __construct($argument =  null) {

    	// Shortcodes
		add_shortcode( 'cadastros_lista', array( $this, 'shortcode_cadastros' ) );
    	add_shortcode( 'historico_lista', array( $this, 'intranet_shortcode_lista' ) );
    	add_shortcode( 'form_projetos', array( $this, 'shortcode_cadastros_projetos' ) );
    	add_shortcode( 'lista_projetos', array( $this, 'shortcode_listar_projetos' ) );
    	add_shortcode( 'link', array( $this, 'shortcode_link_content' ) );

    	//hook ajax
        add_action( 'wp_ajax_custom_insert_projeto', array( $this, 'custom_insert_projeto' ));
        add_action('wp_ajax_download_planilha', array($this, 'download_planilha'));
        //add_action( 'wp_ajax_nopriv_custom_insert_projeto', array( $this, 'custom_insert_projeto' ));

        //
        add_action('wp_footer', array($this, 'add_scripts'));
    }

	/**
    * Pega o template do shorte code de um arquivo externo
    *
    * @param 	string 		$template_name 		| O nome do arquivo sem a extensão
    * @param 	array  		$attributes    		| attributos necesssarios para constriuir o template
    *
    * @return	string      $out				| O conteudo html do que será incluido na página.
    */
    private function get_template_html( $template_name, $attributes = null ) {
        if ( ! $attributes ) {
            $attributes = array();
        }
        ob_start();
        $theme_path = get_template_directory();
        require_once( $theme_path . $template_name . '.php');
        $html .= ob_get_contents();
        ob_end_clean();

        return $html;
    }

    /**
	* Adiciona os script e css necessarios para a página caso a variavel shortcode_js, seja verdadeira
	*
	*/
	public function add_scripts () {
		$script_toast['css'] = get_template_directory_uri () . '/assets/css/plugin.main.css';
		$script_toast['url'] = get_template_directory_uri () . '/assets/js/jquery.toast.min.js';
		$script_toast['path'] = TEMPLATEPATH . '/assets/js/jquery.intranet.js';
		wp_register_script(
			'script-toast',
			$script_toast['url'],
			array('jquery'),
			filemtime($script_toast['path']),
			true
		);
		wp_enqueue_script('script-toast');
		wp_enqueue_style('style-toast', $script_toast['css'] , true,	'plugin-toast');

		$script_fancybox['url'] = get_template_directory_uri () . '/assets/js/jquery.intranet.plugins.min.js';
		$script_fancybox['path'] = TEMPLATEPATH . '/assets/js/jquery.intranet.plugins.min.js';
		wp_register_script(
			'script-fancybox',
			$script_fancybox['url'],
			array('jquery'),
			filemtime($script_fancybox['path']),
			true
		);
		wp_enqueue_script('script-fancybox');

		$script_intranet['url'] = get_template_directory_uri () . '/assets/js/jquery.intranet.js';
		$script_intranet['path'] = TEMPLATEPATH . '/assets/js/jquery.intranet.js';
		wp_register_script(
			'script-intranet',
			$script_intranet['url'],
			array('jquery', 'script-toast'),
			filemtime($script_intranet['path']),
			true
		);
		wp_enqueue_script('script-intranet');
		wp_localize_script('script-intranet', 'ajax_object', array('url' => admin_url( 'admin-ajax.php' )));

	}

    public function custom_insert_projeto () {
    	$out = array();
    	if (is_user_logged_in()) {
			if (!isset( $_POST['projeto_nome']) || empty( $_POST['projeto_nome'])) :
				$out['error'][] = __('Favor informe um nome', 'natio-lang');
			endif;
			if (!isset( $_POST['projeto_descricao']) || empty( $_POST['projeto_descricao'])):
				$out['error'][] = __('Favor informe um texto', 'natio-lang');
			endif;
			if (!isset( $_POST['projeto_link']) || empty( $_POST['projeto_link'])):
				$out['error'][] = __('Favor informe um Link', 'natio-lang');
			endif;

			if (!wp_verify_nonce($_POST['add_projeto_nonce'], 'add_projeto' ) && !check_ajax_referer('add_projeto_security_nonce', 'security_nonce') ):
				$out['error'][] = __('Falha ao validar sua solicitação', 'natio-lang');
			endif;

			if (!isset($out['error'])) :
				$title = $_POST['projeto_nome'];
				$content = '<p>'. $_POST['projeto_descricao'] .'</p>';

				$args = array(
					'post_type' => 'custom_projetos',
					'post_title' => $title,
					'post_content' => $content,
					'post_status' => 'publish',
					'comment_status' => 'closed',
					'ping_status' => 'closed',
				);
				$content_button = '<a href="'.$_POST['projeto_link'].'" class="button button-primary button-large">Visualizar</a>';

				$post_id = wp_insert_post( $args, true );
				update_field('field_577d239f8930c', $_POST['projeto_link'], $post_id);
				update_field('field_577d2582a36f2', $content_button, $post_id);


				if (!($post_id instanceof WP_Error)) {
					$out['sucess']['msg'] = __("Seu Projeto foi salvo com sucesso", 'natio-lang');
					$out['sucess']['post'] = get_post($post_id, ARRAY_A, 'display');
				} else {
					$out['error'][] = __("Erro ao Salvar ", 'natio-lang');
					$out['error'][] = $post_id;
				}

			endif;
		}else {
			$out['error'] = __("Essa ação não pode ser executada ", 'natio-lang');
		}
		wp_send_json($out);
    }

    public function download_planilha() {
    	if (($_REQUEST['type'] == 'incubadoras') && wp_verify_nonce($_REQUEST['_wpnonce'], 'download_incubadoras')) {
    		WP_Intranet_Excel::gen_planilha_incubadora();
    	} elseif (($_REQUEST['type'] == 'parques_tecnologicos') && wp_verify_nonce($_REQUEST['_wpnonce'], 'download_parques_tecnologicos')) {
    		WP_Intranet_Excel::gen_planilha_parques();
    	} elseif (($_REQUEST['type'] == 'empresas') && wp_verify_nonce($_REQUEST['_wpnonce'], 'download_empresas')) {
    		WP_Intranet_Excel::gen_planilha_empresas();
    	} else {
    		wp_redirect(home_url('intranet/cadastros/'));
    		exit();
    	}
    }

    public function get_filter_cadastro($tax, $term_associate) {
    	$terms_list = WP_Associados::get_menu($tax);

    	$out = "";
    	$out .= "<div class='col-md-6 col-xs-12'>";
    		$out .= "<div class='filter-container dropdown filter-cadastro'>";
    			$out .= "<div class='input-container' data-toggle='dropdown'>";
    				$out .= "<input type='text' name='search-dropdown-$term_associate' class='input' placeholder='Escolha um ' readonly>";
    			$out .= "</div>";
    			$out .= "<ul class='dropdown-menu'>";
	    		foreach($terms_list->menu as $term):
	    			$out .= "<li class='dropdown-item filter-cadastro__item'>";
	                    $out .= "<a href='" . $term['link'] . "' class='bt-link' data-associate='".$term_associate."' data-type='".$term['slug']."'>";
	                        $out .= __($term['name'], 'natio-lang');
	                    $out .= "</a>";
	               	$out .= "</li>";
	    		endforeach;
	    		$out .= "</ul>";
	    	$out .= "</div>";
    	$out .= "</div>";
    	$out .= "<div class='col-md-6 col-xs-12'>";
    		$out .= "<div class='filter-container search-input-container'>";
    			$out .= "<input type='text' id='search-text__$term_associate' name='search-text-$term_associate' class='input search-text search-text__cadastro' data-rel='$term_associate' placeholder='Digite o que procura'></input>";
    		$out .= "</div>";
    	$out .= "</div>";

    	return $out;
    }


	public function intranet_shortcode_lista ($atts,  $content = null) {
		$default = array(
			'id'		=> null,
			'class'		=> null,
			'title' 	=> null,
			'type' 		=> null,
			'tax'		=> null,
			'post_type' => null
		);

		$attributes = shortcode_atts($default, $atts);

        $out .= "<div class='lista-historico col-xs-12'>";
            $out .= "<div class='accordion-element'>";
                $out .= "<div class='header-accordion row'>";
                    $out .= "<h2 class='col-xs-12'>" . __($attributes['title'], 'natio-lang') . "<i class='fa-accordion-icon fa'></i></h2>";
                $out .= "</div>";
                $out .= "<div class='content-accordion content-accordion__" . $attributes['post_type'] . "''>";
                    $out .= "<div class='row'>";
                        $out .= "<div class='filter'>";
                            $out .= "<div class='col-md-2 col-xs-4'>";
                                $out .= "<div class='filter-container dropdown filter-historico__ano'>";
                                    $out .= "<div class='input-container arq_tipo' data-toggle='dropdown'>";
                                        $out .= "<input type='text' name='search-dropdown-ano-" . $attributes['post_type']  ."' class='input' placeholder='Ano' readonly>";
                                    $out .= "</div>";
                                    $out .= "<ul class='dropdown-menu dropdown-year'>";
                                        $out .= "<li class='dropdown-item filter-historico__item'>";
                                            $out .= "<a href='javascript:void(0);' data-year='all'  rel='" . $attributes['post_type']  ."'>Todos</a>";
                                        $out .= "</li>";
										$anos = WP_Associados::get_posts_year($attributes['post_type']);
										foreach ($anos as $ano) {
											$out .= "<li class='dropdown-item filter-historico__item'>";
	                                            $out .= "<a href='javascript:void(0);' data-year='$ano' rel='" . $attributes['post_type']  ."'>$ano</a>";
	                                        $out .= "</li>";
										}
                                    $out .= "</ul>";
                                $out .= "</div>";
                            $out .= "</div>";
                            $out .= "<div class='col-md-5 col-xs-8'>";
                                $out .= "<div class='filter-container dropdown filter-historico__tipo'>";
                                    $out .= "<div class='input-container arq_tipo' data-toggle='dropdown'>";
										$out .= "<input type='text' name='search-dropdown-tipo-" . $attributes['post_type']  ."' class='input' placeholder='Tipo' readonly>";
                                    $out .= "</div>";
                                    $tipos = null;
                                    if ($attributes['post_type'] == 'custom_biblioteca') {
										$tipos = WP_Biblioteca::get_menu(array(54), 'all');
                                    } elseif ($attributes['post_type'] == 'custom_atividades') {
                                    	$tipos = (method_exists(WP_Atividades, 'get_menu') ? WP_Atividades::get_menu(array(53)) : null) /* CodePinch AI Fix */;
                                    }
                                    $out .= "<ul class='dropdown-menu dropdown-tipo-historico'>";
                                        $out .= "<li class='dropdown-item filter-historico__item' >";
                                            $out .= "<a href='javascript:void(0);' data-rel='all' data-type='".$attributes['post_type']."'>Todos</a>";
                                        $out .= "</li>";
                                        foreach ($tipos as $key => $tipo) {
                                        	if (count($tipo) == 1) {
                                        		$out .= "<li class='dropdown-item filter-historico__item' >";
	                                           		$out .= "<a href='javascript:void(0);' data-rel='".$tipo[0]['slug']."' data-type='".$attributes['post_type']."'>".$tipo[0]['name']."</a>";
	                                        	$out .= "</li>";
                                        	}else {
                                        		foreach  ($tipo as $key => $subtipo) {
                                        			if ($key == 0) {
                                        				$out .= "<li class='dropdown-item filter-historico__item' >";
	                                            			$out .= "<a href='javascript:void(0);' data-rel='".$subtipo['slug']."' data-type='".$attributes['post_type']."' >".$subtipo['name']."</a>";
	                                        			$out .= "</li>";
	                                        			$out .= "<li role='separator' class='divider'></li>";
                                        			} else {
                                        				$out .= "<li class='dropdown-item dropdown-item__subtipo filter-historico__item' >";
	                                            			$out .= "<a href='javascript:void(0);' data-rel='".$subtipo['slug']."' data-type='".$attributes['post_type']."' key='$key'>".$subtipo['name']."</a>";
	                                        			$out .= "</li>";
                                        			}
	                                        	}
                                        	}
	                                    }
                                    $out .= "</ul>";
                                $out .= "</div>";
                            $out .= "</div>";
                            $out .= "<div class='col-md-5 col-xs-12'>";
                        		$out .= "<div class='filter-container search-input-container'>";
                        			$out .= "<input type='text' id='search-text__".$attributes['post_type']."' name='search-text-".$attributes['post_type']."' class='input search-text search-text__historico' data-rel='".$attributes['post_type']."' placeholder='Digite o que procura'></input>";
                        		$out .= "</div>";
                        	$out .= "</div>";
                        $out .= "</div>";
                    $out .= "</div>";
					$out .= "<div class='search-container search-container__".$attributes['post_type']."'>";
	                    $intra_query = new WP_Query( array('post_type' => ($attributes['post_type']), 'posts_per_page' => -1 ) );
	                    while ( $intra_query->have_posts() ) : $intra_query->the_post();
	                        $post_terms = wp_get_post_terms(get_the_ID(), ($attributes['tax']));
							$terms = array();
							foreach ($post_terms as $term) {
								$terms[] = $term->slug;
							}
							$out .= "<div class='row'>";
		                        $out .= "<div class='content-item ". join(' ', $terms) ." ano-".get_the_date('Y', get_the_ID())."'>";
									$out .= "<div class='col-xs-12'>";
			                            $out .= "<h4><a href='".get_permalink(get_the_ID())."'>";
			                                $out .= "<strong><i class='fa-calender fa'></i>" . get_the_date('d/m/Y') ."</strong> - ";
			                                $out .= "<span>" . get_the_title(get_the_ID()) ."</span>";
			                            $out .= "</a></h4>";
			                            $out .= "<p class='resumo'>";
			                                 $out .= wp_trim_words(get_field('resumo', get_the_ID()));
			                            $out .= "</p>";
									$out .= "</div>";
		                        $out .= "</div>";
							$out .= "</div>";
	                    endwhile;
	                    wp_reset_query();
					$out .= "</div>";
                $out .= "</div>";
            $out .= "</div>";
        $out .= "</div>";
		//$out = self::get_template_html('/assets/includes/templates/intranet-historico-lista', $attributes );
		return $out;
	}


    public function shortcode_cadastros ($atts,  $content = null) {
    	$out = "";

    	extract(
			shortcode_atts(
				array(
					'type' => null,
					'tax' => null,
					'title' => null,
					'id' => null,
        			'class' => null
				), $atts
			)
		);

		$url_ajax = admin_url('admin-ajax.php?action=download_planilha') . '&type='.$type;
		$url_download = wp_nonce_url($url_ajax, 'download_'.$type);

		$out .= "<div id='$id' class='$class cadastros-container accordion-element'>";
			$out .= "<div class='header-accordion row'>";
				$out .= "<h2 class='col-xs-12'>$title <a href='$url_download' data-action='gen-xls' class='btn-planilha'>Gerar Planilha</a> <i class='fa-accordion-icon fa'></i></h2>";
			$out .= "</div>";
			$out .= "<div class='content-accordion content-accordion__$type'>";
				$out .= "<div class='row'>";
					$out .= self::get_filter_cadastro($tax, $type);
				$out .= "</div>";
				$out .= "<div class='search-container search-container__$type'>";
					$return_query = new WP_Query(array('post_type' => $type, 'post_status' => 'publish', 'orderby' => "title", 'order' => 'ASC', 'posts_per_page' => -1));
					if ( $return_query->have_posts() ) :
						while ($return_query->have_posts()) : $return_query->the_post();

							$post_ID = get_the_ID();
							$title = get_the_title(get_the_ID());
							$prefix_field =  WP_Associados::get_prefix_field($type);
							$tipos = get_field('tipo_de_'.$prefix_field, get_the_ID());
							$current = array();
							if ($type == 'parques_tecnologicos') {
                                                        if (is_array($tipos) || is_object($tipos)) {foreach($tipos as $item) { /* Error Fix by CodePinch */
									$term = get_term((int)$item);
									$current[] = $term->slug;
                                                        }} /* Error Fix by CodePinch */
								//get_term();
                                                        } elseif ($type == 'empresas'){
								$tipos_sec = get_field('tipo_de_empresa_sec', get_the_ID());
								$itens = get_terms(array(
										'include' => array($tipos, $tipos_sec)
									)
								);
								foreach($itens as $item) {
									$term = get_term((int)$item);
									$current[] = $term->slug;
								}
								//get_term();
                                                        } elseif ($type == 'incubadoras') {
                                                        if (is_array($tipos) || is_object($tipos)) {foreach($tipos as $item) { /* Error Fix by CodePinch */
									$current[] = $item->slug;
                                                        }} /* Error Fix by CodePinch */
                                                        }
							$tipos = join(' ', $current);
							$out .= "<div class='row'>";
								$out .= "<div class='content-item $tipos'>";
									$out .= "<div class='content-item__thumb col-md-3'>";
										$img = WP_Associados::get_thumb_type($type, get_the_ID());
										$out .= "<img src='$img' alt='$title' />";
										$out .= "<div>";
											$out .= "<button class='btn-images' type='button' data-action='fancybox-ajax' data-post_id='$post_ID'><i></i>Ver Imagens</button>";
										$out .= "</div>";
									$out .= "</div>";
									$out .= "<div class='content-item__infor col-md-9'>";
										$out .= "<h4>$title</h4>";
										$out .= "<div class='row'>";
											$out .= "<div class='col-md-6 infor-item' >";
												$contatos = get_field($prefix_field ."_contatos", $post_ID);
												if ($contatos) :
													$out .= "<div class='infor-item__contato'>";
                                                                                                        if (is_array($contatos) || is_object($contatos)) {foreach($contatos as $item) { /* Error Fix by CodePinch */
															$contato_name = $item["contato_nome"];
															if ($contato_name) {
																$out .= "<p>$contato_name</p>";
															}
                                                                                                        }} /* Error Fix by CodePinch */
													$out .= "</div>";
												endif;
												$endereco = get_field($prefix_field ."_endereco", $post_ID);
												if ($endereco) :
													$out .= "<div class='infor-item__end'>";
														$out .= "<p>$endereco</p>";
													$out .= "</div>";
												endif;
											$out .= "</div>";
											$out .= "<div class='col-md-6 infor-item'>";
												$telefone = get_field($prefix_field ."_telefone", $post_ID);
												if ($telefone) :
													$out .= "<div class='infor-item__tel'>";
														$out .= "<p>$telefone</p>";
													$out .= "</div>";
												endif;
												$email = get_field($prefix_field ."_email", $post_ID);
												if ($email) :
													$out .= "<div class='infor-item__tel'>";
														$out .= "<p>$email</p>";
													$out .= "</div>";
												endif;
											$out .= "</div>";
										$out .= "</div>";
									$out .= "</div>";
									$out .= "<div class='col-md-12 content-item__border'></div>";
								$out .= "</div>";
							$out .= "</div>";
						endwhile;
					endif;
				$out .= "</div>";
				wp_reset_query();
				$out .= "<div class='row' style='display:none;' id='content-none'>";
					$out .= "<p class='col-md-12 content-none'>";
						$out .= "<button class=\"btn btn-lg\" disabled>". __("Nenhum resultado encontrado.") . "</button>";
					$out .= "</p>";
				$out .= "</div>";
			$out .= "</div>";
		$out .= "</div>";

		return $out;
    }

    public function shortcode_cadastros_projetos ($atts,  $content = null) {
    	$out = "";
    	extract(
			shortcode_atts(
				array(
					'type' => null,
					'tax' => null,
					'title' => null,
					'id' => null,
        			'class' => null
				), $atts
			)
		);
    	$out .= "<div class='btn-container col-xs-12'>";
    		$out .= "<a href='#modal-projetos' class='fancybox-modal btn-site'>Cadastrar Projeto</a>";
    	$out .= "</div>";
    	$out .= "<div class='hidden-container' style='display:none;'>";
	    	$out .= "<div id='modal-projetos' class='modal-fancybox-container'>";
	    		$out .= "<div class='header-modal'>";
                	$out .= "<h2>Cadastrar Projetos</h2>";
            	$out .= "</div>";
		        $out .= "<form class='form-container' id='cadastro_projetos' method='post' enctype='multipart/form-data'>";
		        	 $out .= "<div class='content-modal row'>";
				        $out .= "<div class='form-line-nonce' style='display: none;'>";
							$out .= wp_nonce_field( 'add_projeto', 'add_projeto_nonce', true, false );
							$out .= "<input type='hidden' name='security_nonce' value='".wp_create_nonce( "add_projeto_security_nonce" )."'>";
						$out .= "</div>";
						$out .= "<div class='col-xs-12'>";
				            $out .= "<input type='text' name='projeto_nome' class='input' placeholder='Nome do Projeto'>";
				        $out .= "</div>";
				        $out .= "<div class='col-xs-12'>";
				            $out .= "<textarea name='projeto_descricao' class='input' placeholder='Descição do Projeto'></textarea>";
				        $out .= "</div>";
				        $out .= "<div class='col-xs-12'>";
				            $out .= "<input type='url' name='projeto_link' class='input' placeholder='Link para o Google Doc'>";
				        $out .= "</div>";
				        $out .= "<div class='col-xs-12'>";
		                    $out .= "<button type='submit' class='btn-site'>Enviar</button>";
		                $out .= "</div>";
		            $out .= "</div>";
			    $out .= "</form>";
			$out .= "</div>";
		$out .= "</div>";
		return $out;
    }

    public function shortcode_link_content ($atts,  $content = null) {
    	$out = "";
    	$out .= "<div class='link-content'>";
    		$out .=  "<a href='$content' target='_blank' class='btn-site'><i class='fa fa-driver'></i><span>acessar documento do projeto</span></a>";
    	$out .= "</div>";
    	return $out;
    }


    public function shortcode_listar_projetos ($atts,  $content = null) {
		$type = 'custom_projetos';
    	$out = "";
    	$out .= "<div class='projetos-container col-xs-12'>";
    		$out .= "<div class='accordion-element'>";
    			 $out .= "<div class='header-accordion row'>";
                    $out .= "<h2 class='col-xs-12'>" . __('Projetos', 'natio-lang') . "<i class='fa-accordion-icon fa'></i></h2>";
                $out .= "</div>";
    			$out .= "<div class='content-accordion content-accordion__projetos'>";
	    			$out .= "<div class='row'>";
	                        $out .= "<div class='filter'>";
	                            $out .= "<div class='col-md-2 col-xs-4'>";
	                                $out .= "<div class='filter-container dropdown'>";
	                                    $out .= "<div class='input-container projeto_tipo' data-toggle='dropdown'>";
	                                        $out .= "<input type='text' name='projeto_ano' class='input' placeholder='Ano' readonly>";
	                                    $out .= "</div>";
										$out .= "<ul class='dropdown-menu dropdown-year'>";
	                                        $out .= "<li class='dropdown-item filter-historico__item'>";
	                                            $out .= "<a href='javascript:void(0);' data-year='all'  rel='" . $type  ."'>Todos</a>";
	                                        $out .= "</li>";
											$anos = WP_Associados::get_posts_year($type);
											foreach ($anos as $ano) {
												$out .= "<li class='dropdown-item filter-historico__item'>";
		                                            $out .= "<a href='javascript:void(0);' data-year='$ano' rel='" . $type  ."'>$ano</a>";
		                                        $out .= "</li>";
											}
	                                    $out .= "</ul>";
	                                $out .= "</div>";
	                            $out .= "</div>";
	                            $out .= "<div class='col-md-10 col-xs-8'>";
	                        		$out .= "<div class='filter-container search-input-container'>";
										$out .= "<input type='text' id='search-text__".$type."' name='search-text-".$type."' class='input search-text search-text__historico' data-rel='".$type."' placeholder='Digite o que procura'></input>";
	                        		$out .= "</div>";
	                        	$out .= "</div>";
	                        $out .= "</div>";
	                    $out .= "</div>";
	    			$out .= "<div id='projetos-lista'>";
		    			$projetos = new WP_Query( array('post_type' => 'custom_projetos', 'posts_per_page' => -1 ) );
		    			while ( $projetos->have_posts() ) : $projetos->the_post();
		    				$out .= "<div class='content-item year-".  get_the_date('Y') ."'>";
		    					$out .= "<h4>";
	                                $out .= "<span><i class='fa-calender fa'></i>" . get_the_date('d/m/Y') ."</span>";
	                                $out .= " - <span>" . get_the_title(get_the_ID()) ."</span>";
	                            $out .= "</h4>";
	                            $out .= "<div class='resumo'>";
	                                $out .= do_shortcode(get_the_content());
									$out .= '<p>';
										$out .= do_shortcode('[link]'.get_field('link', get_the_ID() ).'[/link]');
									$out .= '</p>';
	                            $out .= "</div>";
		    				$out .= "</div>";
		    			endwhile;
		                wp_reset_query();
	    			$out .= "</div>";
				$out .= "</div>";
    		$out .= "</div>";
    	$out .= "</div>";
    	return $out;
    }
 }

$wp_intranet = new WP_Intranet();
