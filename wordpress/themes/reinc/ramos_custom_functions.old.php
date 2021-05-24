<?php
/**
 * Máximo de resultados por paginação do WP REST API
 */


$maxPageRestAPI = 20;
/**
 * Monta o menu de associados com base em variáveis
 * @author Henrique Ramos <hramos@live.de>
 * @param $taxonomy string Qual é o term slug que será requisitado?
 * @param $args	array[] Matriz com variáveis para o funcionamento do sistema
 */

function buildAssociatesMenu($taxonomy=false, $args=array()){
	/**
	 * Check if taxonomy is empty
	 */
	if(empty($taxonomy) OR !isset($taxonomy)){
		throw new Exception("Fill the \$taxonomy variable.");
	}
	/**
	* Check if taxonomy exists
	*/
	if(!taxonomy_exists($taxonomy)){
		throw new Exception("Fill the \$taxonomy variable with an existent taxonomy.");
	}

	/**
	 * Default variables
	 */

	$defaults = array(
		'hide_empty' => TRUE,
		'show_all_button' => TRUE
	);

	/**
	 * @link https://codex.wordpress.org/Function_Reference/wp_parse_args
	 */
	$args = wp_parse_args($args, $defaults);

	extract($args, EXTR_PREFIX_ALL, "buildAssociate");

	$getTerms = get_terms($taxonomy, array('hide_empty' => $buildAssociate_hide_empty));
	$outputArray = array();

	if($buildAssociate_show_all_button == true){
		$outputArray[0]["term_id"] = 0;
		$outputArray[0]["name"] = __("Todas");
		$outputArray[0]["slug"] = 'all';
		$outputArray[0]["link"] = getPermalinkForTaxonomy($taxonomy);
	}

	$term_key=1;

	foreach($getTerms AS $term_obj){
		$outputArray[$term_key]["term_id"] = $term_obj->term_id;
		$outputArray[$term_key]["name"] = $term_obj->name;
		$outputArray[$term_key]["slug"] = $term_obj->slug;
		$outputArray[$term_key]["link"] = get_term_link($term_obj, $taxonomy);
		$term_key++;
	}

	return $outputArray;
}



function getPermalinkForTaxonomy($taxonomy=false){

	global $wp_rewrite;

	/**
	 * Check if taxonomy is empty
	 */
	if(empty($taxonomy) OR !isset($taxonomy)){
		throw new Exception("Fill the \$taxonomy variable.");
	}


	/**
	 * Check if taxonomy exists
	 */
	if(!taxonomy_exists($taxonomy)){
		throw new Exception("Fill the \$taxonomy variable with an existent taxonomy.");
	}



	$t = get_taxonomy($taxonomy);
	$p = get_post_type_object($t->object_type{0});

	$termlink = $wp_rewrite->get_extra_permastruct($taxonomy);
	if ( empty($termlink) ) {
		$termlink = home_url("?{$taxonomy}");
	} else {
		$termlink = sprintf("/%s%s", $p->rewrite['slug'], $termlink);
		$termlink = home_url(user_trailingslashit(str_replace("%{$taxonomy}%", "", $termlink), 'category') );
	}

	return $termlink;
}



/**
 * WP Rest API
 *
 */

add_action( 'rest_api_init', 'incubadora_info' );

function incubadora_info() {

    register_rest_field('incubadoras',
        'logotipo',
        array(
            'get_callback'    => 'get_logotipo_associado' ,
        )
    );
	register_rest_field('parques_tecnologicos',
        'logotipo',
        array(
            'get_callback'    => 'get_logotipo_associado' ,
        )
    );
	register_rest_field('empresas',
        'logotipo',
        array(
            'get_callback'    => 'get_logotipo_associado' ,
        )
    );
	register_rest_field('incubadoras',
        'logotipo_hover',
        array(
            'get_callback'    => 'get_logotipo_associado_hover' ,
        )
    );
	register_rest_field('parques_tecnologicos',
        'logotipo_hover',
        array(
            'get_callback'    => 'get_logotipo_associado_hover' ,
        )
    );
	register_rest_field('empresas',
        'logotipo_hover',
        array(
            'get_callback'    => 'get_logotipo_associado_hover' ,
        )
    );
	register_rest_field('incubadoras',
		'contatos',
		array(
			'get_callback' => 'get_contatos_associado',
		)
	);

	register_rest_field('parques_tecnologicos',
		'contatos',
		array(
			'get_callback' => 'get_contatos_associado',
		)
	);

	register_rest_field('empresas',
		'contatos',
		array(
			'get_callback' => 'get_contatos_associado',
		)
	);

	register_rest_field('incubadoras',
		'telefone',
		array(
			'get_callback' => 'get_telefone_associado',
		)
	);

	register_rest_field('parques_tecnologicos',
		'telefone',
		array(
			'get_callback' => 'get_telefone_associado',
		)
	);

	register_rest_field('empresas',
		'telefone',
		array(
			'get_callback' => 'get_telefone_associado',
		)
	);

	register_rest_field('incubadoras',
		'email',
		array(
			'get_callback' => 'get_email_associado',
		)
	);

	register_rest_field('parques_tecnologicos',
		'email',
		array(
			'get_callback' => 'get_email_associado',
		)
	);

	register_rest_field('empresas',
		'email',
		array(
			'get_callback' => 'get_email_associado',
		)
	);

	register_rest_field('incubadoras',
		'endereco',
		array(
			'get_callback' => 'get_endereco_associado',
		)
	);

	register_rest_field('parques_tecnologicos',
		'endereco',
		array(
			'get_callback' => 'get_endereco_associado',
		)
	);

	register_rest_field('empresas',
		'endereco',
		array(
			'get_callback' => 'get_endereco_associado',
		)
	);

	register_rest_field('incubadoras',
		'geolocation',
		array(
			'get_callback' => 'get_geolocation',
		)
	);

	register_rest_field('parques_tecnologicos',
		'geolocation',
		array(
			'get_callback' => 'get_geolocation',
		)
	);

	register_rest_field('empresas',
		'geolocation',
		array(
			'get_callback' => 'get_geolocation',
		)
	);

	register_rest_field('incubadoras',
		'site',
		array(
			'get_callback' => 'get_site_associado',
		)
	);

	register_rest_field('parques_tecnologicos',
		'site',
		array(
			'get_callback' => 'get_site_associado',
		)
	);

	register_rest_field('empresas',
		'site',
		array(
			'get_callback' => 'get_site_associado',
		)
	);

	register_rest_field('empresas', 'incubadora',
		array(
			'get_callback' => 'get_incubadora_empresa',
		)
	);

}

