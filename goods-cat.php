<?php
/*
Plugin Name: Goods Catalog
Plugin URI: http://oriolo.ru/
Description: Plugin that creates simple catalog of goods.
Version: 0.1
Author: Irina Sokolovskaya
Author URI: http://oriolo.ru/
License: GPLv2
*/

// debug only
 error_reporting(E_ALL);
 ini_set('display_errors', 1);


function create_goods() {
    register_post_type( 'goods',
        array(
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
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail' ),
            'taxonomies' => array( 'goods_category' ),
            'has_archive' => true,
            'rewrite' => array( 'slug' => 'goods', 'with_front' => false )
        )
    );
}

// Register metabox

$prefix = 'gc_';
$meta_box = array(
    'id' => 'goods_meta_box',
    'title' => 'Item Options',
    'page' => 'goods',
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

// Add metabox to edit page
add_action('admin_menu', 'goods_add_box');
// Add meta box
function goods_add_box() {
    global $meta_box;
    add_meta_box($meta_box['id'], $meta_box['title'], 'goods_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
}

// Callback function to show fields in meta box
function goods_show_box() {
    global $meta_box, $post;
    // Use nonce for verification
    echo '<input type="hidden" name="goods_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
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
        echo     '</td><td>',
            '</td></tr>';
    }
    echo '</table>';
}

// save metabox data

add_action('save_post', 'goods_save_data');
// Save data from meta box
function goods_save_data($post_id) {
    global $meta_box;
    // verify nonce
    if (!wp_verify_nonce($_POST['goods_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    foreach ($meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}
// check autosave
if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post_id;
}


// Use custom templates for goods and catalog

// Filter the single_template with our custom function
add_filter('single_template', 'goods_custom_template');

function goods_custom_template($single) {
    global $wp_query, $post;

// Checks for single template by post type
if ($post->post_type == "goods"){
    if(file_exists( plugin_dir_path( __FILE__ ) . '/single-goods.php'))
        return plugin_dir_path( __FILE__ ) . '/single-goods.php';
}
    return $single;
}


// Goods Categories

function create_goods_category() {
    register_taxonomy(
        'goods_category',
        'goods',
        array(
            'labels' => array(
                'name' => 'Category',
                'add_new_item' => 'Add category',
                'new_item_name' => "New category"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
            'rewrite' => array( 'slug' => 'catalog')
        )
    );
}
add_action( 'init', 'create_goods' );
//add_filter( 'template_include', 'include_template_function', 1 );
add_action( 'init', 'create_goods_category', 0 );
?>