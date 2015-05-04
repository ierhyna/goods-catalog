<?php

/**
 * Load custom templates for post type and taxonomies from plugin directory
 */

global $wp_query, $post;

$catalog_pages = array(
    is_post_type_archive('goods') => 'home-goods_catalog.php',
    is_tax('goods_category') => 'taxonomy-goods_category.php',
    is_tax('goods_tag') => 'taxonomy-goods_tag.php',
    is_singular('goods') => 'single-goods.php'
);

/**
 * Load the page template
 * 
 * Check the template from theme's folder, if not found load the template from plugin folder
 * 
 * @since 0.9.2
 */ 
foreach ($catalog_pages as $page => $template) {
    if ($page) {
        if (file_exists (get_template_directory() . '/' . $template)) {
            // echo 'Current template: ' . get_template_directory() . '/' . $template;
            require_once (get_template_directory() . '/' . $template);
        }
        else {
            require_once (GOODS_CATALOG_PLUGIN_TEMPLATES . '/' . $template);
        }
    }
}
