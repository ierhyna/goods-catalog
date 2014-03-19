<?php
get_header();
$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

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

    // show sub-categories only in first page, if paged
    if (!is_paged()) {
        // show sub-categories list
        $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
        $args = array(
            'parent' => $current_term->term_id,
            'taxonomy' => $current_term->taxonomy,
            'hide_empty' => 0,
            'hierarchical' => true,
            'depth' => 1
        );

        $category_list = get_categories($args);
        // include
        include 'content-goods_category.php';

        echo "<hr>";
    }

// Start the Loop
while ( have_posts() ) {
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
                        echo "<div class=\"goods-descr\">$descr</div>";
                    }
                    ?>
                </div>
            </article>
        </div>

        <?php
    }
}
 else {
    echo __('There are no products in the category.', 'gcat');
}
// Display navigation to next/previous pages when applicable
?>

<div class="clear"></div>
<div class="navigation">
    <?php if (function_exists('goods_pagination'))
        goods_pagination();
    else
        posts_nav_link();
    ?>
</div>
<?php
get_footer();
