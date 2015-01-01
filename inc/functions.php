<?php

/*
 * Functions to set up the frontend
 */

/*
 * Exclude children taxonomies posts from the query
 */

function exclude_children($query) {
    if ($query->is_main_query() && $query->is_tax('goods_category')):

        $tax_obj = $query->get_queried_object();

        $tax_query = array(
            'taxonomy' => $tax_obj->taxonomy,
            'field' => 'slug',
            'terms' => $tax_obj->slug,
            'include_children' => FALSE
        );
        $query->tax_query->queries[] = $tax_query;
        $query->query_vars['tax_query'] = $query->tax_query->queries;

    endif;
}

add_action('pre_get_posts', 'exclude_children'); // Exclude children taxonomies posts from the query

/*
 * Set items per page
 */

function goods_pagesize($query) {
    if (is_admin() || !$query->is_main_query())
        return;

    if (is_tax('goods_category') || is_tax('goods_tag')) { // display number of posts
        global $catalog_option;
        $query->set('posts_per_page', $catalog_option['items_per_page']);
        return;
    }
}

add_action('pre_get_posts', 'goods_pagesize', 1); // Set items per page

/*
 * Get page elements
 */

/*
 * get taxomomies list
 */

function get_goods_taxomonies($taxonomy, $id) {
    $terms_list = wp_get_post_terms($id, $taxonomy, array("fields" => "all"));

    $count_terms = count($terms_list);
    if ($count_terms != 0) {

        if ($taxonomy == 'goods_category') {
            echo __('Categories:&nbsp;', 'gcat');
        } else {
            echo __('Tags:&nbsp;', 'gcat');
        }
    }

    foreach ($terms_list as $term) { // count elements
        $term_link = get_term_link($term, $taxonomy);
        if (is_wp_error($term_link))
            continue;
        --$count_terms; // elements -1
        if ($count_terms != 0) { // if > 0
            echo '<a href="' . $term_link . '">' . $term->name . '</a>, ';
        } else {

            echo '<a href="' . $term_link . '">' . $term->name . '</a>'; // do not show comma at the last element
        }
    }
}

/*
 * get product price
 */

function show_the_product_price() {
    $gc_price = get_post_meta(get_the_ID(), 'gc_price', true); // get fields from metabox
    if ((isset($gc_price)) && ($gc_price != '')) { // show fields values
        echo "<p class=\"goods-price-single\">";
        echo __('Price:', 'gcat');
        echo " $gc_price</p>";
    }
}

/*
 * get product SKU
 */

function show_the_product_sku() {
    $gc_sku = get_post_meta(get_the_ID(), 'gc_sku', true);
    if ((isset($gc_sku)) && ($gc_sku != '')) {
        echo "<p class=\"goods-sku\">";
        echo __('SKU:', 'gcat');
        echo " $gc_sku</p>";
    }
}

/*
 * get product short description
 */

function show_the_product_desrc() {
    $gc_descr = get_post_meta(get_the_ID(), 'gc_descr', true);
    if ((isset($gc_descr)) && ($gc_descr != '')) {
        echo "<p class=\"goods-descr\">$gc_descr</p>";
    }
}

/*
 * Add Thumbnail size
 */

global $catalog_option;
if (isset($catalog_option['category_thumb_size_w'])) {
    $size_w = $catalog_option['category_thumb_size_w'];
} else {
    $size_w = 150;
}
if (isset($catalog_option['category_thumb_size_h'])) {
    $size_h = $catalog_option['category_thumb_size_h'];
} else {
    $size_h = 150;
}

if (function_exists('add_image_size')) {
    add_image_size('gc-image-thumb', $size_w, $size_h, true); //(cropped)
}

/*
 * show product thumbnail
 */

function show_the_thumbnail() {
    echo '<div class="goods-item-thumb-container">';
    if (has_post_thumbnail()) {
        echo '<a href="' . get_permalink() . '">';

        the_post_thumbnail('gc-image-thumb', array('class' => 'goods-item-thumb'));
        echo '</a>';
    } else { // show default image if the thumbnail is not found
        echo '<a href="' . get_permalink() . '"><img class="goods-item-thumb" src="' . GOODS_CATALOG_PLUGIN_URL . '/img/gi.png" alt=""></a>';
    }
    echo '</div>';
}

/*
 * get product info for the shortcodes
 */

function goods_shortcode_output() {
    $output .= '<div class="grid"><div>'
            . '<div class="goods-item-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></div>'
            . '<div class="goods-item-content">'
            . '<div class="goods-item-thumb-container">';

    if (has_post_thumbnail()) {
        $output .= '<a href="' . get_permalink() . '">'
                . get_the_post_thumbnail($post_id, 'gc-image-thumb', array('class' => 'goods-item-thumb'))
                . '</a>';
    } else { // show default image if the thumbnail is not found
        $output .= '<a href="' . get_permalink() . '"><img class="goods-item-thumb" src="' . GOODS_CATALOG_PLUGIN_URL . '/img/gi.png" alt=""></a>';
    }

    $gc_price = get_post_meta(get_the_ID(), 'gc_price', true); // get fields from metabox
    if ((isset($gc_price)) && ($gc_price != '')) { // show fields values
        $output .= '<p class="goods-price-single">'
                . __('Price:', 'gcat') . ' ' . $gc_price . '</p>';
    }
    $gc_descr = get_post_meta(get_the_ID(), 'gc_descr', true);
    if ((isset($gc_descr)) && ($gc_descr != '')) {
        $output .= '<p class="goods-descr">' . $gc_descr . '</p>';
    }
    $output .= '</div></div></div></div>';
    return $output;
}
