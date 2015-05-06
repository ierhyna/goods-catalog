<?php

/**
 * Template: Category page
 * 
 * You can edit this template by coping into your theme's folder
 */

$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

global $posts;
if (have_posts()) { // fix 'undefined offset 0'
    $post = $posts[0];
}
ob_start();

echo '<h2 class="single-category-title">' . single_cat_title('', false) . '</h2>';
if (isset($catalog_option['show_category_descr_page'])) {
    echo '<p>' . category_description() . '</p>';
}

// show sub-categories only in first page, if paged
if (!is_paged()) {

    // show sub-categories list
    $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
    $args = array(
        'parent' => $current_term->term_id,
        'taxonomy' => $current_term->taxonomy,
        'hide_empty' => 0,
        'hierarchical' => true,
        'depth' => 1
    );

    $category_list = get_categories($args);
    
    /**
     * Include the list of subcategories in grid.
     * 
     * If you edit this template by coping into your theme's folder, please change this functions with the following:
     * include WP_PLUGIN_DIR  . '/goods-catalog/templates/content-goods_category.php';
     */
    include 'content-goods_category.php';

    echo "<hr>";
}

/**
 * Include the list of subcategories in grid.
 * 
 * If you edit this template by coping into your theme's folder, please change this functions with the following:
 * load_template(WP_PLUGIN_DIR  . '/goods-catalog/templates/content-goods_grid.php');
 */
load_template(dirname(__FILE__) . '/content-goods_grid.php');
?>
<div class="navigation">
    <?php
    // Display navigation to next/previous pages when applicable
    if (function_exists('goods_pagination'))
        goods_pagination();
    else
        posts_nav_link();
    ?>
</div>
