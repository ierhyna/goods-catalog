<?php

/*
 * Template: Sidebar
 */

global $catalog_option;

if (isset($catalog_option['use_sidebar'])) {
    echo '<aside class="goods-sidebar">';
    if (!dynamic_sidebar('goods-sidebar')) {

        // load list of categories if there is no widgets in the sidebar
        echo '<h3 class="widgettitle">Catalog</h3>';
        $taxonomy = 'goods_category';
        $orderby = 'name';
        $show_count = 1;      // 1 for yes, 0 for no
        $pad_counts = 0;      // do not count products in subcategories
        $hierarchical = 1;      // 1 for yes, 0 for no

        $args = array(
            'taxonomy' => $taxonomy,
            'orderby' => $orderby,
            'show_count' => $show_count,
            'pad_counts' => $pad_counts,
            'hierarchical' => $hierarchical,
            'title_li' => ''
        );
        echo '<ul>';
        wp_list_categories($args);
        echo '</ul>';
    }
    echo '</aside>';
}