/**
 *
 */

function get_logotipo_associado($post, $field_name="", $request="") {

	switch($post['type']){
		case 'incubadoras': $field_name = "incubadora_logotipo"; break;
		case 'parques_tecnologicos': $field_name = "parque_tecnologico_logotipo"; break;
		case 'empresas': $field_name = "empresa_logotipo"; break;

		default: throw new Exception("This function can be use with only \"incubadoras\", \"parques_tecnologicos\" or \"empresas\" custom post types. {$post['type']}"); break;

	}

	$logotipo_associado = get_field($field_name, $post['id']);
	if($logotipo_associado){
		$outputArray = array();
		foreach($logotipo_associado['sizes'] AS $logotipoKey=>$logotipoValue){
			if($logotipoKey=="thumbnail" OR $logotipoKey=="medium" OR $logotipoKey=="large"){
				$outputArray[$logotipoKey] = $logotipoValue;
			}
		}
		return (!empty($outputArray))?$outputArray:false;
	}
	return false;
}



function get_logotipo_associado_hover($post, $field_name="", $request="") {
	switch($post['type']){
		case 'incubadoras': $field_name = "incubadora_logotipo_hover"; break;
		case 'parques_tecnologicos': $field_name = "parque_tecnologico_logotipo_hover"; break;
		case 'empresas': $field_name = "empresa_logotipo_hover"; break;
		default: throw new Exception("This function can be use with only \"incubadoras\", \"parques_tecnologicos\" or \"empresas\" custom post types."); break;
	}
	$logotipo_associado = get_field($field_name, $post['id']);

	if($logotipo_associado){
		$outputArray = array();
		foreach($logotipo_associado['sizes'] AS $logotipoKey=>$logotipoValue){
			if($logotipoKey=="thumbnail" OR $logotipoKey=="medium" OR $logotipoKey=="large"){
				$outputArray[$logotipoKey] = $logotipoValue;
			}
		}
		return (!empty($outputArray))?$outputArray:false;
	}
	return false;
}



function get_contatos_associado($post, $field_name="", $request="") {

	switch($post['type']){

		case 'incubadoras': $field_name = "incubadora_contatos"; break;
		case 'parques_tecnologicos': $field_name = "parque_tecnologico_contatos"; break;
		case 'empresas': $field_name = "empresa_contatos"; break;
		default: throw new Exception("This function can be use with only \"incubadoras\", \"parques_tecnologicos\" or \"empresas\" custom post types."); break;

	}

	$contatos_associado = get_field($field_name, $post['id'])?get_field($field_name, $post['id']):array();

	$exportedContatos = array();

	$i=0;

	foreach($contatos_associado AS $arraySingleContato){

		if(!empty($arraySingleContato['contato_cargo'])){
			$exportedContatos[$i]['cargo'] = $arraySingleContato["contato_cargo"];
		}

		if(!empty($arraySingleContato['contato_nome'])){
			$exportedContatos[$i]['nome'] = $arraySingleContato["contato_nome"];
		}

		$i++;
	}

	return $exportedContatos;

}



function get_telefone_associado($post, $field_name="", $request="") {

	switch($post['type']){

		case 'incubadoras': $field_name = "incubadora_telefone"; break;
		case 'parques_tecnologicos': $field_name = "parque_tecnologico_telefone"; break;
		case 'empresas': $field_name = "empres_telefone"; break;
		default: throw new Exception("This function can be use with only \"incubadoras\", \"parques_tecnologicos\" or \"empresas\" custom post types."); break;

	}
	return get_field($field_name, $post['id']);
}



