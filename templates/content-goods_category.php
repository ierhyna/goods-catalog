<?php

/**
 * The list of subcategories in grid
 * 
 * Loaded in:
 * home-goods_catalog.php
 * taxonomy-goods_category.php
 * 
 */

// check if current taxonomy doesn't have childs
if (empty($category_list)) {
//     echo "There are no subcategories";
}
// if has
else {

    echo '<div class="goods-categories-container">';
    foreach ($category_list as $categories_item) {

        // show categories titles
        echo '<div class="grid"><div class="goods-category-list-title"><a href="' . esc_url(get_term_link($categories_item, $categories_item->taxonomy)) . '" title="' . sprintf(__("Go to cetegory %s", 'gcat'), $categories_item->name) . '" ' . '>' . $categories_item->name . '</a></div> ';

        // show categories images
        if (isset($catalog_option['show_category_thumb'])) {
            echo '<div class="goods-category-thumb-container">';
            $terms = apply_filters('taxonomy-images-get-terms', '', array('taxonomy' => 'goods_category'));
            $flag = FALSE;
            if (!empty($terms)) {
                foreach ((array) $terms as $term) {
                    if ($term->term_id == $categories_item->term_id) {

                        $img = wp_get_attachment_image($term->image_id, 'gc-image-thumb', '', array('class' => 'goods-category-thumb'));
                        echo '<a href="' . esc_url(get_term_link($term, $term->taxonomy)) . '">' . $img . '</a>';
                        $flag = TRUE;
                    }
                }
                if ($flag == FALSE) {
                    echo '<a href="' . esc_url(get_term_link($categories_item, $categories_item->taxonomy)) . '"><img class="goods-item-thumb" src="' . plugins_url('/img/gc.png', dirname(__FILE__)) . '" alt=""></a>';
                }
            }
            // show images if plugin Taxonomy Images not installed
            else {
                echo '<a href="' . esc_url(get_term_link($categories_item, $categories_item->taxonomy)) . '"><img class="goods-item-thumb" src="' . plugins_url('/img/gc.png', dirname(__FILE__)) . '" alt=""></a>';
            }
            echo '</div>';
        }
        // show categories description
        if (isset($catalog_option['show_category_descr_grid'])) {
            echo '<p>' . $categories_item->category_description . '</p>';
        }
        echo '</div>';
    }

    echo '</div>';
    echo '<div class="clear"></div>';
}