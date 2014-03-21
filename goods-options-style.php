<?php
/*
 * Enqueue Styles and Add User Settings
 */

// register hook 'wp_print_styles'
add_action('wp_print_styles', 'goods_add_stylesheet');

// enqueue stylesheet for the catalog pages 
function goods_add_stylesheet() {
    // use only on catalog pages
    if (is_tax('goods_category') || is_tax('goods_tag') || is_post_type_archive('goods') || is_singular('goods')) {
        wp_register_style('catalog-style', plugins_url('catalog-style.css', __FILE__));
        wp_enqueue_style('catalog-style');
    }
}

// enqueue users stylesheet for the catalog pages 
function goods_add_user_stylesheet() {
    // use only on catalog pages
    if (is_tax('goods_category') || is_tax('goods_tag') || is_post_type_archive('goods') || is_singular('goods')) {
        global $catalog_option;
        ?>
        <style>
            .goods-catalog-container {
                <?php
                // if user set container width, add it, else 100%
                if (isset($catalog_option['container_width'])) {
                    echo "width: " . $catalog_option['container_width'] . "%";
                }
                ?>;
                <?php
                // add margin, if checked
                if (isset($catalog_option['center_container'])) {
                    echo 'margin: 0 auto;';
                }
                ?>
            }
            .goods-catalog {
                <?php
                // if we use sidebar, add margin to container
                if (isset($catalog_option['use_sidebar'])) {
                    // if user set sidebar width, add margin = sidebar width
                    if (isset($catalog_option['sidebar_width'])) {
                        $sidebar_margin = $catalog_option['sidebar_width'] + 4 ;
                        echo 'margin-left:' . $sidebar_margin . '%;';
                    }
                }
                ?>
            }
            .goods-sidebar {
                <?php
                // if we use sidebar, set its width
                if (isset($catalog_option['use_sidebar'])) {
                    // if user set own sidebar width, add value
                    if (isset($catalog_option['sidebar_width'])) {
                        echo "width: " . $catalog_option['sidebar_width'] . "%";
                    } else {
                        // else load defaulf value
                        echo "width: 15%;";
                    }
                }
                ?>
            }
            .goods-info {
                <?php
                // if user set infobox width, add it
                if (isset($catalog_option['info_width'])) {
                    echo "width: " . $catalog_option['info_width'] . "%";
                } else {
                    // else add default
                    echo "width: 60%;";
                }
                ?>
            }
        </style>
        <?php
    }
}

// load
add_action('wp_head', 'goods_add_user_stylesheet', 40);