function get_email_associado($post, $field_name="", $request="") {

	switch($post['type']){

		case 'incubadoras': $field_name = "incubadora_email"; break;
		case 'parques_tecnologicos': $field_name = "parque_tecnologico_email"; break;
		case 'empresas': $field_name = "empresa_email"; break;
		default: throw new Exception("This function can be use with only \"incubadoras\", \"parques_tecnologicos\" or \"empresas\" custom post types."); break;

	}

	return get_field($field_name, $post['id']);

}



function get_endereco_associado($post, $field_name="", $request="") {

	switch($post['type']){

		case 'incubadoras': $field_name = "incubadora_endereco"; break;
		case 'parques_tecnologicos': $field_name = "parque_tecnologico_endereco"; break;
		case 'empresas': $field_name = "empresa_endereco"; break;
		default: throw new Exception("This function can be use with only \"incubadoras\", \"parques_tecnologicos\" or \"empresas\" custom post types."); break;

	}

	return get_field($field_name, $post['id']);

}



function get_site_associado($post, $field_name="", $request="") {
	switch($post['type']){
		case 'incubadoras': $field_name = "incubadora_site"; break;
		case 'parques_tecnologicos': $field_name = "parque_tecnologico_site"; break;
		case 'empresas': $field_name = "empresa_site"; break;
		default: throw new Exception("This function can be use with only \"incubadoras\", \"parques_tecnologicos\" or \"empresas\" custom post types."); break;

	}
	return get_field($field_name, $post['id']);
}



function get_incubadora_empresa($post, $field_name="", $request=""){
	$relation = null;
	if (get_field("empresa_incubadora", $post['id'])) {
		$inc = get_field("empresa_incubadora", $post['id']);
		$relation = (int) ($inc[0]);
	} elseif (get_field("empresa_parque", $post['id']))  {
		$parq = get_field("empresa_parque", $post['id']);
		$relation = (int) ($parq[0]);
	}
	return $relation;
}

function get_geolocation($post, $field_name="", $request=""){
	return get_field("mapa_coordenadas", $post['id']);
}


function get_type($post, $field_name="", $request=""){
	$type = '';
	if (get_field('empresa_incubadora', $post['id'])) :
		$types = 'Incubadoras';
	endif;
	if (get_field('empresa_parque', $post['id'])) :
		$types = 'Parques Tecnológicos';
	endif;
	return $types;
}




/**
 * Removing content for some endpoints
 */

add_filter('rest_prepare_incubadoras', 'removeContentFromREST', 10, 3);
add_filter('rest_prepare_parques_tecnologicos', 'removeContentFromREST', 10, 3);
add_filter('rest_prepare_empresas', 'removeContentFromREST', 10, 3);

function removeContentFromREST($request){

	unset($request->data["guid"]);
	unset($request->data["status"]);
	unset($request->data["excerpt"]);
	unset($request->data["author"]);
	unset($request->data["content"]);
	unset($request->data["parent"]);
	unset($request->data["date"]);
	unset($request->data["modified"]);
	unset($request->data["format"]);
	unset($request->data["menu_order"]);
	unset($request->data["comment_status"]);
	unset($request->data["ping_status"]);
	unset($request->data["sticky"]);
	unset($request->data["date_tz"]);
	unset($request->data["date_gmt"]);
	unset($request->data["modified_tz"]);
	unset($request->data["modified_gmt"]);
	unset($request->data["meta"]);
	unset($request->data["tipo_incubadora"]);

	return $request;
}

/**
 * Get count of status empresa
 */
function getEmpresasStatus($tipo="pre-incubadas", $incubadora=false) {
	$searchByIncubadora = array();
	if(!empty($incubadora)){
		$searchByIncubadora = array("meta_query"=>array(array("key"=>"empresa_incubadora", "value"=>$incubadora, "compare"=>"LIKE")));
	}
    //return $count;
    $args = array(
      'post_type'     => 'empresas',
      'post_status'   => 'publish',
      'posts_per_page' => -1,
      'tax_query' => array(
        'relation' => 'AND',
        array(
          'taxonomy' => 'empresa_status',
          'field' => 'slug',
          'terms' => $tipo
        )
      )
    );

    $query = new WP_Query(array_merge($args, $searchByIncubadora));

    return (int)$query->post_count;
}



function my_rest_post_query( $args, $request ) {

	if ( isset( $request['filter'] ) && isset( $request['filter']['posts_per_page'] ) && ! empty( $request['filter']['posts_per_page'] ) ) {

		if ( $request['filter']['posts_per_page'] > 0 ) {
			$request['per_page'] = $request['filter']['posts_per_page'];
		} else {
			$count_query = new WP_Query();
			unset( $query_args['paged'] );
			$query_result = $count_query->query( $query_args );
			$total_posts = $query_result->found_posts;
			$request['per_page'] = $total_posts;
		}
	}

	return $args;

}

