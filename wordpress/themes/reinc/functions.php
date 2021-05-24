<?php if (!function_exists('add_action')) exit;

add_action('after_setup_theme', 'setup_theme');
/*-------------------------------------------*
    Funções do tema
*------------------------------------------*/
function setup_theme() {
    theme_supports();
    image_sizes();
    nav_menus();
    add_theme_support('category-thumbnails');

    add_action( 'wp_enqueue_scripts', 'setup_scripts' ); 	// Registra javascritp do tema
    add_action( 'wp_enqueue_scripts', 'setup_styles' ); 	// Registra css do tema
    add_filter('excerpt_length', 'custom_excerpt_length', 999); // Limitar tamanho do post
    add_filter('excerpt_more', 'custom_excerpt_more'); //Mensagem quando acabar o post
    add_filter( 'body_class', 'add_slug_body_class' ); //Nome das paginas no body
    add_action( 'admin_menu', 'my_remove_menu_pages' );// Remove Post Admin

    add_action('login_enqueue_scripts', 'login_logo');
}

add_filter('nav_menu_css_class' , 'special_page_nav_class' , 10 , 4);
function special_page_nav_class($classes, $item){
    $page_id = get_the_ID();
    $current_type = get_post_type($page_id);
    if (is_singular() && $item->ID == 22 && in_array($current_type, array('parques_tecnologicos', 'incubadoras', 'empresas'))) {
        $classes[] = 'current-menu-item';
    } else if (is_singular() && $item->ID == 25 && in_array($current_type, array('custom_biblioteca') ) ) {
        $classes[] = 'current-menu-item';
    } else if (is_singular() && $item->ID == 24 && in_array($current_type, array('custom_atividades') ) ) {
        $classes[] = 'current-menu-item';
    }
    return $classes;
}


add_filter( 'locale', 'set_custom_locale', 10);
function set_custom_locale($lang) {
    session_start();
    $_SESSION['lang'];
    if (((isset($_GET['lang'])) && ($_GET['lang']=='en'))) {
    	$_SESSION['lang'] = 'en_US';
    	return 'en_US';
    } elseif (((isset($_GET['lang'])) && ($_GET['lang']=='pt-BR')) ) {
    	$_SESSION['lang'] = 'pt_BR';
    	return 'pt_BR';
    } else {
        $lang = ($_SESSION['lang']) ? $_SESSION['lang'] : $lang;
    	return $lang;
    }
}

add_filter('language_attributes', 'get_localte_attributes');
function get_localte_attributes ($language_attributes) {
    $my_language = get_locale();
    return 'lang="'.$my_language.'"';
}

add_action( 'after_setup_theme', 'mytheme_load_textdomain' );
function mytheme_load_textdomain() {
    load_theme_textdomain( 'natio-lang', get_template_directory() . '/languages');
}

add_filter( 'nav_menu_item_title', 'menu_translate_item_title', 10, 2);
function menu_translate_item_title ($title, $item) {
     $my_language = get_locale();
     if ($my_language == 'en_US') :
         $title = __($title, 'natio-lang');
     endif;
     return $title;
}


function the_translate_content(){
	$my_language = get_locale();
	if ($my_language == 'en_US' AND get_field('content_en',  get_the_ID()) ) {
        $content = apply_filters('the_content', get_field('content_en',  get_the_ID()));
    	echo $content;
	} elseif($my_language == 'pt_BR') {
        the_content();
	} else {
        $content = __(get_the_content(), 'natio-lang');
        $content = apply_filters( 'the_content', $content );
        $content = str_replace( ']]>', ']]&gt;', $content );
        echo $content;
    }
}



function the_translate_field($field_name, $post_ID){
    $my_language = get_locale();
	if ($my_language == 'en_US' AND get_field($field_name . '_en',  $post_ID) ) {
        $content = get_field($field_name . '_en',  $post_ID);
    	echo $content;
    } elseif($my_language == 'pt_BR' AND get_field($field_name . '_pt',  $post_ID)) {
        $content = get_field($field_name . '_pt',  $post_ID);
        echo $content;
	} else {
        $content = get_field($field_name,  $post_ID);
        echo $content;
    }
}


