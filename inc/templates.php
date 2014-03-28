<?php
/*
 * Load custom templates for post type and taxonomies from plugin directory
 */

/*
 * Archives : Main Page of the Catalog
 */

add_filter('archive_template', 'goods_archive_template');

function goods_archive_template($archive) {
    global $wp_query, $post;
    if (is_post_type_archive('goods')) { // Checks for single template by post type
        if (file_exists(GOODS_CATALOG_PLUGIN_TEMPLATES . '/archive-goods.php')) {
            return GOODS_CATALOG_PLUGIN_TEMPLATES . '/archive-goods.php';
        }
    }
    return $archive;
}

/*
 * Single Product
 */

add_filter('single_template', 'goods_custom_single_template'); // Filter the single_template

function goods_custom_single_template($single) {
    global $wp_query, $post;
    if ($post->post_type == "goods") { // Checks for single template by post type
        if (file_exists(GOODS_CATALOG_PLUGIN_TEMPLATES . '/single-goods.php')) {
            return GOODS_CATALOG_PLUGIN_TEMPLATES . '/single-goods.php';
        }
    }
    return $single;
}

/*
 * Categories
 */

add_filter('taxonomy_template', 'goods_category_template'); // Filter the taxonomy-goods_category

function goods_category_template($taxonomy) {
    global $wp_query, $post;
    if (is_tax('goods_category')) { // Checks for single template by post type
        if (file_exists(GOODS_CATALOG_PLUGIN_TEMPLATES . '/taxonomy-goods_category.php')) {
            return GOODS_CATALOG_PLUGIN_TEMPLATES . '/taxonomy-goods_category.php';
        }
    }
    return $taxonomy;
}

/*
 * Tags
 */

add_filter('taxonomy_template', 'goods_tag_template'); // Filter the taxonomy-goods_tag

function goods_tag_template($taxonomy) {
    global $wp_query, $post;
    if (is_tax('goods_tag')) { // Checks for single template by post type
        if (file_exists(GOODS_CATALOG_PLUGIN_TEMPLATES . '/taxonomy-goods_tag.php')) {
            return GOODS_CATALOG_PLUGIN_TEMPLATES . '/taxonomy-goods_tag.php';
        }
    }
    return $taxonomy;
}