add_filter('rest_post_query', 'my_rest_post_query', 10, 2 );



add_filter('rest_query_vars', 'reincGetQuery');

function reincGetQuery($valid_vars){
	$valid_vars = array_merge($valid_vars, array('meta_key', 'meta_value', 'meta_compare'));
	return $valid_vars;
}

/**
 * Custom Footer with Javascript for Associados Page
 */

function reincCustomFooterAssociadosCode() {
	global $maxPageRestAPI;
?>
<script type="application/javascript">

	var xhr; //Variable to hold the ajax request
	var currentPostType = []; //Variable to hold the current CPT kind
	var currentTermsToFilter = []; // ARray to current filter
	var activeIncubadoras = [], activeParques = [], activeEmpresas = [];
	var controllMapa = false;

	/*
	* função para verificar se uma variavel está vazia
	* @param str : vairavel que será verificada
	* @return TRUE: se variavel for vazia
	*/
	function isEmpty(str) {
		return typeof str == 'string' && !str.trim() || typeof str == 'undefined' || str === null;
	}



	function generateResultGrid(type, paged, terms, removeTerm, moreContent){

		if (typeof type === 'undefined')
			return false;

		var postsPerPage = "<?php echo !empty($maxPageRestAPI)?$maxPageRestAPI:"5"; ?>";
		var paged = (isNaN(paged) || paged==0) ? 1 : paged;
		var removeTerm = (typeof removeTerm !== 'undefined') ? removeTerm : false;
		var moreContent = (typeof removeTerm !== 'undefined') ? moreContent : false;

		if (xhr)
			xhr.abort();

		if(currentPostType != type){
			currentPostType=type;
			currentTermsToFilter=[];
			jQuery("#associate_results").empty();
		}

		if(typeof terms !== 'undefined'){
			if(removeTerm==true){
				currentTermsToFilter = jQuery.grep(currentTermsToFilter, function(value) {
					return value != terms;
			});
		}else{
				if(!isEmpty(terms)){
					currentTermsToFilter.push(jQuery.trim(terms));
				}
			}
		}

		currentTermsToFilter = currentTermsToFilter.filter(function(v){return v!==''});
		currentPostType = type;
		if(currentTermsToFilter.length == 0){
			currentPostType = [];
		}



		console.log("current post type "+ currentPostType);
		console.log("current terms to filter "+currentTermsToFilter);
		console.log("current terms to filter length "+currentTermsToFilter.length);

		jQuery("#associate_loading").show();

		xhr = jQuery.getJSON("<?php echo esc_url( home_url( '/wp-json/reinc-api/v1/associados' ) );  ?>",
			{
				"types": currentPostType,
				"filter": {
					"terms": currentTermsToFilter,
					"paged": paged,
					"posts_per_page": postsPerPage
				}
			});
		xhr.done(function(data){
			//console.log(data);
			jQuery(".associates_not_found").remove();
			if(currentTermsToFilter.length == 0){
				jQuery("#associate_results").html('');
				jQuery("#associate_results").append("<div class=\"col-xs-12 col-sm-12 col-md-12 associates_not_found\"><button class=\"btn btn-lg\" disabled><span class=\"fa fa-close\"></span> <?php echo __("Nenhum resultado encontrado."); ?></button></div>");
				jQuery(".requestMoreAssociate").hide();
				jQuery("#associate_loading").hide();
				return false;
			}
			if(isEmpty(data.posts)){
				jQuery("#associate_results").append("<div class=\"col-xs-12 col-sm-12 col-md-12 associates_not_found\"><button class=\"btn btn-lg\" disabled><span class=\"fa fa-close\"></span> <?php echo __("Nenhum resultado encontrado."); ?></button></div>");
				jQuery(".requestMoreAssociate").hide();
				jQuery("#associate_loading").hide();
				return false;
			}
			if(moreContent!=true){
				jQuery("#associate_results").empty();
			}

			/**
			 * Cleaning HTML target div
			 */
			jQuery.each(data.posts, function(index, post){
				if(post.logotipo.thumbnail){
					var frontContent = "<img src=\""+post.logotipo.thumbnail+"\" alt=\""+post.title+"\">";
				}else{
					// Alteração feita por Lucas Ramos
					// set thumb default is not thumb
					//var frontContent = "<h3 class=\"hover-title-associate\">"+post.title+"</h3>"; // linha original
					var frontContent = "<img src=\"<?php echo get_bloginfo('template_url') . '/assets/img/thumb-default-150.png';  ?>\" alt=\""+post.title+"\">";
				}
				jQuery("#associate_results").append(""+
				"<div class=\"associate_item col-xs-3 col-sm-3 col-md-3\">"+
					"<div class=\"item-container "+post.type +" \" ontouchstart=\"this.classList.toggle('hover');\">"+
						"<a class=\"link\" href=\""+post.link+"\">"+
							frontContent +
							"<h3 class=\"h3\">"+post.title+"</h3>"+
						"</a>"+
					"</div>"+
				"</div>"+
				"");
			});

			if(data.pagination.hasMore){
				jQuery("#associate_pagination").empty().append("<div class=\"col-xs-12 col-sm-12 col-md-12\"><button type=\"button\" class=\"btn btn-default btn-lg requestMoreAssociate\" data-associate_type=\""+type+"\" data-associate_category=\""+terms+"\" data-paged=\""+data.pagination.next+"\">Carregar mais resultados</button></div>");
			}else{
				jQuery(".requestMoreAssociate").hide();
			}
		});
		jQuery("#associate_loading").hide();
	}

jQuery(document).ready(function(){

	generateResultGrid(["Incubadoras"], 0, "all");
	$('#incubadora_subitens').find('li:first-of-type').addClass('in');

	activeIncubadoras.push('all');

	jQuery("body").on("shown.bs.collapse", "#empresa_subitens, #parque_subitens, #incubadora_subitens", function(event){
		jQuery(".collapse-in").removeClass("collapse-in");
		jQuery(this).closest(".associate_type").addClass("collapse-in");
		jQuery(this).closest(".associate_type").find(".retractileIcon i").removeClass("fa-plus-circle").addClass("fa-minus-circle");
		jQuery(".associate_type").not(".collapse-in").find(".in").removeClass("in");
	}).on("hidden.bs.collapse", '#empresa_subitens, #parque_subitens, #incubadora_subitens', function (event) {
		jQuery(".collapse-in").removeClass("collapse-in");
		jQuery(this).closest(".associate_type").removeClass("collapse-in");
		jQuery(this).closest(".associate_type").find(".retractileIcon > i").removeClass("fa-minus-circle").addClass("fa-plus-circle");
	});

	jQuery("body").on("click", ".requestMoreAssociate", function(event){
		event.preventDefault();
		var associate_type = jQuery(this).data('associate_type');
		var associate_category = jQuery(this).data('associate_category');
		var paged_associate = (isNaN(jQuery(this).data('paged')))?0:jQuery(this).data('paged');

		generateResultGrid(associate_type, paged_associate, false, false, true);

	});

	// Variaveis para Fazer a Cascata no filtro;
	var associate_type, associate_category;

	jQuery("body").on("click", ".requestAssociate", function(event){
		event.preventDefault();

		var paged_associate = (isNaN(jQuery(this).data('paged')))?0:jQuery(this).data('paged');
		var paged=(isNaN(paged) || paged==0)?1:paged;
		var removeTerm=false;
		var associate_type = jQuery(this).data('associate_type');
		var associate_category = jQuery(this).data('associate_category');

		if ( associate_category.length == 0 ) {
			associate_category = 'all';
			removeTerm = true;
		}

		if(currentPostType != associate_type){
			jQuery(".requestAssociate").closest("li").removeClass("in");
		}


		//switch_type(associate_type, associate_category);

		//associate_type = toggle_type(associate_type, associate_category);

		if(jQuery(this).closest("li").hasClass("in")){
			jQuery(this).closest("li").removeClass("in");
			removeTerm = true;
		}else{
			jQuery(this).closest("li").addClass("in");
		}

		generateResultGrid(associate_type, paged_associate, associate_category, removeTerm);
	});

});

var switch_type = function (type, term) {

	var itemIndex;

	if (type == 'Incubadoras') {
		itemIndex = activeIncubadoras.indexOf(term);
		if (itemIndex == -1) { // Não Existe
			activeIncubadoras.push(term);
		} else {
			activeIncubadoras = activeIncubadoras.filter(function(value) {
				return value != term;
			});
		}
	} else if (type == 'Parques') {
		itemIndex = activeParques.indexOf(term);
		if (itemIndex == -1) {
			activeParques.push(term);
		} else {
			activeParques = activeParques.filter(function(value) {
				return value != term
			});
		}
	} else if (type == 'Empresas') {
		itemIndex = activeEmpresas.indexOf(term);
			activeEmpresas.push(term);
		} else {
			if (itemIndex == -1) {
			activeEmpresas = activeEmpresas.filter(function(value) {
				return value != term
			});
		}
	}
}

var toggle_type = function (type, arrayCat) {
	var itemIndex;
	itemIndex = currentPostType.indexOf(type);
	if (itemIndex == -1) {
		currentPostType.push(type);
	} else {
		if (arrayCat.length == 0 ) {
			currentPostType = currentPostType.filter(function(i) {
				return i != type
			});
		}
	}
	return currentPostType;
}

</script>

<?php

}



