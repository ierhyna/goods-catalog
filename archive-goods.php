<?php

/*
 * Template: Main catalog page
 */

get_header();
$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

// categiries list with images
$category_id = get_query_var('cat');
$category_list = get_categories('hide_empty=0&type=goods&taxonomy=goods_category&parent=0&orderby=ID' . $category_id);
// include
echo '<div class="goods-catalog">';
include 'content-goods_category.php';
echo '</div>';

get_footer();
