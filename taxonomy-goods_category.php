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

    // if is taxonomy query for 'goods_category' taxonomy, modify query so only posts in that collection (not posts in subcollections) are shown.
    if (taxonomy_exists('goods_category')) { //was is_taxonomy instead of taxonomy_exists()
        if (get_query_var('goods_category')) {
            $taxonomy_term_id = $wp_query->queried_object_id;
            $taxonomy = 'goods_category';
            $unwanted_children = get_term_children($taxonomy_term_id, $taxonomy);
            $unwanted_post_ids = get_objects_in_term($unwanted_children, $taxonomy);

            // merge with original query to preserve pagination, etc.
            query_posts(array_merge(array('post__not_in' => $unwanted_post_ids), $wp_query->query));
        }
    } //end of is_taxonomy

    echo '<h4>' . single_cat_title('', false) . '</h4>';
    echo '<p>' . category_description() . '</p>';


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

// Start the Loop 
    while (have_posts()) {
        the_post();
        ?>
        <div class="grid">
            <article <?php post_class(); ?>>
                <header>
                    <div class="goods-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                </header>
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
                    // get price and description from metabox
                    $price = get_post_meta(get_the_ID(), 'gc_price', true);
                    $descr = get_post_meta(get_the_ID(), 'gc_descr', true);
                    // show price and description
                    if ((isset($price)) && ($price != '')) {
                        echo "<div class=\"goods-price\">Price: $price</div>";
                    }
                    if ((isset($descr)) && ($descr != '')) {
                        echo "<div class=\"goods-descr\">$descr</div>";
                    }
                    ?>
                </div>
                <footer></footer>
            </article>
        </div>

        <?php
    }
} else {
    echo 'There are no products in the category.';
}
// Display navigation to next/previous pages when applicable
?>
<div class="clear"></div>
<div class="navigation"><?php posts_nav_link(); ?></div>
<p>The page is generated with taxomony-goods_category.php template</p>
<?php
get_footer();
