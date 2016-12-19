<?php

/**
 * Breadcrumbs
 *
 * Updated, breadcrumbs styles are available now
 */

/**
 * Generate chains of categories
 *
 * @param string $item_template Template for each link in the breadcrumbs
 * @param string $separator     Template for separator
 */
function categories_chain(
	$item_template = '<a href="%1s">%2s</a>',
	$separator = ' &gt; '
) {
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
		$ancestor_link = sprintf($item_template, get_term_link( $ancestor->slug, $category ), $ancestor_name) . $separator;
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
 * @param string $item_template         Template for each link in the breadcrumbs
 * @param string $item_active_template  Template for current (active) breadcrumbs item
 * @param string $separator             Template for separator
 *
 */
function gc_breadcrumbs(
		$id = null,
		$item_template = '<a href="%1s">%2s</a>',
		$item_active_template = '%s',
		$separator = ' &gt; '
) {
	$output = '';
	$output .= sprintf($item_template, home_url(), __('Home', 'goods-catalog')) . $separator;
	/**
	 * if current page is not the Catalog main page, show link and separator
	 */
	if (is_post_type_archive('goods')) {
		$output .= sprintf($item_active_template, __('Catalog', 'goods-catalog'));
	} else {
		$output .= sprintf($item_template, get_post_type_archive_link('goods'), __('Catalog', 'goods-catalog')) . $separator;
	}
	/**
	 * Links on Product page
	 */
	if (is_single()) {
		global $post;
		$output .= categories_chain();
		// $output .= get_the_term_list ($post->ID, 'goods_category', '', ', ', ' &gt; ');

		// New template settings for product terms
		$arTerms = array();
		foreach (get_the_terms($post, 'goods_category') as $term) {
			$arTerms[] = sprintf($item_template, get_term_link($term), $term->name);
		}
		$output .= implode(', ', $arTerms) . $separator;

		$output .= sprintf($item_active_template, get_the_title());
	}
	/**
	 * Links on Category page
	 */
	if (is_tax('goods_category')) {
		$output .= categories_chain($item_template, $separator);
		/**
		 * Return term title
		 *
		 * @param string $prefix Text to output before the title
		 * @param boolean $display Display the title (TRUE), or return the title to be used in PHP (FALSE)
		 *
		 * @link https://codex.wordpress.org/Function_Reference/single_tag_title
		 */
		$output .= sprintf($item_active_template, single_tag_title('', false));
	}
	/**
	 * Links on Tag page
	 */
	if (is_tax('goods_tag')) {
		$output .= sprintf($item_active_template, single_tag_title('', false)); // return the tag title without the link
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
function show_gc_breadcrumbs(
	$before = '<div class="breadcrumbs">',
	$after = '</div>'
) {

	$output = '';
	if (!is_search() || !is_404()) {
		global $post;
		if ($post != null) {
			$output .= $before . gc_breadcrumbs($post->post_parent) . $after;
		} else {
			$output .= $before . gc_breadcrumbs() . $after;
		}
	} else {
		$output .= '&nbsp';
	}

	print $output;
}

/**
 * Prints out styled breadcrumbs
 *
 * @global WP_Post $post
 *
 * @param string $block_template        Template for the whole breadcrumbs block
 * @param string $item_template         Template for each link in the breadcrumbs
 * @param string $item_active_template  Template for current (active) breadcrumbs item
 * @param string $item_separator        Template for separator
 *
 * @author Alex Chizhov <ac@alexchizhov.com>
 */
function get_gc_breadcrumbs(
	$block_template = '<div class="breadcrumbs">%s</div>',
	$item_template = '<a href="%1s">%2s</a>',
	$item_active_template = '<span class="active">%s</span>',
	$item_separator = ' &gt; '
) {

	$output = '';
	if (!is_search() || !is_404()) {
		global $post;

		if ($post != null) {
			$id = $post->post_parent;
		} else {
			$id = null;
		}

		$output .= sprintf($block_template, gc_breadcrumbs($id, $item_template, $item_active_template, $item_separator));

	} else {
		$output .= '&nbsp';
	}

	print $output;
}
