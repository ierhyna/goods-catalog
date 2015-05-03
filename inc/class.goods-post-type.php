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
                'name' => __('Goods', 'gcat'),
                'singular_name' => __('Item', 'gcat'),
                'add_new' => __('Add', 'gcat'),
                'add_new_item' => __('Add new item', 'gcat'),
                'edit' => __('Edit', 'gcat'),
                'edit_item' => __('Edit item', 'gcat'),
                'new_item' => __('New item', 'gcat'),
                'view' => __('View', 'gcat'),
                'view_item' => __('View of items', 'gcat'),
                'search_items' => __('Search items', 'gcat'),
                'not_found' => __('Items not found', 'gcat'),
                'not_found_in_trash' => __('Item is not found in trash', 'gcat'),
            ),
            'public' => true,
            'menu_position' => 30,
            'supports' => array('title', 'editor', 'thumbnail'),
            'taxonomies' => array('goods_category'),
            'has_archive' => true,
            'rewrite' => array('slug' => $slug, 'with_front' => false)
            )
        );
    }
}

new Goods_Post_Type();