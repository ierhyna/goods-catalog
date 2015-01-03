<?php

/* 
 * Custom taxonomy: Goods Category
 */

// Goods Categories
function create_goods_category() {
    
    global $catalog_option;
    $slug = $catalog_option[ 'gc_category_slug' ];
    if( ! $slug ) $slug = 'goods_category';
    
    register_taxonomy(
            'goods_category', 'goods', array(
        'labels' => array(
            'name' => __('Goods Categories', 'gcat'),
            'add_new_item' => __('Add category', 'gcat'),
            'new_item_name' => __('New category', 'gcat')
        ),
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => false,
        'hierarchical' => true,
        'rewrite' => array('slug' => $slug)
            )
    );
}

add_action('init', 'create_goods_category', 0);
