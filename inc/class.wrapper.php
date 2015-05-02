<?php

/**
 * Class for template wrapper
 * 
 * @since 0.9.0
 */

class Goods_Catalog_Wrapper {
	
	function __construct() {
		add_filter( 'template_include', array( $this, 'goods_catalog_wrapper' ), 99);
	}
	public function goods_catalog_wrapper( $template ) {
		/**
		 * Load wrapper only on plugin pages
		 */ 
		if ( is_post_type_archive('goods') || is_tax('goods_category') || is_tax('goods_tag') || is_singular('goods') ) {	
		    if (file_exists(GOODS_CATALOG_PLUGIN_TEMPLATES . '/wrapper.php')) {
		        return GOODS_CATALOG_PLUGIN_TEMPLATES . '/wrapper.php';
		    }
		}
		return $template;
	}
}

new Goods_Catalog_Wrapper();