/**
 * Count Empresas' by certain status taxonomy
 */

function countEmpresasByStatus($value=false){

	if(empty($value)) return false;
 	//return $count;
    $args = array(
      'post_type'     => 'empresas', //post type, I used 'product'
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



//Making jQuery Google API

function ramos_modify_jquery() {
	if (!is_admin()) {
		// comment out the next two lines to load the local copy of jQuery
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'https://code.jquery.com/jquery-2.2.1.min.js', false, '2.2.1');
		wp_enqueue_script('jquery');

	}
}

add_action('init', 'ramos_modify_jquery');



add_action( 'rest_api_init', 'customEndPointReINC' );



function customEndPointReINC(){
	register_rest_route( "reinc-api/v1", '/associados', array(
		'methods'         => \WP_REST_Server::READABLE,
		'callback'        => 'get_associados',
		'args'            => array(
			'filter'=> array(
				'posts_per_page' => array(
					'default' => 10,
					'sanitize_callback' => 'absint',
				),
				'paged' => array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				),
				'orderby' => array(
					'default' => 'title',
				),
				'order' => array(
					'default' => 'asc',
				),
				'terms' => array(
					'default' => array()
				)
			),
			'types' => array(
				'default' => array('incubadoras'),
			),
		)
	)
);



	register_rest_route( "reinc-api/v1", '/get_empresas_per_incubadora', array(
		'methods'         => \WP_REST_Server::READABLE,
		'callback'        => 'get_empresas_by_inc',
		'args'            => array(
			'filter'=> array(
				'posts_per_page' => array(
					'default' => 10,
					'sanitize_callback' => 'absint',
				),
				'paged' => array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				),
				'orderby' => array(
					'default' => 'title',
				),
				'order' => array(
					'default' => 'ASC',
				),
				'terms' => array(
					'default' => array()
				)
			),
			'inc_id' => array(
				'default' => ''
			)
		)
	)
);



	register_rest_route( "reinc-api/v1", '/get_empresas_per_parque', array(

		'methods'         => \WP_REST_Server::READABLE,
		'callback'        => 'get_empresas_by_parq',
		'args'            => array(
			'filter'=> array(
				'posts_per_page' => array(
					'default' => 10,
					'sanitize_callback' => 'absint',
				),
				'paged' => array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				),
				'orderby' => array(
					'default' => 'title',
				),
				'order' => array(
					'default' => 'ASC',
				),
				'terms' => array(
					'default' => array()
				)
			),
			'parq_id' => array(
				'default' => ''
			),
		)

	)

	);



}



