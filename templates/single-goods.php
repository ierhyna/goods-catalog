<?php

/**
 * Template: Single product page
 * 
 * You can edit this template by coping into your theme's folder
 */

if (have_posts()) {
    while (have_posts()) {
        the_post();
        ?>

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
                    // show product's details
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
    ?>
    <div class="navigation"><?php posts_nav_link(); ?></div>
    <?php
} else {
    get_404_template();
}