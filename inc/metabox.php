<?php

/* 
 * Create metabox for goods post type
 */

// Register metabox
$prefix = 'gc_';
$meta_box = array(
    'id' => 'goods_meta_box',
    'title' => __('Item Options', 'gcat'),
    'post_type' => 'goods',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => __('Price', 'gcat'),
            'desc' => __('Enter price here', 'gcat'),
            'id' => $prefix . 'price',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => __('SKU', 'gcat'),
            'desc' => __('Enter product ID (SKU)', 'gcat'),
            'id' => $prefix . 'sku',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => __('Short Description', 'gcat'),
            'desc' => __('Enter description here', 'gcat'),
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
        '<th style="width:20%"><label for="'. __($field['name'],'gcat'). '">', __($field['name'],'gcat'), '</label></th>',
        '<td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />'. __($field['desc'],'gcat').'';
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />'. __($field['desc'],'gcat').'';
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
    add_meta_box($meta_box['id'], __($meta_box['title'],'gcat'), 'goods_show_box', $meta_box['post_type'], $meta_box['context'], $meta_box['priority']);
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