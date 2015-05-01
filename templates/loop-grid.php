<?php
/*
 * Loop Grid : Products on categories pages
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
                    echo show_the_thumbnail();

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
