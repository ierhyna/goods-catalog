<?php

/*
 * Template: Main catalog page
 */

get_header();
echo '<div class="goods-catalog-container">';
load_template ( dirname( __FILE__ ) . '/sidebar-goods.php' ) ;

$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

// categiries list with images
$category_id = get_query_var('cat');
$category_list = get_categories('hide_empty=0&type=goods&taxonomy=goods_category&parent=0&orderby=ID' . $category_id);
// include
echo '<div class="goods-catalog">';
echo '<div class="catalog-inner">';

include 'content-goods_category.php';

echo '</div>'; // catalog-inner
echo '</div>'; // goods-catalog

echo '<div class="clear"></div>'; // fix for some themes
echo '</div>'; // goods-catalog-container


get_footer();