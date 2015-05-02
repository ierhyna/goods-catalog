<?php

/**
 * Catalog sidebar
 * 
 * @since 0.9.0
 */

class Goods_Sidebar { 

    function __construct() {
        // Hook into the 'widgets_init' action
        add_action('widgets_init', array ($this, 'goods_register_sidebar'));
    }

    // Register Sidebar
    public function goods_register_sidebar() {

        $args = array(
            'id' => 'goods-sidebar',
            'name' => __('Goods Catalog Sidebar', 'gcat'),
            'description' => __('Goods Catalog Widgets', 'gcat'),
            'before_title' => '<h3 class="wigdettitle">',
            'after_title' => '</h3>',
            'before_widget' => '<div class="widget %2$s">',
            'after_widget' => '</div>',
        );
        register_sidebar($args);
    }
}

new Goods_Sidebar();