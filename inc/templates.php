<?php

/**
 * Load custom templates for post type and taxonomies from plugin directory
 */

global $wp_query, $post;

if (is_post_type_archive('goods')) { // Main Catalog Page
    if (file_exists(GOODS_CATALOG_PLUGIN_TEMPLATES . '/home-goods_catalog.php')) {
        require_once (GOODS_CATALOG_PLUGIN_TEMPLATES . '/home-goods_catalog.php');
    }
}
elseif (is_tax('goods_category')) { // Categories
    if (file_exists(GOODS_CATALOG_PLUGIN_TEMPLATES . '/taxonomy-goods_category.php')) {
        require_once (GOODS_CATALOG_PLUGIN_TEMPLATES . '/taxonomy-goods_category.php');
    }
}
elseif (is_tax('goods_tag')) { // Tags
    if (file_exists(GOODS_CATALOG_PLUGIN_TEMPLATES . '/taxonomy-goods_tag.php')) {
        require_once (GOODS_CATALOG_PLUGIN_TEMPLATES . '/taxonomy-goods_tag.php');
    }
}
elseif (is_singular('goods')) { // Single Product
    if (file_exists(GOODS_CATALOG_PLUGIN_TEMPLATES . '/single-goods.php')) {
        require_once (GOODS_CATALOG_PLUGIN_TEMPLATES . '/single-goods.php');
    }
}