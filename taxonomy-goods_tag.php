<?php
/*
 * Template: Tag page
 */

get_header();
echo '<div class="goods-catalog-container">';
load_template(dirname(__FILE__) . '/sidebar-goods.php');

$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
?>
<div class="goods-catalog">
    <div class="catalog-inner">
        <?php
        if (have_posts()) {
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
            global $posts;
            $post = $posts[0];

            ob_start();

            echo '<div class="single-category-title">' . single_cat_title('', false) . '</div>';
            echo '<p>' . category_description() . '</p>';


// Start the Loop
            while (have_posts()) {
                the_post();
                ?>
                <div class="grid">
                    <article <?php post_class(); ?>>
                        <div class="goods-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                        <div class="goods-item-content">
                            <?php
                            // show thumbnails
                            echo '<div class="goods-item-thumb-container">';
                            if (has_post_thumbnail()) {
                                echo '<a href="' . get_permalink() . '">';
                                the_post_thumbnail(array(150, 150), array('class' => 'goods-item-thumb'));
                                echo '</a>';
                            } else {
                                // show default image if the thumbnail is not found
                                echo '<a href="' . get_permalink() . '"><img class="goods-item-thumb" src="' . plugins_url('img/gi.png', __FILE__) . '" alt=""></a>';
                            }
                            echo '</div>';
                            // get fields from metabox
                            $price = get_post_meta(get_the_ID(), 'gc_price', true);
                            $sku = get_post_meta(get_the_ID(), 'gc_sku', true);
                            $descr = get_post_meta(get_the_ID(), 'gc_descr', true);

                            // show fields values
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
                                echo "<p class=\"goods-descr\">$descr</p>";
                            }
                            ?>
                        </div>
                    </article>
                </div>

                <?php
            }
        } else {
            echo __('There are no products in the category.', 'gcat');
        }
// Display navigation to next/previous pages when applicable
        ?>

        <div class="clear"></div>
        <div class="navigation">
            <?php
            if (function_exists('goods_pagination'))
                goods_pagination();
            else
                posts_nav_link();
            ?>
        </div>
    </div>
</div>
<?php
echo '</div>';
get_footer();
