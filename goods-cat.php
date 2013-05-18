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
                'name' => '&#1058;&#1086;&#1074;&#1072;&#1088;&#1099;',
                'singular_name' => '&#1058;&#1086;&#1074;&#1072;&#1088;',
                'add_new' => '&#1044;&#1086;&#1073;&#1072;&#1074;&#1080;&#1090;&#1100;',
                'add_new_item' => '&#1044;&#1086;&#1073;&#1072;&#1074;&#1080;&#1090;&#1100; &#1085;&#1086;&#1074;&#1099;&#1081; &#1090;&#1086;&#1074;&#1072;&#1088;',
                'edit' => '&#1056;&#1077;&#1076;&#1072;&#1082;&#1090;&#1080;&#1088;&#1086;&#1074;&#1072;&#1090;&#1100;',
                'edit_item' => '&#1056;&#1077;&#1076;&#1072;&#1082;&#1090;&#1080;&#1088;&#1086;&#1074;&#1072;&#1090;&#1100; &#1090;&#1086;&#1074;&#1072;&#1088;',
                'new_item' => '&#1053;&#1086;&#1074;&#1099;&#1081; &#1090;&#1086;&#1074;&#1072;&#1088;',
                'view' => '&#1042;&#1080;&#1076;',
                'view_item' => '&#1042;&#1080;&#1076; &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074;',
                'search_items' => '&#1055;&#1086;&#1080;&#1089;&#1082; &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074;',
                'not_found' => '&#1058;&#1086;&#1074;&#1072;&#1088;&#1099; &#1085;&#1077; &#1085;&#1072;&#1081;&#1076;&#1077;&#1085;&#1099;',
                'not_found_in_trash' => '&#1058;&#1086;&#1074;&#1072;&#1088;&#1099; &#1074; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1077; &#1085;&#1077; &#1085;&#1072;&#1081;&#1076;&#1077;&#1085;&#1099;',
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
            <td style="width: 150px;">Цена</td>
            <td><input type="text" size="10" name="goods_price_set" value="<?php echo $goods_price; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 150px;">Краткое описание</td>
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
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-goods.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/single-goods.php';
            }
        }
        elseif ( is_archive() ) {
            if ( $theme_file = locate_template( array ( 'archive-catalog.php' ) ) ) {
                $template_path = $theme_file;
            } else { $template_path = plugin_dir_path( __FILE__ ) . '/archive-catalog.php';
            }
        }
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
                'name' => 'Категории',
                'add_new_item' => 'Добавить категорию',
                'new_item_name' => "Новая категория"
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