function get_associados($request_data){
	global $wpdb, $maxPageRestAPI;

	$data = $request_data->get_params();
	$searchByCPT = array();
	$tax_query = array();
	$postTypes = !is_array($data['types'])?array($data['types']):$data['types'];

	foreach($postTypes AS $tipoCustomPost){
		$tipoCustomPost = strtolower($tipoCustomPost);
		switch($tipoCustomPost){
			case 'incubadoras':
				$searchByCPT[] = "incubadoras";
				if(!empty($data['filter']['terms'])){
					foreach($data['filter']['terms'] AS $singleTerm){
						if($singleTerm=="all"){
							$tax_query = NULL;
							break;
						}
						if(!empty($singleTerm) AND $singleTerm!="all"){
							if(is_null(filter_var($singleTerm, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))){
								$tax_query[] = array("taxonomy"=>"tipo_incubadora","terms"=>(array)$singleTerm, "field"=>"slug");
							}
						}
					}
				}
			break;
			case 'parques':
				$searchByCPT[] = "parques_tecnologicos";
				if(!empty($data['filter']['terms'])){
					foreach($data['filter']['terms'] AS $singleTerm){
						if($singleTerm=="all"){
							$tax_query = NULL;
							break;
						}
						if(!empty($singleTerm) AND $singleTerm!="all"){
							if(is_null(filter_var($singleTerm, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))){
								$tax_query[] = array("taxonomy"=>"tipo_parques","terms"=>(array)$singleTerm, "field"=>"slug");
							}
						}
					}
				}
			break;
			case 'empresas':
				$searchByCPT[] = "empresas";
				if(!empty($data['filter']['terms'])){
					foreach($data['filter']['terms'] AS $singleTerm){
						if($singleTerm=="all"){
							$tax_query = NULL;
							break;
						}
						if(!empty($singleTerm) AND $singleTerm!="all"){
							if(is_null(filter_var($singleTerm, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))){
								$tax_query[] = array("taxonomy"=>"tipo_empresas","terms"=>$singleTerm, "field"=>"slug");
							}
						}
					}
				}
			break;
		}
	}
	$args = array(
		'post_type' => $searchByCPT,
		'post_status' => 'publish',
		'posts_per_page' => (empty($data['filter']['posts_per_page'])?$maxPageRestAPI:$data['filter']['posts_per_page']),
		'paged' => $data['filter']['paged'],
		'orderby' => "title", #(empty($data['filter']['orderby'])?"ASC":$data['filter']['orderby']),
		'order' => "ASC", #(empty($data['filter']['order'])?"title":$data['filter']['order']),
	);

	if(count($tax_query)>0) $args['tax_query']= $tax_query;
	if(count($tax_query)>1) $args['tax_query']['relation'] = 'OR';

	$customQuery = null;
	$customQuery = new WP_Query($args);

	if($customQuery->have_posts()){
		$outputCustom = array();
		while ($customQuery->have_posts()){
			$customQuery->the_post();
			$postId = get_the_ID();
			$postType = get_post_type($postId);
			$arrayPost = array('id'=>$postId, 'type'=>$postType);

			$outputCustom['posts'][] = array(
				'id'=>$postId,
				'type'=>$postType,
				'link'=>get_the_permalink(),
				'title'=>get_the_title(),
				'logotipo'=>get_logotipo_associado($arrayPost),
				'contatos'=>get_contatos_associado($arrayPost),
				'telefones'=>get_telefone_associado($arrayPost),
				'email' => get_email_associado($arrayPost),
				'endereco' => get_endereco_associado($arrayPost),
				'geolocation' => get_geolocation($arrayPost),
				'site' => get_site_associado($arrayPost),
				'relation'=>get_incubadora_empresa($arrayPost),
				'relation_title'=>get_the_title(get_incubadora_empresa($arrayPost)),
				'relation_title_slug'=>sanitize_title(get_the_title(get_incubadora_empresa($arrayPost))),
				'relation_type'=>get_type($arrayPost),
				'relation_type_slug'=>sanitize_title(get_type($arrayPost))
			);
		}

		$nextPage = ($data["filter"]['paged']+1)<=$customQuery->max_num_pages?($data["filter"]['paged']+1):"";
		$hasMore = !empty($nextPage)?true:false;
		$prevPage = (ceil(abs($data["filter"]['paged']-1))<=0)?1:ceil(abs($data["filter"]['paged']-1));
		$outputCustom["pagination"] = array('total'=>$customQuery->max_num_pages, 'next'=>$nextPage, 'prev' => $prevPage, 'current'=>$data["filter"]['paged'], 'hasMore'=>$hasMore);

		wp_send_json($outputCustom);
	}
	wp_reset_query();
	wp_send_json(array('posts'=>null, 'pagination'=>null));
}

