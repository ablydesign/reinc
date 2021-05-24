<?php if (!function_exists('add_action')) exit;


/*-------------------------------------------*
    CPT notas
*------------------------------------------*/
function notas_postype()
{
    register_post_type(
        'custom_atividades',
        array(
            'labels' => array(
                'name' => __( 'Atividade' ),
                'all_items' => __('Listar Atividades'),
                'singular_name' => __( 'Atividade' )
            ),
            'capability_type' => 'post',
            'public' => true,
            'has_archive' => false,
            'taxonomias' => array('post_tag'),
            'rewrite' => array('slug' => 'atividade'),
            'supports' => array('title', 'editor','thumbnail')
        )
    );
    register_taxonomy(
        'custom_atividades_segmentos',
        'custom_atividades',
        array(
            'labels' => array(
                'name' => 'Filtro',
                'add_new_item' => 'Adicionar Filtro',
                'new_item_name' => "Novo Filtro"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'show_admin_column' => true,
            'hierarchical' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'categoria/atividades')
        )
    );
    register_post_type(
        'custom_biblioteca',
        array(
            'labels' => array(
                'name' => __( 'Biblioteca' ),
                'all_items' => __('Listar Biblioteca'),
                'singular_name' => __( 'Biblioteca' )
            ),
            'capability_type' => 'post',
            'public' => true,
            'has_archive' => false,
            'taxonomias' => array('post_tag'),
            'rewrite' => array('slug' => 'biblioteca'),
            'supports' => array('title', 'editor','thumbnail')
        )
    );
    register_taxonomy(
        'custom_biblioteca_segmentos',
        'custom_biblioteca',
        array(
            'labels' => array(
                'name' => 'Filtro',
                'add_new_item' => 'Adicionar Filtro',
                'new_item_name' => "Novo Filtro"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'show_admin_column' => true,
            'hierarchical' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'categoria/biblioteca')
        )
    );

    register_taxonomy(
        'custom_tags',
        array('custom_biblioteca', 'custom_atividades'),
        array(
            'labels' => array(
                'name' => 'Tags',
                'add_new_item' => 'Adicionar Tag',
                'new_item_name' => "Nova Tag"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'show_admin_column' => true,
            'hierarchical' => false,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'tags')
        )
    );
    /**
    * Registra o Custom Post Type PROJETOS utilizados na intranet
    *
    * @see http://codex.wordpress.org/Function_Reference/register_post_type
    */
    register_post_type(
        'custom_projetos',
        array(
            'labels' => array(
                'name' => __( 'Projetos' ),
                'all_items' => __('Listar Projetos'),
                'singular_name' => __( 'Projeto' )
            ),
            'menu_icon'          => 'dashicons-portfolio',
            'capability_type' => 'post',
            'public' => true,
            'has_archive' => false,
            'menu_position' => 99,
            'rewrite' => array('slug' => 'projetos'),
            'supports' => array('title', 'editor','thumbnail')
        )
    );
}
add_action( 'init', 'notas_postype' ); // Registra CustomPostType
