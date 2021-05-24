<?php if (!function_exists('add_action')) exit;

function destino_en_taxonomy()
{
    $labels = array(
        'name' => _x('Destino EN', ''),
        'singular_name' => _x('Destino da propriedade EN', 'taxonomy singular name'),
        'search_items' => __('Buscar por destino EN'),
        'all_items' => __('Destination'),
        'edit_item' => __('Editar destino EN'),
        'update_item' => __('Atualizar'),
        'menu_name' => __('Destino EN'),
        'add_new_item' => __('Adicionar Destino EN'),
    );
    $args = array(
        'labels' => $labels,
        'show_tagcloud' => false,
        'show_ui' => true,
        'hierarchical' => true
    );

    register_taxonomy('destino_en_categoria', 'propriedades', $args);

}
add_action('init', 'destino_en_taxonomy', 0);

