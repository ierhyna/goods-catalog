<?php

/**
 * Template: Main catalog page
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

include 'content-goods_category.php';