function the_translate_sub_field($field_name, $post_ID){
    $my_language = get_locale();

    $content = '';
	if ($my_language == 'en_US' AND get_sub_field($field_name . '_en',  $post_ID) ) {
        $content = get_sub_field($field_name . '_en',  $post_ID);
    } elseif($my_language == 'pt_BR' AND get_sub_field($field_name . '_pt',  $post_ID)) {
        $content = get_sub_field($field_name . '_pt',  $post_ID);
	} else {
        $content = get_sub_field($field_name,  $post_ID);
    }
    echo $content;
}

function get_translate_sub_field($field_name, $post_ID){
    $my_language = get_locale();

    $content = '';
	if ($my_language == 'en_US' AND get_sub_field($field_name . '_en',  $post_ID) ) {
        $content = get_sub_field($field_name . '_en',  $post_ID);
    } elseif($my_language == 'pt_BR' AND get_sub_field($field_name . '_pt',  $post_ID)) {
        $content = get_sub_field($field_name . '_pt',  $post_ID);
	} else {
        $content = get_sub_field($field_name,  $post_ID);
    }
    return $content;
}


function get_translate_field($field_name){
    $my_language = get_locale();
    $content = '';
	if ($my_language == 'en_US') {
        $content = ($field_name . '_en');
    } else {
        $content = ($field_name);
    }
    return $content;
}


function the_form_contact (){
    $my_language = get_locale();
    $content = '';
	if ($my_language == 'en_US') {
        $content = do_shortcode('[contact-form-7 id="1001" title="Contato EN"]');;
    } else {
        $content = get_the_content();
        $content = apply_filters( 'the_content', $content );
        $content = str_replace( ']]>', ']]&gt;', $content );
    }
    echo $content;
}



function the_action_lang($lang){
    $my_language = get_locale();
    $class = '';
    if ($my_language == $lang) {
        $class = 'active';
    }
    echo $class;
}



/**
 * Add All Custom Post Types to search
 *
 * Returns the main $query.
 *
 * @access      public
 * @since       1.0
 * @return      $query
*/

function add_custom_post_search($query) {

	// Check to verify it's search page
	if( is_search() ) {
		// Get post types
		$post_types = get_post_types(array('public' => true, 'exclude_from_search' => false), 'objects');
		$searchable_types = array();
        $searchable_types[] = 'nav_menu_item';
		// Add available post types
		if( $post_types ) {
			foreach( $post_types as $type) {
				$searchable_types[] = $type->name;
			}
		}
		$query->set( 'post_type', $searchable_types );
	}
	return $query;
}
add_action( 'pre_get_posts', 'add_custom_post_search' );

