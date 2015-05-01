<?php
/*
 * Template: Single product page
 */

get_header();
echo '<div class="goods-catalog-container">';
load_template(dirname(__FILE__) . '/sidebar-goods.php');

echo '<div class="goods-catalog">';
echo '<div class="catalog-inner">';
if (have_posts()) {
    while (have_posts()) {
        the_post();
        // Display navigation next/previous
        ?>
        <div class="breadcrumbs">
            <?php
            if (!is_search() || !is_404()) {
                global $post;
                if ($post != null) {
                    gc_breadcrumbs($post->post_parent);
                } else {
                    gc_breadcrumbs();
                }
            } else {
                print ' ';
            }
            ?>
        </div>

        <article <?php post_class(); ?>>
            <header>
                <?php
                echo '<div class="goods-single-thumb-container">';
                if (has_post_thumbnail()) {
                    $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
                    echo '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
                    the_post_thumbnail('medium', array('class' => 'goods-single-thumb'));
                    echo '</a>';
                } else {
                    // show default image if the thumbnail is not found
                    echo '<img class="goods-item-thumb" src="' . plugins_url( '/img/gi.png' , dirname(__FILE__) ) . '" alt="">';
                }
                echo '</div>';
                ?>
                <div class="goods-info">
                    <h2 class="entry-title"><?php the_title(); ?></h2>
                    <?php
                    // show product
                    echo get_the_product_price();
                    
                    if (isset($catalog_option['show_product_sku_page'])) {
                        show_the_product_sku();
                    }
                    if (isset($catalog_option['show_product_descr_page'])) {
                        show_the_product_desrc();
                    }

                    // show category
                    echo get_the_term_list ($post->ID, 'goods_category', '<p>' . __("Categories", "gcat") . ':&nbsp;', ', ', '</p>');

                    // show tags
                    echo get_the_term_list ($post->ID, 'goods_tag', '<p>' . __("Tags", "gcat") . ':&nbsp;', ', ', '</p>');
                    ?>
                </div>
                <div class="clear"></div>
            </header>
            <div class="entry-content">
                <?php
                the_content();
                ?>
            </div>
            <div class="clear"></div>
        </article>
        <?php
    }

    // Display navigation to next/previous
    ?>
    <div class="navigation"><?php posts_nav_link(); ?></div>
    <?php
    echo '</div>';
} else {
    get_404_template();
}
echo '</div>';
echo '<div class="clear"></div>'; // fix for some themes
echo '</div>'; // goods-catalog-container
get_footer();
