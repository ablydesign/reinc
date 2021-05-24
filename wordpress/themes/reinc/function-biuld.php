<?
    function get_terms_list ($post_type) {
        $terms = get_terms($post_type);
        $return_array[] = NULL;
        foreach ($terms as $term) {
            if ($term->parent === 0 ) {
                $return_array[$term->slug]['slug'] = $term->slug;
                $return_array[$term->slug]['name'] = $term->name;
                $return_array[$term->slug]['term_id'] = $term->term_id;
            }
        }
        return $return_array;
    }
?>
