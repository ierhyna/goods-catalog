<?php

/**
 * Functions to set up the frontend
 */

/**
 * Exclude children taxonomies posts from the query
 * 
 * @param $query 
 */

function exclude_children($query) {
    if ($query->is_main_query() && $query->is_tax('goods_category')):

        $tax_obj = $query->get_queried_object();

        $tax_query = array(
            'taxonomy' => $tax_obj->taxonomy,
            'field' => 'slug',
            'terms' => $tax_obj->slug,
            'include_children' => FALSE
        );
        $query->tax_query->queries[] = $tax_query;
        $query->query_vars['tax_query'] = $query->tax_query->queries;

    endif;
}

add_action('pre_get_posts', 'exclude_children'); // Exclude children taxonomies posts from the query

/**
 * Set items per page
 * 
 * @param $query 
 */

function goods_pagesize($query) {
    if (is_admin() || !$query->is_main_query())
        return;

    if (is_tax('goods_category') || is_tax('goods_tag')) { // display number of posts
        global $catalog_option;
        $query->set('posts_per_page', $catalog_option['items_per_page']);
        return;
    }
}

add_action('pre_get_posts', 'goods_pagesize', 1); // Set items per page

/**
 * Get page elements
 */

/**
 * Get taxomomies list.
 *
 * In Goods Catalog 0.7 the function get_goods_taxomonies() has been removed.
 * If you have modified the plugin templates, please use WordPress core function get_the_term_list().
 * 
 * For example:
 * 
 * 1) Get goods categories list:
 * echo get_the_term_list ($post->ID, 'goods_category', '<p>' . __("Categories", "gcat") . ':&nbsp;', ', ', '</p>');
 * 
 * 1) Get goods tags list:
 * echo get_the_term_list ($post->ID, 'goods_tag', '<p>' . __("Tags", "gcat") . ':&nbsp;', ', ', '</p>');
 * 
 *
 * @since 0.4.5
 * @deprecated 0.7.0 Use {@see get_the_term_list()} instead.
 * @see get_the_term_list()
 * @link http://codex.wordpress.org/Function_Reference/get_the_term_list
 *
 */

function get_goods_taxomonies($taxonomy, $id) {}

/**
 * Gets product price
 * 
 * Renamed from show_the_product_price();
 * 
 * @param string $title The title
 * @param string $before HTML to show before
 * @param string $after HTML to show after
 * 
 * @since 0.9.0
 */

function get_the_product_price( $title = '', $before = '<p class="goods-price-single">', $after = '</p>' ) {
    
    global $catalog_option;
    $output = '';

    /*
     * get fields from metabox
     */
    $gc_price = get_post_meta(get_the_ID(), 'gc_price', true);

     /*
     * get the options
     */   
    $gc_product_price_prefix = $catalog_option['gc_product_price_prefix'];
    $gc_product_price_postfix = $catalog_option['gc_product_price_postfix'];

    if ((isset($gc_price)) && ($gc_price != '')) { // show fields values

        $title = __('Price:', 'gcat');

        /*
         * Show the prefix if chosen the option
         */
        if ((isset($gc_product_price_prefix)) && ($gc_product_price_prefix != '')) {
            $output .= " " . $gc_product_price_prefix;
        }

        /*
         * The price
         */
        $output .= " " . $gc_price;

        /*
         * Show the postfix if chosen the option
         */
        if ((isset($gc_product_price_postfix)) && ($gc_product_price_postfix != '')) {
            $output .= " " .  $gc_product_price_postfix;
        }

        return $before . $title . $output . $after;
    }
}

/**
 * Show product's SKU
 * 
 * @param string $title The title
 * @param string $before HTML to show before
 * @param string $after HTML to show after
 */

function show_the_product_sku( $title = '', $before = '<p class="goods-sku">', $after = '</p>' ) {
    $gc_sku = get_post_meta(get_the_ID(), 'gc_sku', true);
    if ((isset($gc_sku)) && ($gc_sku != '')) {
        $title = __('SKU:', 'gcat');
        echo $before . $title . "&nbsp" . $gc_sku . $after;
    }
}

/**
 * Show product's short description
 * 
 * @param string $before HTML to show before
 * @param string $after HTML to show after
 */

function show_the_product_desrc( $before = '<p class="goods-descr">', $after = '</p>' ) {
    $gc_descr = get_post_meta(get_the_ID(), 'gc_descr', true);
    if ((isset($gc_descr)) && ($gc_descr != '')) {
        echo $before . $gc_descr . $after;
    }
}

/**
 * Add Thumbnail size
 * 
 * @since 0.9.0
 * 
 */

function set_gc_image_size() { 
    global $catalog_option;
    /**
     * Get image size from user's settings
     */
    if (isset($catalog_option['category_thumb_size_w'])) {
        $size_w = $catalog_option['category_thumb_size_w'];
    } else {
        $size_w = 150;
    }
    if (isset($catalog_option['category_thumb_size_h'])) {
        $size_h = $catalog_option['category_thumb_size_h'];
    } else {
        $size_h = 150;
    }

    /**
     * Add new image size
     * 
     * @param string $name Name of the new size
     * @param int $width Width
     * @param int $height Height
     * @param boolean/array $crop Crop mode
     * 
     * @link http://codex.wordpress.org/Function_Reference/add_image_size
     */ 
    add_image_size('gc-image-thumb', $size_w, $size_h, true);
}
add_action( 'plugins_loaded', 'set_gc_image_size' );

/**
 * Add Thumbnails support
 * 
 * Adds thumbnails support if such a function is missing in the theme
 * 
 * @since 0.9.1
 * 
 */
function gs_thumbnails_support() {
    global $_wp_theme_features;

    if( empty($_wp_theme_features['post-thumbnails']) )
        $_wp_theme_features['post-thumbnails'] = array( array('goods') );

    elseif( true === $_wp_theme_features['post-thumbnails'])
        return;

    elseif( is_array($_wp_theme_features['post-thumbnails'][0]) )
        $_wp_theme_features['post-thumbnails'][0][] = 'goods';

    // add_theme_support( 'post-thumbnails' );               
}
add_action( 'after_setup_theme', 'gs_thumbnails_support', 11 );

/**
 * Get product's thumbnail
 * 
 * Renamed from show_the_thumbnail();
 * 
 * @since 0.9.0
 * 
 * @param int $product_id ID of the product used to show the thumbnail
 * @param string $before HTML to show before
 * @param string $after HTML to show after
 * 
 */

function get_the_product_thumbnail( $product_id = '', $before = '<div class="goods-item-thumb-container">', $after = '</div>' ) {

    $output = '';
    $product_id = get_the_ID();

    if (has_post_thumbnail()) {
        $output .= '<a href="' . get_permalink() . '">';
        $output .= get_the_post_thumbnail($product_id, 'gc-image-thumb', array('class' => 'goods-item-thumb'));
        $output .= '</a>';
    } else { // show default image if the thumbnail is not found
        $output .= '<a href="' . get_permalink() . '"><img class="goods-item-thumb" src="' . GOODS_CATALOG_PLUGIN_URL . '/img/gi.png" alt=""></a>';
    }

    return $before . $output . $after;
}

