<?php

/**
 * Products in grid
 * 
 * Displays products in grid. 
 * Loaded in:
 * taxonomy-goods_category.php
 * taxonomy-goods_tags.php
 * 
 */

if (have_posts()) {
    while (have_posts()) {
        the_post();
        ?>
        <div class="grid">
            <article <?php post_class(); ?>>
                <div class="goods-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                <div class="goods-item-content">
                    <?php
                    // show thumbnails
                    echo get_the_product_thumbnail();

                    // show products
                    echo get_the_product_price();
                    global $catalog_option;
                    if (isset($catalog_option['show_product_sku_grid'])) {
                        show_the_product_sku();
                    }
                    if (isset($catalog_option['show_product_descr_grid'])) {
                        show_the_product_desrc();
                    }
                    ?>
                </div>
            </article>
        </div>

        <?php
    }
} else {
    // echo __('There are no products in the category.', 'gcat');
}
echo '<div class="clear"></div>';
