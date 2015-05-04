<?php

/**
 * Template: Sidebar
 */

global $catalog_option;

if (isset($catalog_option['use_sidebar'])) {
    echo '<aside class="goods-sidebar">';
    if (!dynamic_sidebar('goods-sidebar')) {

        echo '<h3 class="widgettitle">' . __('Goods Catalog Sidebar is Activated!', 'gcat') . '</h3>';
        echo __('Hi! It is Goods Catalog Sidebar. Please <a href="/wp-admin/widgets.php">add some widgets</a> in there, and this message will be hidden automatically.', 'gcat');

    }
    echo '</aside>';
}