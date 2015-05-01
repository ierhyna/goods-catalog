<?php

/**
 * Breadcrumbs
 */

function categories_chain(){
	$category = 'goods_category';
	if (is_single()) { // if is Product Page, use get_the_terms() to get ID
		global $post;
		$product_terms = get_the_terms($post->ID, $category);
		if ($product_terms) { // fix invalid argument supplied for foreach() if there is no category for the product
			foreach ($product_terms as $p) {
				$category_id = $p->term_id;
			}
		}
	} else { // if is Category Page, use get_queried_object()  to get ID
		$category_id = get_queried_object()->term_id;
	}
	$ancestors_reverse = get_ancestors( $category_id, $category );
	$ancestors = array_reverse( $ancestors_reverse );
	foreach ( $ancestors as $a ) {
		$ancestor = get_term( $a, $category );
		$ancestor_name = $ancestor->name;
		$ancestor_link = '<a href="' . get_term_link( $ancestor->slug, $category ) . '">' . $ancestor_name . '</a> &gt; ';
		echo $ancestor_link;
	}
}

function gc_breadcrumbs($id = null) {
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
		categories_chain();
		echo get_the_term_list ($post->ID, 'goods_category', '', ', ', ' &gt; ');
		the_title();
	}
	// Links on Category page
	if (is_tax('goods_category')) {
		categories_chain();
		single_tag_title(); 
	}
	// Links on Tag page
	if (is_tax('goods_tag')) {
		single_tag_title(); // echo the tag title without the link
	}
}
