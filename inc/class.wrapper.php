<?php

/**
 * Class for template wrapper
 * 
 * @since 0.9.0
 * @link http://scribu.net/wordpress/theme-wrappers.html
 */

function goods_catalog_template_path() {
	return Goods_Catalog_Wrapping::$main_template;
}

function goods_catalog_template_base() {
	return Goods_Catalog_Wrapping::$base;
}


class Goods_Catalog_Wrapping {

	/**
	 * Stores the full path to the main template file
	 */
	static $main_template;

	/**
	 * Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
	 */
	static $base;

	static function wrap( $template ) {
		self::$main_template = $template;

		self::$base = substr( basename( self::$main_template ), 0, -4 );

		if ( 'index' == self::$base )
			self::$base = false;

		$templates = array( 'wrapper.php' );

		if ( self::$base )
			array_unshift( $templates, sprintf( 'wrapper-%s.php', self::$base ) );

		return locate_template( $templates );
	}
}

add_filter( 'template_include', array( 'Goods_Catalog_Wrapping', 'wrap' ), 99 );