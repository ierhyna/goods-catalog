<?php
/*
 * Widgets Here
 */

require_once( GOODS_CATALOG_PLUGIN_INC . '/class.widget-goods-categories.php' ); 

require_once( GOODS_CATALOG_PLUGIN_INC . '/class.widget-goods-tags.php' ); 

new Widget_Goods_Categories();

new Widget_Goods_Tags();