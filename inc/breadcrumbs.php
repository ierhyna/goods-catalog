<?php

/*
 * Breadcrumbs
 * based on http://snipplr.com/view/57988/ and https://gist.github.com/TCotton/4723438
 */

function get_term_parents($id, $taxonomy, $link = false, $separator = ' &gt; ', $visited = array()) {

	$parent = get_term($id, $taxonomy);
	try {
		if (is_wp_error($parent)) {
			throw new Exception('is_wp_error($parent) has throw error ' . $parent->get_error_message());
		}
	} catch (exception $e) {
		echo 'Caught exception: ', $e->getMessage(), "\n";
	}

	if( !empty( $parent ) ) {
		$chain = '';
		$name = htmlspecialchars($parent->name, ENT_QUOTES, 'UTF-8');
		if ($parent->parent && ($parent->parent != $parent->term_id) && !in_array($parent->parent, $visited)) {
			$visited[] = $parent->parent;
			$chain .= get_term_parents($parent->parent, $taxonomy, $link, $separator, $visited);
		}
		if ($link) {
			$chain .= '<a href="' . get_term_link($parent->slug, $taxonomy) . '">' . $name . '</a>' . $separator;
		} else {
			$chain .= $parent->name . $separator;
		}
		return $chain;
	}
}

function gc_breadcrumbs($id = null) {
	// First link: Home page
	echo '<a href=" ' . home_url() . ' ">' . __('Home', 'gcat') . '</a> &gt; ';

	// if current page is not the Catalog main page, show link and separator
	if (is_post_type_archive('goods')) {
		echo __('Catalog', 'gcat');
	} else { 
		echo '<a href="' . get_post_type_archive_link('goods') . '">' . __('Catalog', 'gcat') . '</a> &gt; ';
	}

	// Links on Product page
	if (is_single()) {
		global $post;
		$cur_terms = get_the_terms($post->ID, 'goods_category');
		if ($cur_terms) { // fix invalid argument supplied for foreach() if there is no category for the product
			foreach ($cur_terms as $cur_term) {
				$category_id = $cur_term->term_id;
				$categories_chain = get_term_parents($category_id, 'goods_category', true);
				echo preg_replace('/>\s$|>$/', '', $categories_chain);
			}
		}
		the_title();
	}

	// Links on Category page
	if (is_tax('goods_category')) {
		$category_id = get_queried_object()->term_id;
		$categories_chain = get_term_parents($category_id, 'goods_category', true); 
		echo preg_replace('/&gt;\s$|&gt;$/', '', $categories_chain); // remove last &gt;
	}

	// Links on Tag page
	if (is_tax('goods_tag')) {
		single_tag_title(); // echo the tag title without the link
	}
}
