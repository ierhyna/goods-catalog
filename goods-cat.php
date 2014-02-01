<?php

/*
  Plugin Name: Goods Catalog
  Plugin URI: http://oriolo.ru/
  Description: Plugin that creates simple catalog of goods.
  Version: 0.1
  Author: Irina Sokolovskaya
  Author URI: http://oriolo.ru/
  License: GPLv2
  Images by crisg from https://openclipart.org. (https://openclipart.org/detail/183014/box-2-by-crisg-183014, https://openclipart.org/detail/188919/price-tag-by-crisg-188919). 
 */

// debug only
error_reporting(E_ALL);
ini_set('display_errors', 1);

// create post type
function create_goods() {
    register_post_type('goods', array(
        'labels' => array(
            'name' => 'Goods',
            'singular_name' => 'Item',
            'add_new' => 'Add',
            'add_new_item' => 'Add new item',
            'edit' => 'Edit',
            'edit_item' => 'Edit item',
            'new_item' => 'New item',
            'view' => 'View',
            'view_item' => 'View of items',
            'search_items' => 'Search items',
            'not_found' => 'Items not found',
            'not_found_in_trash' => 'Item is not found in trash',
        ),
        'public' => true,
        'menu_position' => 30,
        'supports' => array('title', 'editor', 'comments', 'thumbnail'),
        'taxonomies' => array('goods_category'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'catalog', 'with_front' => false)
            )
    );
}

// Register metabox
$prefix = 'gc_';
$meta_box = array(
    'id' => 'goods_meta_box',
    'title' => 'Item Options',
    'post_type' => 'goods',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Price',
            'desc' => 'Enter price here',
            'id' => $prefix . 'price',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => 'Short Description',
            'desc' => 'Enter description here',
            'id' => $prefix . 'descr',
            'type' => 'textarea',
            'std' => ''
        )
    )
);

// Callback function to show fields in meta box
function goods_show_box() {
    global $meta_box, $post;
    // Use nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'goods_meta_box_nonce');
    echo '<table class="form-table">';
    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        echo '<tr>',
        '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
        '<td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'];
                break;
        }
        echo '</td><td>',
        '</td></tr>';
    }
    echo '</table>';
}

// Add meta box
function goods_add_box() {
    global $meta_box;
    add_meta_box($meta_box['id'], $meta_box['title'], 'goods_show_box', $meta_box['post_type'], $meta_box['context'], $meta_box['priority']);
}

// Add metabox to edit page
add_action('admin_menu', 'goods_add_box');

// Save data from meta box
function goods_save_data($post_id) {
    global $meta_box;
    // verify nonce
    if (isset($_POST['goods_meta_box_nonce']) && !wp_verify_nonce($_POST['goods_meta_box_nonce'], plugin_basename(__FILE__))) {
        return $post_id;
    }
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    // check permissions
    if ('page' == isset($_POST['post_type'])) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    foreach ($meta_box['fields'] as $field) {
        if (isset($_POST[$field['id']])) {
            // POST field sent - update
            $new = $_POST[$field['id']];
            update_post_meta($post_id, $field['id'], $new);
        } else {
            // POST field not sent - delete
            $old = get_post_meta($post_id, $field['id'], true);
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}

// save metabox data
add_action('save_post', 'goods_save_data');

// Goods Categories

function create_goods_category() {
    register_taxonomy(
            'goods_category', 'goods', array(
        'labels' => array(
            'name' => 'Categories',
            'add_new_item' => 'Add category',
            'new_item_name' => "New category"
        ),
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true,
        'rewrite' => array('slug' => '')
            )
    );
}

/*
 *  Use custom templates for goods and catalog
 */

// Filter the taxonomy-goods_category
add_filter('archive_template', 'goods_archive_template');

function goods_archive_template($archive) {
    global $wp_query, $post;

// Checks for single template by post type
    if (is_post_type_archive('goods')) {
        if (file_exists(plugin_dir_path(__FILE__) . '/archive-goods.php'))
            return plugin_dir_path(__FILE__) . '/archive-goods.php';
    }
    return $archive;
}

// Filter the single_template
add_filter('single_template', 'goods_custom_single_template');

function goods_custom_single_template($single) {
    global $wp_query, $post;

// Checks for single template by post type
    if ($post->post_type == "goods") {
        if (file_exists(plugin_dir_path(__FILE__) . '/single-goods.php'))
            return plugin_dir_path(__FILE__) . '/single-goods.php';
    }
    return $single;
}

// Filter the taxonomy-goods_category
add_filter('taxonomy_template', 'goods_taxonomy_template');

function goods_taxonomy_template($taxonomy) {
    global $wp_query, $post;

// Checks for single template by post type
    if (is_tax('goods_category')) {
        if (file_exists(plugin_dir_path(__FILE__) . '/taxonomy-goods_category.php'))
            return plugin_dir_path(__FILE__) . '/taxonomy-goods_category.php';
    }
    return $taxonomy;
}

add_action('init', 'create_goods');
add_action('init', 'create_goods_category', 0);

// use style for catalog
add_action('wp_enqueue_scripts', 'goods_add_stylesheet');

function goods_add_stylesheet() {
    wp_enqueue_style('prefix-style', plugins_url('catalog-style.css', __FILE__));
}

// breadcrumbs