/*-------------------------------------------*
    Javascript
*------------------------------------------*/
function setup_scripts() {
    wp_register_script(
        'bootstrap-script',
        get_stylesheet_directory_uri() . '/assets/js/vendor/bootstrap.min.js',
        array( 'jquery' ),
        '',
        true
    );
    wp_register_script(
        'jquery-ui',
        get_stylesheet_directory_uri() . '/assets/js/vendor/jquery-ui.min.js',
        array( 'jquery' ),
        '',
        true
    );
    wp_register_script(
        'owl-script',
        get_stylesheet_directory_uri() . '/assets/js/vendor/owl.carousel.min.js',
        array( 'jquery' ),
        '',
        true
    );

     wp_enqueue_script(
        'jquery-custom',
        get_stylesheet_directory_uri() . '/assets/js/vendor/jquery-2.2.0.min.js',
        array(
        ),
        '2.2.0',
        true
    );

    wp_enqueue_script(
        'jquery.imagemapster.min.js',
        get_stylesheet_directory_uri() . '/assets/js/jquery.imagemapster.min.js',
        array(
            'jquery-custom',
        ),
        filemtime( TEMPLATEPATH . '/assets/js/jquery.imagemapster.min.js' ),
        true
    );

    if (is_singular()) {
        wp_enqueue_script(
            'fancybox-scripts',
            get_stylesheet_directory_uri() . '/assets/js/vendor/jquery.fancybox.pack.js',
            array(
                'jquery',
            ),
            filemtime( TEMPLATEPATH . '/assets/js/vendor/jquery.fancybox.pack.js' ),
            true
        );
    }

	wp_enqueue_script(
        'all-scripts',
        get_stylesheet_directory_uri() . '/assets/js/main.js',
        array(
            'jquery',
            'jquery-ui',
            'owl-script',
            'bootstrap-script'
        ),
        filemtime( TEMPLATEPATH . '/assets/js/main.js' ),
        true
    );

    if (is_page(array(7, 967))) {
        wp_enqueue_script(
            'biblioteca-scripts',
            get_stylesheet_directory_uri() . '/assets/js/jquery.biblioteca.js',
            array(
                'jquery',
            ),
            filemtime( TEMPLATEPATH . '/assets/js/jquery.biblioteca.js' ),
            true
        );
    }
    if (is_page(9)) {
        wp_enqueue_script(
            'atividades-scripts',
            get_stylesheet_directory_uri() . '/assets/js/jquery.atividades.js',
            array(
                'jquery',
            ),
            filemtime( TEMPLATEPATH . '/assets/js/jquery.atividades.js' ),
            true
        );
    }
    if (is_page(array(13, 962)) ) {
        wp_register_script(
            'mousewheel',
            get_stylesheet_directory_uri() . '/assets/js/vendor/jquery.mousewheel-3.0.6.min.js',
            array(
                'jquery'
            ),
            filemtime( TEMPLATEPATH .'/assets/js/vendor/jquery.mousewheel-3.0.6.min.js' ),
            true
        );
        wp_register_script(
            'custom_scroll',
            get_stylesheet_directory_uri() . '/assets/js/vendor/jquery.mCustomScrollbar.min.js',
            array(
                'jquery', 'mousewheel',
            ),
            filemtime( TEMPLATEPATH . '/assets/js/vendor/jquery.mCustomScrollbar.min.js' ),
            true
        );
        // wp_register_script(
        //     'js_pagination',
        //     get_stylesheet_directory_uri() . '/assets/js/vendor/jquery.mCustomScrollbar.min.js',
        //     array(
        //         'jquery', '',
        //     ),
        //     filemtime( TEMPLATEPATH . '/assets/js/jquery.mCustomScrollbar.min.js' ),
        //     true
        // );
        wp_enqueue_script(
            'associados-scripts',
            get_stylesheet_directory_uri() . '/assets/js/jquery.associados.js',
            array(
                'jquery', 'jquery-ui-accordion', 'custom_scroll',
            ),
            filemtime( TEMPLATEPATH . '/assets/js/jquery.associados.js' ),
            true
        );
        wp_enqueue_script(
            'googleMaps-scripts',
            "https://maps.googleapis.com/maps/api/js?key=AIzaSyDsf2ZLJJByJ_D0-vBnOrYNKHKdoeqR4l8",
            array(
                'jquery',
            ),
            null,
            true
        );


    }
    if (is_singular(array('incubadoras')) ) {
        wp_enqueue_script(
            'associados-single-scripts',
            get_stylesheet_directory_uri() . '/assets/js/jquery.associados.incubadora.js',
            array(
                'jquery', 'jquery-ui-accordion',
            ),
            filemtime( TEMPLATEPATH . '/assets/js/jquery.associados.incubadora.js' ),
            true
        );
    }
    if (is_singular(array('parques_tecnologicos')) ) {
        wp_enqueue_script(
            'parque-single-scripts',
            get_stylesheet_directory_uri() . '/assets/js/jquery.associados.parque_tec.js',
            array(
                'jquery', 'jquery-ui-accordion',
            ),
            filemtime( TEMPLATEPATH . '/assets/js/jquery.associados.parque_tec.js' ),
            true
        );
    }

}

/*-------------------------------------------*
    Folhas de estilo - CSS
*------------------------------------------*/

function setup_styles() {

    wp_enqueue_style( 'dashicons' );

    wp_enqueue_style(
        'normalize-style',
        get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css',
        true,
        'all'
    );

    wp_enqueue_style(
        'main-style',
        get_stylesheet_directory_uri() . '/assets/css/main.css',
        true,
        'all'
    );

    wp_enqueue_style(
        'custom-style',
        get_stylesheet_directory_uri() . '/assets/css/custom.css',
        true,
        'custom'
    );
    wp_enqueue_style(
        'owl-style',
        get_stylesheet_directory_uri() . '/assets/css/owl.carousel.css',
        true,
        'all'
    );

}
/*-------------------------------------------*
    Nome das paginas no body
*------------------------------------------*/
function add_slug_body_class( $classes ) {
    global $post;
    if ( isset( $post ) ) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}

