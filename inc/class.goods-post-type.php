<?php

/**
 * Create post type: goods
 *
 * @since 0.9.0
 */

class Goods_Post_Type {

	function __construct() {
		add_action('init', array ($this, 'create_goods'));
	}

	public function create_goods() {
		global $catalog_option;
		$slug = $catalog_option[ 'gc_catalog_slug' ];
		if( ! $slug ) $slug = 'catalog';
			register_post_type('goods', array(
				'labels' => array(
					'name' => __('Goods', 'goods-catalog'),
					'singular_name' => __('Item', 'goods-catalog'),
					'add_new' => __('Add', 'goods-catalog'),
					'add_new_item' => __('Add new item', 'goods-catalog'),
					'edit' => __('Edit', 'goods-catalog'),
					'edit_item' => __('Edit item', 'goods-catalog'),
					'new_item' => __('New item', 'goods-catalog'),
					'view' => __('View', 'goods-catalog'),
					'view_item' => __('View of items', 'goods-catalog'),
					'search_items' => __('Search items', 'goods-catalog'),
					'not_found' => __('Items not found', 'goods-catalog'),
					'not_found_in_trash' => __('Item is not found in trash', 'goods-catalog'),
				),
				'public' => true,
				'menu_position' => 30,
				'supports' => array('title', 'editor', 'thumbnail', 'comments'),
				'taxonomies' => array('goods_category'),
				'has_archive' => true,
				'rewrite' => array('slug' => $slug, 'with_front' => false)
			)
		);
	}
}

new Goods_Post_Type();
