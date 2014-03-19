<?php
get_header();

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
                <h2 class="entry-title"><?php the_title(); ?></h2>
                <?php
                if ((isset($price)) && ($price != '')) {
                    echo "<div class=\"goods-price-single\">";
                    echo __('Price:', 'gcat');
                    echo " $price</div>";
                }
                if ((isset($sku)) && ($sku != '')) {
                        echo "<div class=\"goods-sku\">";
                        echo __('SKU:', 'gcat');
                        echo " $sku</div>";
                    }
                if ((isset($descr)) && ($descr != '')) {
                    echo "<div class=\"goods-descr-single\">$descr</div>";
                }
                // show category
                $terms_list = wp_get_post_terms($post->ID, 'goods_category', array("fields" => "all"));
                echo __('Categories:&nbsp;', 'gcat');
                // count elements
                $count_terms = count($terms_list);
                foreach ($terms_list as $term) {
                    $term_link = get_term_link($term, 'goods_categoty');
                    if (is_wp_error($term_link))
                        continue;
                    // elements -1
                    --$count_terms;
                    // if > 0
                    if ($count_terms != 0) {
                        echo '<a href="' . $term_link . '">' . $term->name . '</a>, ';
                    } else {
                        // do not show comma at the last element
                        echo '<a href="' . $term_link . '">' . $term->name . '</a>';
                    }
                }
                ?>
            </header>
            <div class="clear"></div>
            <div class="entry-content">
                <?php
                the_content();
                ?>
            </div>
            <footer>
            </footer>
        </article>
        <?php
    }

    // Display navigation to next/previous
    ?>
    <div class="navigation"><?php posts_nav_link(); ?></div>
    <?php
} else {
    get_404_template();
}
get_footer();
