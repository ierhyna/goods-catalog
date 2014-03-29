<?php

/*
 * Create post type: goods
 */

function create_goods() {
    
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
        'supports' => array('title', 'editor', 'comments', 'thumbnail'),
        'taxonomies' => array('goods_category'),
        'has_archive' => true,
        'rewrite' => array('slug' => $slug, 'with_front' => false)
            )
    );
}

add_action('init', 'create_goods');