function get_empresas_by_inc($request_data){
	global $wpdb, $maxPageRestAPI;

	$data = $request_data->get_params();
	$searchByCPT = "empresas";
	$tax_query = array();
	$meta_query = array();

	if (empty($data['inc_id'])){
		wp_send_json(array(
			'error'=>_('Fill the INC_ID parameter'),
			'posts'=>null,
			'pagination'=>null
		));
	}

	$meta_query[] = array(
		"key"=>"empresa_incubadora",
		"value"=>$data['inc_id'],
		"compare"=>"LIKE"
	);

	if(!empty($data['filter']['terms'])){
		if(!in_array("all", $data['filter']['terms'])){
			$tax_query[] = array("taxonomy"=>"empresa_status","terms"=>(array)$data['filter']['terms'], "field"=>"slug", "operator"=>"IN");
		}
	}

	$args = array(
		'post_type' => $searchByCPT,
		'post_status' => 'publish',
		'posts_per_page' => (empty($data['filter']['posts_per_page'])?$maxPageRestAPI:$data['filter']['posts_per_page']),
		'paged' => $data['filter']['paged'],
		'orderby' => "title", #(empty($data['filter']['orderby'])?"ASC":$data['filter']['orderby']),
		'order' => "ASC", #(empty($data['filter']['order'])?"title":$data['filter']['order']),
	);

	if(count($tax_query)>1) $args['tax_query']['relation'] = 'OR';
	if(count($tax_query)>0) $args['tax_query']= $tax_query;

	$args['meta_query'] = $meta_query;
	$customQuery = null;
	$customQuery = new WP_Query($args);

	if($customQuery->have_posts()){
		$outputCustom = array();
		while ($customQuery->have_posts()) {
			$customQuery->the_post();
			$postId = get_the_ID();
			$postType = get_post_type($postId);
			$arrayPost = array('id'=>$postId, 'type'=>$postType);
			$outputCustom['posts'][] = array(
				'id'=>$postId,
				'type'=>$postType,
				'link'=>get_the_permalink(),
				'title'=>get_the_title(),
				'logotipo'=>get_logotipo_associado($arrayPost),
				'contatos'=>get_contatos_associado($arrayPost),
				'telefones'=>get_telefone_associado($arrayPost),
				'email' => get_email_associado($arrayPost),
				'endereco' => get_endereco_associado($arrayPost),
				'site' => get_site_associado($arrayPost),
				'incubadora_rel'=>get_incubadora_empresa($arrayPost),
				'incubadora_title'=>get_the_title(get_incubadora_empresa($arrayPost))
			);
		}

		$nextPage = ($data["filter"]['paged']+1)<=$customQuery->max_num_pages?($data["filter"]['paged']+1):"";
		$hasMore = !empty($nextPage)?true:false;
		$prevPage = (ceil(abs($data["filter"]['paged']-1))<=0)?1:ceil(abs($data["filter"]['paged']-1));
		$outputCustom["pagination"] = array('total'=>$customQuery->max_num_pages, 'next'=>$nextPage, 'prev' => $prevPage, 'current'=>$data["filter"]['paged'], 'hasMore'=>$hasMore);

		wp_send_json($outputCustom);

	}

	wp_reset_query();
	wp_send_json(array('posts'=>null, 'pagination'=>null));
}


