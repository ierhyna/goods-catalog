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
            'rewrite' => array( 'slug' => 'catalog', 'with_front' => false )
        )
    );
}

function goods_admin() {
    add_meta_box( 'goods_meta_box',
        'Опции товара',
        'display_goods_meta_box',
        'goods', 'normal', 'high'
    );
}

function display_goods_meta_box( $goods_options ) {
    // Add options
    $goods_price = esc_html( get_post_meta( $goods_options->ID, 'goods_price', true ) );
    $goods_second = esc_html( get_post_meta( $goods_options->ID, 'goods_second', true ) );
    ?>
    <table>
        <tr>
            <td style="width: 150px;">Price</td>
            <td><input type="text" size="10" name="goods_price_set" value="<?php echo $goods_price; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 150px;">Short description</td>
            <td><input type="text" size="150"  name="goods_second_set" value="<?php echo $goods_second; ?>" /></td>
        </tr>
    </table>
    <?php
}

function add_goods_options_fields( $goods_options_id, $goods_options ) {
    // Check post type for goods options
    if ( $goods_options->post_type == 'goods' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['goods_price_set'] ) && $_POST['goods_price_set'] != '' ) {
            update_post_meta( $goods_options_id, 'goods_price', $_POST['goods_price_set'] );
        }
        if ( isset( $_POST['goods_second_set'] ) && $_POST['goods_second_set'] != '' ) {
            update_post_meta( $goods_options_id, 'goods_second', $_POST['goods_second_set'] );
        }
    }
}


function include_template_function( $template_path ) {
    if ( get_post_type() == 'goods' ) {
        if ( is_single() ) {
            // serve the file from the plugin
                $template_path = plugin_dir_path( __FILE__ ) . '/single-goods.php';
        }
        elseif ( is_archive() ) {
            $template_path = plugin_dir_path( __FILE__ ) . '/archive-catalog.php';
    }
    return $template_path;
}


// Goods Categories

function create_my_taxonomies() {
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
            'hierarchical' => true
        )
    );
}

add_action( 'init', 'create_goods' );
add_action( 'admin_init', 'goods_admin' );
add_action( 'save_post', 'add_goods_options_fields', 10, 2 );
//add_filter( 'template_include', 'include_template_function', 1 );
add_action( 'init', 'create_my_taxonomies', 0 );
?>
