<?php

/* 
 * Custom sidebar
 */

// Register Sidebar
function goods_register_sidebar() {

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

// Hook into the 'widgets_init' action
add_action('widgets_init', 'goods_register_sidebar');