<?php

/**
 * Template wrapper
 * 
 * Contains all the common code for catalog templates
 * 
 * @since 0.9.0
 */

get_header(); 

echo '<div class="goods-catalog-container">';
	
	/**
	 * Load the sidebar
	 */ 
	load_template ( dirname( __FILE__ ) . '/sidebar-goods.php' ) ;

	echo '<div class="goods-catalog">';
		echo '<div class="catalog-inner">';

			show_gc_breadcrumbs();
			
			/**
			 * Load the main part of the page.
			 */ 
			require_once( GOODS_CATALOG_PLUGIN_INC . '/templates.php' );

		echo '</div>'; // catalog-inner
	echo '</div>'; // goods-catalog

	echo '<div class="clear"></div>'; // fix for some themes

echo '</div>'; // goods-catalog-container

get_footer();