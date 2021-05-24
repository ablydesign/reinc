<?php
/*shortcode Area de atuação*/
add_shortcode('mapa', 'shortcode_map');
function shortcode_map() {
	$out = '';
	$out .= '<div class="mapa-container">';
		ob_start(); 
			include_once (TEMPLATEPATH .'/assets/includes/mapa/map.php');
		$out .= ob_get_contents();
		ob_get_clean();
    $out .= '</div>';
    return $out;
}

