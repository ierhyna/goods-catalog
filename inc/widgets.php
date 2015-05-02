<?php

/**
 * Include widgets classes and create new widgets objects
 */

require_once( GOODS_CATALOG_PLUGIN_INC . '/widgets/Widget_Goods_Categories.php' ); 
require_once( GOODS_CATALOG_PLUGIN_INC . '/widgets/Widget_Goods_Tags.php' ); 

$widget_goods_categories = new Widget_Goods_Categories();
$widget_goods_tags = new Widget_Goods_Tags();

