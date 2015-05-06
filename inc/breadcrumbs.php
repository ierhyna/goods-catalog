<?php

/**
 * Breadcrumbs
 */

/**
 * Generate chains of categories
 */ 
function categories_chain() {
	$output = '';
	$category = 'goods_category';

	/**
	 * If the current page is product page, use get_the_terms() to get ID
	 */ 
	if (is_single()) {
		global $post;
		$product_terms = get_the_terms($post->ID, $category);
		if ($product_terms) { // fix invalid argument supplied for foreach() if there is no category for the product
			foreach ($product_terms as $p) {
				$category_id = $p->term_id;
			}
		}
	} else { 
		/**
		 * If current page is category page, use get_queried_object() to get ID
		 */ 
		$category_id = get_queried_object()->term_id;
	}
	$ancestors_reverse = get_ancestors( $category_id, $category );
	$ancestors = array_reverse( $ancestors_reverse );
	//var_dump($ancestors);
	foreach ( $ancestors as $a ) {
		$ancestor = get_term( $a, $category );
		$ancestor_name = $ancestor->name;
		$ancestor_link = '<a href="' . get_term_link( $ancestor->slug, $category ) . '">' . $ancestor_name . '</a> &gt; ';
		$output .= $ancestor_link;
	}
	return $output;
}

/**
 * Generate and return full breadcrumbs path
 * 
 * @since 0.9.0 
 * 
 * @param int $id
 * 
 */ 
function gc_breadcrumbs($id = null) {
	$output = '';
	$output .= '<a href=" ' . home_url() . ' ">' . __('Home', 'gcat') . '</a> &gt; ';
	/**
	 * if current page is not the Catalog main page, show link and separator
	 */ 
	if (is_post_type_archive('goods')) {
		$output .=  __('Catalog', 'gcat');
	} else { 
		$output .=  '<a href="' . get_post_type_archive_link('goods') . '">' . __('Catalog', 'gcat') . '</a> &gt; ';
	}
	/** 
	 * Links on Product page
	 */
	if (is_single()) {
		global $post;
		$output .= categories_chain();
		$output .= get_the_term_list ($post->ID, 'goods_category', '', ', ', ' &gt; ');
		$output .= get_the_title();
	}
	/**
	 * Links on Category page
	 */
	if (is_tax('goods_category')) {
		$output .= categories_chain();
		/**
		 * Return term title
		 * 
		 * @param string $prefix Text to output before the title
		 * @param boolean $display Display the title (TRUE), or return the title to be used in PHP (FALSE)
		 * 
		 * @link https://codex.wordpress.org/Function_Reference/single_tag_title
		 */ 
		$output .= single_tag_title('', false); 
	}
	/**
	 * Links on Tag page
	 */ 
	if (is_tax('goods_tag')) {
		$output .= single_tag_title('', false); // return the tag title without the link
	}
	return $output;
}

/**
 * Show breadcrumbs
 * 
 * @since 0.9.0
 * 
 * @param string $before Text to output before chain
 * @param string $after Text to output after chain
 * 
 */ 
function show_gc_breadcrumbs ( $before = '<div class="breadcrumbs">', $after = '</div>' ) {
	$output = '';
    if (!is_search() || !is_404()) {
        global $post;
        if ($post != null) {
        	$output .= $before . gc_breadcrumbs($post->post_parent) . $after;
        } else {
        	$output .=  $before . gc_breadcrumbs() . $after;
        }
    } else {
        $output .=  '&nbsp';
    }
    print $output;
}