<?php

/**
 * Class for template wrapper
 * 
 * @since 0.9.0
 */

class Goods_Catalog_Wrapper {
	
	function __construct() {
		add_filter( 'template_include', array( $this, 'goods_catalog_wrapper' ));
	}

	public function goods_catalog_wrapper( $template ) {
	    if (file_exists(GOODS_CATALOG_PLUGIN_TEMPLATES . '/wrapper.php')) {
	        return GOODS_CATALOG_PLUGIN_TEMPLATES . '/wrapper.php';
	    }
	    return $template;
	}

}
new Goods_Catalog_Wrapper();