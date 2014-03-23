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
                    my_breadcrumb($post->post_parent);
                } else {
                    my_breadcrumb();
                }
            } else {
                print ' ';
            }
            ?>
        </div>

        <?php
        // start functions
        $price = get_post_meta(get_the_ID(), 'gc_price', true);
        $sku = get_post_meta(get_the_ID(), 'gc_sku', true);
        $descr = get_post_meta(get_the_ID(), 'gc_descr', true);
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
                    echo '<img class="goods-item-thumb" src="' . plugins_url('img/gi.png', __FILE__) . '" alt="">';
                }
                echo '</div>';
                ?>
                <div class="goods-info">
                    <h2 class="entry-title"><?php the_title(); ?></h2>
                    <?php
                    if ((isset($price)) && ($price != '')) {
                        echo "<p class=\"goods-price-single\">";
                        echo __('Price:', 'gcat');
                        echo " $price</p>";
                    }
                    if ((isset($sku)) && ($sku != '')) {
                        echo "<p class=\"goods-sku\">";
                        echo __('SKU:', 'gcat');
                        echo " $sku</p>";
                    }
                    if ((isset($descr)) && ($descr != '')) {
                        echo "<p class=\"goods-descr-single\">$descr</p>";
                    }

                    // show category
                    echo '<p>';
                    get_goods_taxomonies('goods_category', $post->ID);
                    echo '</p>';

                    // show tags
                    echo '<p>';
                    get_goods_taxomonies('goods_tag', $post->ID);
                    echo '</p>';
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
echo '</div>';
get_footer();
