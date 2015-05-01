<?php

/**
 * Custom taxonomy: Goods Category
 * 
 * @since 0.9.0
 */

class Goods_Categories_Taxonomy {
    
    function __construct() {
        add_action('init', array ($this, 'create_goods_category'));
    }
    // Goods Categories
    public function create_goods_category() {
        
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
}

new Goods_Categories_Taxonomy();