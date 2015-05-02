<?php
/**
 * Enqueues Styles and Add User Settings
 */


/**
 * Adds default stylesheet
 */
add_action('wp_print_styles', 'goods_add_stylesheet'); 

function goods_add_stylesheet() { // enqueue stylesheet for the catalog pages 
   // commented to make styles work with the shortcodes
   // if (is_tax('goods_category') || is_tax('goods_tag') || is_post_type_archive('goods') || is_singular('goods')) {
        wp_register_style('catalog-style', GOODS_CATALOG_PLUGIN_URL . '/style/catalog-style.css');
        wp_enqueue_style('catalog-style');
   // }
}

/**
 * Load styles
 */
add_action('wp_head', 'goods_add_user_stylesheet', 40);

/**
 * Enqueues users' settings to the stylesheet for the catalog pages 
 */ 

function goods_add_user_stylesheet() { 
    if (is_tax('goods_category') || is_tax('goods_tag') || is_post_type_archive('goods') || is_singular('goods')) {
        global $catalog_option;
        ?>
        <style>
            .goods-catalog-container {
                <?php
                if (isset($catalog_option['container_width'])) { // if user set container width, add it, else 100%
                    echo "width: " . $catalog_option['container_width'] . "%";
                }
                ?>;
                <?php
                if (isset($catalog_option['center_container'])) { // add margin, if checked
                    echo 'margin: 0 auto;';
                }
                ?>
            }
            .goods-catalog {
                <?php
                if (isset($catalog_option['use_sidebar'])) { // if we use sidebar, add margin to container
                    if (isset($catalog_option['sidebar_width'])) { // if user set sidebar width, add margin = sidebar width
                        $sidebar_margin = $catalog_option['sidebar_width'] + 4;
                        echo 'margin-left:' . $sidebar_margin . '%;';
                    }
                }
                ?>
            }
            .goods-catalog .grid {
                <?php
                if (isset($catalog_option['category_thumb_size_w'])) {
                    $size_w = $catalog_option['category_thumb_size_w'] + 40;
                    echo 'width:' . $size_w . 'px';
                } else {
                    echo "width: 200px;";
                }?>

            }
            .goods-sidebar {
                <?php
                if (isset($catalog_option['use_sidebar'])) { // if we use sidebar, set its width
                    if (isset($catalog_option['sidebar_width'])) { // if user set own sidebar width, add value
                        echo "width: " . $catalog_option['sidebar_width'] . "%";
                    } else { // load defaulf value
                        echo "width: 15%;";
                    }
                }
                ?>
            }
            .goods-info {
                <?php
                if (isset($catalog_option['info_width'])) { // if user set infobox width, add it
                    echo "width: " . $catalog_option['info_width'] . "%";
                } else { // else add default
                    echo "width: 60%;";
                }
                ?>
            }
        </style>
        <?php
    }
}

