<?php

/**
 * Custom Taxonomy: Goods Tag
 * 
 * @since 0.9.0
 */

/**
* 
*/
class Goods_Tags_Taxonomy {

    function __construct() {
        add_action('init', array ( $this, 'create_goods_tags') );
    }

    // Goods Tags
    public function create_goods_tags() {
        
        global $catalog_option;
        $slug = $catalog_option[ 'gc_tag_slug' ];
        if( ! $slug ) $slug = 'goods_tag';

        $labels = array(
            'name' => __('Goods Tags', 'gcat'),
            'menu_name' => __('Tags', 'gcat'),
            'all_items' => __('All Items', 'gcat'),
            'parent_item' => __('Parent Item', 'gcat'),
            'parent_item_colon' => __('Parent Item:', 'gcat'),
            'new_item_name' => __('New Item Name', 'gcat'),
            'add_new_item' => __('Add New Item', 'gcat'),
            'edit_item' => __('Edit Item', 'gcat'),
            'update_item' => __('Update Item', 'gcat'),
            'separate_items_with_commas' => __('Separate items with commas', 'gcat'),
            'search_items' => __('Search Items', 'gcat'),
            'add_or_remove_items' => __('Add or remove items', 'gcat'),
            'choose_from_most_used' => __('Choose from the most used items', 'gcat'),
            'not_found' => __('Not Found', 'gcat'),
        );
        $rewrite = array(
            'slug' => $slug,
            'with_front' => true,
            'hierarchical' => false,
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'rewrite' => $rewrite,
        );
        register_taxonomy('goods_tag', array('goods'), $args);
    }

}

new Goods_Tags_Taxonomy();