/*-------------------------------------------*
    Suportes
*------------------------------------------*/
function theme_supports() {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5' );
}
/*-------------------------------------------*
    Tamanho das Imagens
*------------------------------------------*/
function image_sizes() {
    add_image_size( 'imagem-lightbox', 800, 600, true );
}

/*-------------------------------------------*
    Menus
*------------------------------------------*/
function nav_menus() {
    register_nav_menu( 'menu-header', 'Menu Principal' );
    register_nav_menu( 'menu-footer', 'Menu Rodapé' );
    register_nav_menu( 'menu-intranet', 'Menu Intranet' );
}

/*-------------------------------------------*
    CustomPostType
*------------------------------------------*/
require_once 'assets/includes/custom-post-types/custom-post-types.php';

/*-------------------------------------------*
    Remove Post Admin
*------------------------------------------*/
function my_remove_menu_pages() {
    remove_menu_page('edit.php');
}

/*-------------------------------------------*
    Taxonomias
*------------------------------------------
require_once 'assets/includes/taxonomia/taxonomias.php';*/

/*-------------------------------------------*
    Reegistrar Shortcode
*------------------------------------------ */
require_once 'assets/includes/shortcodes/template-custom-content.php';
require_once 'assets/includes/shortcodes/template-mapa.php';
//require_once 'assets/includes/shortcodes/template-part-publicacao.php';
//require_once 'assets/includes/shortcodes/template-part-area-atuacao.php';
//require_once 'assets/includes/shortcodes/template-part-area-atuacao-en.php';

/*-------------------------------------------*
	Trocar Imagem da pagina de Login
*------------------------------------------*/
function login_logo()
{
    ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo.png);
            width: 100%;
            background-size: auto;
            height: 115px;
        }
    </style>
<?php
}

/*-------------------------------------------*
        Resumo e Tamnho dos posts
*------------------------------------------*/
function custom_excerpt_length($length)
{
    return 20;
}

/*-------------------------------------------*
        The Category Taxonomias
*------------------------------------------*/
function the_cat_taxonomia ($id)
{
    $categories = get_the_terms( $id, 'custom_atividades_segmentos' );
    foreach( $categories as $category ) {
        echo $category->slug . ' ';
    }
}

/*-------------------------------------------*
        Paginação
*------------------------------------------*/
function pagination()
{
    global $wp_query;

    $big = 9999999999999; // need an unlikely integer

    echo paginate_links(
        array(
            'reinc' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $wp_query->max_num_pages,
            'type' => 'list',
            'prev_next' => true,
            'prev_text' => 'Página Anterior',
            'next_text' => 'Próxima Página',
        )
    );
}

/*-------------------------------------------*
        The Post Name
*------------------------------------------*/
function the_post_type_name ($post_id) {
    $post_type = get_post_type($post_id);
    if (!empty($post_type)){
        $obj = get_post_type_object( $post_type );
        echo $obj->labels->singular_name;
    } else {
        echo '';
    }
}
/*
if( function_exists('acf_add_options_page') )
{
    acf_add_options_page();
    acf_add_options_sub_page('Home');
}

if( function_exists('acf_set_options_page_title') )
{
    acf_set_options_page_title( __('Theme Options') );
}
*/

/**
 * Conjunto de funções desenvolvidas por Henrique Ramos para a Natio Criativo, Projeto ReINC. 2016
 * @author Henrique Ramos <hramos@live.de>
 */

require_once('class/WP_Indicadores.php');

require_once("ramos_custom_functions.php");
require_once("function-biuld.php");


require_once('class/WP_Incubadoras.php');
require_once('class/WP_Associados.php');
require_once('class/WP_Empresas.php');
require_once('class/WP_Parques.php');
require_once('class/WP_Atividades.php');
require_once('class/WP_Biblioteca.php');
require_once('class/WP_Intranet.php');


add_action( 'template_redirect', 'intranet_init' );
function intranet_init() {
    global $post;
    $page = get_page_by_path('intranet');
    if ((is_page($page->ID) || $page->ID == $post->post_parent)) :
        if (!(is_user_logged_in())) {
            wp_redirect(home_url('login'));
            exit;
        }
    endif;
}
