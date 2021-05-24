<?php
add_shortcode('custom_content', 'shortcode_custom_content');
function shortcode_custom_content($atts, $content = null) {
    $out = '';
    $atts = shortcode_atts(array(
        'id' => null,
        'class' => null
    ), $atts);
    $out .= '<div class="custom-content';
    if($atts['class']) :
        $out .= ' '.$atts['class'];
    endif;
    if($atts['id']) : 
        $out .= '" id="'.$atts['id'].'"';
    endif;
    $out .= '">';
        $out .= do_shortcode($content);
    $out .= '</div>';
    return $out;
}

?>