function get_empresas_by_parq($request_data){
	global $wpdb, $maxPageRestAPI;

	$data = $request_data->get_params();
	$searchByCPT = "empresas";
	$tax_query = array();
	$meta_query = array();

	if (empty($data['parq_id']) ){
		wp_send_json(array('error'=>_('Fill the INC_ID parameter'), 'posts'=>null, 'pagination'=>null));
	}

	$args = array(
		'post_type' => $searchByCPT,
		'post_status' => 'publish',
		'posts_per_page' => (empty($data['filter']['posts_per_page'])?$maxPageRestAPI:$data['filter']['posts_per_page']),
		'paged' => $data['filter']['paged'],
		'orderby' => (empty($data['filter']['orderby'])?"ASC":$data['filter']['orderby']),
		'order' => (empty($data['filter']['order'])?"title":$data['filter']['order']),
		'meta_query' => array(
			'relation' => 'AND',
			array(
			  	'key'     => 'empresa_parque',
			   	'value'   => $data['parq_id'],
			    'compare' => 'LIKE',
			)
		 )
	);

	$customQuery = null;
	$customQuery = new WP_Query($args);

	if($customQuery->have_posts()){
		$outputCustom = array();
		while ($customQuery->have_posts()){
			$customQuery->the_post();
			$postId = get_the_ID();
			$postType = get_post_type($postId);
			$arrayPost = array('id'=>$postId, 'type'=>$postType);
			$outputCustom['posts'][] = array(
				'id'=>$postId,
				'type'=>$postType,
				'link'=>get_the_permalink(),
				'title'=>get_the_title(),
				'logotipo'=>get_logotipo_associado($arrayPost),
				'contatos'=>get_contatos_associado($arrayPost),
				'telefones'=>get_telefone_associado($arrayPost),
				'email' => get_email_associado($arrayPost),
				'endereco' => get_endereco_associado($arrayPost),
				'site' => get_site_associado($arrayPost)
			);
		}
		$nextPage = ($data["filter"]['paged']+1)<=$customQuery->max_num_pages?($data["filter"]['paged']+1):"";
		$hasMore = !empty($nextPage)?true:false;
		$prevPage = (ceil(abs($data["filter"]['paged']-1))<=0)?1:ceil(abs($data["filter"]['paged']-1));
		$outputCustom["pagination"] = array('total'=>$customQuery->max_num_pages, 'next'=>$nextPage, 'prev' => $prevPage, 'current'=>$data["filter"]['paged'], 'hasMore'=>$hasMore);

		wp_send_json($outputCustom);

	}
	wp_reset_query();
	wp_send_json(array('posts'=>null, 'pagination'=>null));
}



/**
 * Count Empresas' by certain status taxonomy
 */
function countEmpresasByStatusAndLocation($status=false,$location=false){

	if(empty($status) OR empty($location)) return false;

    $args = array(
      'post_type'     => 'empresas', //post type, I used 'product'
      'post_status'   => 'publish', // just tried to find all published post
      'posts_per_page' => -1,  //show all
      'tax_query' => array(
        'relation' => 'AND',
        array(
          'taxonomy' => 'empresa_status',  //taxonomy name  here, I used 'product_cat'
          'field' => 'slug',
          'terms' => array( $status )
        ),
		array(
			'taxonomy' => 'localizacao',
			'field' => 'slug',
			'terms' => array( $location )
		)
      )
    );

    $query = new WP_Query( $args);
	return (int)$query->post_count;

}

/**
 * Count Incubadoras' by certain status taxonomy
 */
function countIncubadorasByLocation($location=false){

	if(empty($location)) return false;

    $args = array(
      'post_type'     => 'incubadoras', //post type, I used 'product'
      'post_status'   => 'publish', // just tried to find all published post
      'posts_per_page' => -1,  //show all
      'tax_query' => array(
        array(
			'taxonomy' => 'localizacao',
			'field' => 'slug',
			'terms' => array( $location )
		)
      )
    );

    $query = new WP_Query( $args);
	return (int)$query->post_count;

}


/**
 * Count Parques' by certain status taxonomy
 */
function countParquesByLocation($location=false){

	if(empty($location)) return false;

    $args = array(
      'post_type'     => 'parques_tecnologicos', //post type, I used 'product'
      'post_status'   => 'publish', // just tried to find all published post
      'posts_per_page' => -1,  //show all
      'tax_query' => array(
        'relation' => 'AND',
        array(
			'taxonomy' => 'localizacao',
			'field' => 'slug',
			'terms' => array( $location )
		)
      )
    );

    $query = new WP_Query( $args);
	return (int)$query->post_count;

}


/*
 * Contador para saber a quantidade de linhas;
 */
function get_number_row($nome_row = null) {
	$contador = 0;
	if( have_rows($nome_row) ):
	    while ( have_rows($nome_row) ) : the_row();
			++$contador;
	    endwhile;
	endif;
	return $contador;
}

function two_columns($num_row = 0) {
	if($num_row % 2 == 0) {
		return ($num_row / 2);
	} else {
		return (($num_row / 2) + 1);
	}
}

?>
