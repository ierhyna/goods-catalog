<?php

/*
Plugin Name: Goods Catalog
Plugin URI: http://oriolo.wordpress.com/2014/03/25/goods-catalog-wordpress-plugin-that-creates-catalog-of-products/
Description: Plugin that creates simple catalog of goods.
Version: 2.2.0
Author: Irina Sokolovskaya
Author URI: http://oriolo.ru/
License: GNU General Public License v3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Text Domain: goods-catalog
Domain Path: /languages
*/

/*
Goods Catalog, WordPress plugin that creates catalog of products.
Copyright (c) 2014  Irina Sokolovskaya  (email : sokolovskaja.irina@gmail.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/*
Images by crisg from https://openclipart.org/detail/183014/box-2-by-crisg-183014 and https://openclipart.org/detail/188919/price-tag-by-crisg-188919.
*/


/**
 * Define plugin's pathes
 * All without the last trailing slash
 */
define('GOODS_CATALOG_PLUGIN_PATH', dirname(__FILE__));
define('GOODS_CATALOG_PLUGIN_URL', plugins_url('', __FILE__));
define('GOODS_CATALOG_PLUGIN_FILE', plugin_basename(__FILE__));
define('GOODS_CATALOG_PLUGIN_INC', GOODS_CATALOG_PLUGIN_PATH . '/inc');
define('GOODS_CATALOG_PLUGIN_TEMPLATES', GOODS_CATALOG_PLUGIN_PATH . '/templates');

/**
 * Load Localization
 */
function goods_catalog_lang_init() {
	$domain = 'goods-catalog';
	// The "plugin_locale" filter is also used in load_plugin_textdomain()
	$locale = apply_filters('plugin_locale', get_locale(), $domain);
	load_textdomain($domain, WP_LANG_DIR.'/plugins/'.$domain.'-'.$locale.'.mo');
	load_plugin_textdomain($domain, FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
}
add_action('plugins_loaded', 'goods_catalog_lang_init');

/*
 * Use options set by user
 */
$catalog_option = get_option('goods_option_name');

/**
 * Load options
 */
require_once( GOODS_CATALOG_PLUGIN_INC . '/class.settings-page.php' ); // Options Class
require_once( GOODS_CATALOG_PLUGIN_PATH  . '/style/goods-options-style.php' ); // Stylesheet

/**
 * Create post type and taxonomies
 */
require_once( GOODS_CATALOG_PLUGIN_INC . '/class.goods-post-type.php' ); // create post type
require_once( GOODS_CATALOG_PLUGIN_INC . '/class.metabox.php' ); // create metabox
require_once( GOODS_CATALOG_PLUGIN_INC . '/class.goods-categories-taxonomy.php' ); // Goods Categories
require_once( GOODS_CATALOG_PLUGIN_INC . '/class.goods-tags-taxonomy.php' ); // Goods Tags

/**
 * Create Sidebar and Widgets
 */
require_once( GOODS_CATALOG_PLUGIN_INC . '/class.sidebar.php' ); // Sidebar Class
require_once( GOODS_CATALOG_PLUGIN_INC . '/widgets.php' );  // Widgets Classes

/**
 *  Use custom templates for goods and catalog
 */
//require_once( GOODS_CATALOG_PLUGIN_INC . '/class.wrapper.php' ); // Wrapper class
require_once( GOODS_CATALOG_PLUGIN_INC . '/templates-include.php' );

/**
 * Load additional functions
 */
require_once( GOODS_CATALOG_PLUGIN_INC . '/functions.php' );  // Functions
require_once( GOODS_CATALOG_PLUGIN_INC . '/breadcrumbs.php' ); // breadcrumbs
require_once( GOODS_CATALOG_PLUGIN_INC . '/pagination.php' ); // pagination
require_once( GOODS_CATALOG_PLUGIN_INC . '/shortcodes.php' ); // shortcodes
