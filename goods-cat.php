<?php

/*
  Plugin Name: Goods Catalog
  Plugin URI: http://oriolo.ru/wordpress/goods-catalog/
  Description: Plugin that creates simple catalog of goods.
  Version: 0.2.1
  Author: Irina Sokolovskaya
  Author URI: http://oriolo.ru/
  License: GNU General Public License v2 or later
  License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

/*
  Copyright 2014  Irina Sokolovskaya  (email : sokolovskaja.irina@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/*
  Images by crisg from https://openclipart.org/detail/183014/box-2-by-crisg-183014 and https://openclipart.org/detail/188919/price-tag-by-crisg-188919.
 */

// debug only
error_reporting(E_ALL);
ini_set('display_errors', 1);

// languages
load_plugin_textdomain('gcat', false, basename(dirname(__FILE__)) . '/languages');

// create post type
function create_goods() {
    register_post_type('goods', array(
        'labels' => array(
            'name' => __('Goods', 'gcat'),
            'singular_name' => __('Item', 'gcat'),
            'add_new' => __('Add', 'gcat'),
            'add_new_item' => __('Add new item', 'gcat'),
            'edit' => __('Edit', 'gcat'),
            'edit_item' => __('Edit item', 'gcat'),
            'new_item' => __('New item', 'gcat'),
            'view' => __('View', 'gcat'),
            'view_item' => __('View of items', 'gcat'),
            'search_items' => __('Search items', 'gcat'),
            'not_found' => __('Items not found', 'gcat'),
            'not_found_in_trash' => __('Item is not found in trash', 'gcat'),
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
            'name' => __('Categories', 'gcat'),
            'add_new_item' => __('Add category', 'gcat'),
            'new_item_name' => __('New category', 'gcat')
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
// based on http://snipplr.com/view/57988/ and https://gist.github.com/TCotton/4723438
function get_term_parents($id, $taxonomy, $link = false, $separator = '/', $nicename = false, $visited = array()) {
    $chain = '';
    $parent = &get_term($id, $taxonomy);
    try {
        if (is_wp_error($parent)) {
            throw new Exception('is_wp_error($parent) has throw error ' . $parent->get_error_message());
        }
    } catch (exception $e) {
        echo __('Caught exception: ', 'gcat'), $e->getMessage(), "\n";
        // use something less drastic than die() in production code
        //die();
    }
    if ($nicename) {
        $name = $parent->slug;
    } else {
        $name = htmlspecialchars($parent->name, ENT_QUOTES, 'UTF-8');
    }
    if ($parent->parent && ($parent->parent != $parent->term_id) && !in_array($parent->parent, $visited)) {
        $visited[] = $parent->parent;
        $chain .= get_term_parents($parent->parent, $taxonomy, $link, $separator, $nicename, $visited);
    }
    if ($link) {
        $chain .= '<a href="' . get_term_link($parent->slug, $taxonomy) . '">' . $name . '</a>' . $separator;
    } else {
        $chain .= $parent->name . $separator;
    }
    return $chain;
}

function get_tag_id($tag) {
    global $wpdb;
    $link_id = $wpdb->get_var($wpdb->prepare("SELECT term_id FROM $wpdb->terms WHERE name =  %s", $tag));
    return $link_id;
}

function my_breadcrumb($id = null) {
    echo '<a href="';
    echo '/catalog';
    echo '">';
    echo __('Catalog', 'gcat');
    echo "</a> &gt; ";
    if (is_category() || is_single() || is_tax()) {
        if (is_single()) {
            $cat = get_the_term_list(isset($post->ID), 'goods_category', '', ', ', '');
            // make sure uncategorised is not used
            if (!stristr($cat, 'Uncategorized')) {
                echo $cat;
                echo '  &gt; ';
            }
            echo '<a href="' . get_permalink(get_the_ID()) . '">';
            the_title();
            echo '</a>';
        }
        if (is_category()) {
            $cat = get_category_parents(get_query_var('cat'), true, ' &gt; ');
            // remove last &gt;
            echo preg_replace('/&gt;\s$|&gt;$/', '', $cat);
        }
        if (is_tax()) {
            $tag = single_tag_title('', false);
            $tag = get_tag_id($tag);
            $term = get_term_parents($tag, get_query_var('taxonomy'), true, ' &gt; ');
            // remove last &gt;
            echo preg_replace('/&gt;\s$|&gt;$/', '', $term);
        }
    } elseif (is_page()) {
        if ($id != null) {
            $an = get_post_ancestors($id);
            if (isset($an['0'])) {
                $parent = '<a href="' . get_permalink($an['0']) . '">' . ucwords(get_the_title($an['0'])) . '</a>';
                echo!is_null($parent) ? $parent . " &gt; " : null;
            }
            $parent = get_the_title($id);
            $parent = '<a href="' . get_permalink($id) . '">' . ucwords($parent) . '</a>';
            echo!is_null($parent) ? $parent . " &gt; " : null;
        }
        echo '<a href="' . get_permalink(get_the_ID()) . '">';
        ucwords(the_title());
        echo '</a>';
    }
}

// pagination 
function goods_pagination($pages = '', $range = 2) {
    $showitems = ($range * 2) + 1;
    global $paged;
    if (empty($paged))
        $paged = 1;
    if ($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if (!$pages) {
            $pages = 1;
        }
    }
    if (1 != $pages) {
        echo "<div class='goods-pagination'><span> " . __('Pages:', 'gcat') . " </span>";
        if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
            echo "<a href='" . get_pagenum_link(1) . "'>«</a>";
        if ($paged > 1 && $showitems < $pages)
            echo "<a href='" . get_pagenum_link($paged - 1) . "'>‹</a>";
        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                echo ($paged == $i) ? "<span class='current'>" . $i . "</span>" : "<a href='" . get_pagenum_link($i) . "' class='inactive' >" . $i . "</a>";
            }
        }
        if ($paged < $pages && $showitems < $pages)
            echo "<a href='" . get_pagenum_link($paged + 1) . "'>›</a>";
        if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
            echo "<a href='" . get_pagenum_link($pages) . "'>»</a>";
        echo "</div>\n";
    }
}

include 'goods-options.php';