<?php

/**
 * Template: Main catalog page
 * 
 * You can edit this template by coping into your theme's folder
 */

$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

// categiries list with images
$category_id = get_query_var('cat');
$args = array(
    'type' => 'goods',
    'taxonomy' => 'goods_category',
    'hide_empty' => 0,
    'parent' => 0,
    'orderby' => 'name'
);
$category_list = get_categories($args, $category_id);

/**
 * Include the list of subcategories in grid.
 * 
 * If you edit this template by coping into your theme's folder, please change this functions with the following:
 * include WP_PLUGIN_DIR  . '/goods-catalog/templates/content-goods_category.php';
 */
include 'content-goods_category.php';