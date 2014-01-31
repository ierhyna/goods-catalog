<?php
get_header();
$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
?>
<?php
if (have_posts()) {

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
} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
    echo '<h4>' . __('Blog Archives', THEME_NS) . '</h4>';
}

// sub-cats list
/* descriptive cat list */
$current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
$args = array(
    'parent' => $current_term->term_id,
    'taxonomy' => $current_term->taxonomy,
    'hide_empty' => 0,
    'hierarchical' => true,
    'depth' => 1
);

$catlist = get_categories($args);

echo "<div>";

foreach ($catlist as $categories_item) {
    echo '<div class="grid"><div class="goods-category-list-title"><a href="' . esc_url(get_term_link($categories_item, $categories_item->taxonomy)) . '" title="' . sprintf(__("Click the image to go to %s"), $categories_item->name) . '" ' . '>' . $categories_item->name . '</a></div> ';

    echo '<div class="categoryoverview clearfix">';
    $terms = apply_filters('taxonomy-images-get-terms', '', array('taxonomy' => 'goods_category'));
    if (!empty($terms)) {

        foreach ((array) $terms as $term) {
            if ($term->term_id == $categories_item->term_id) {
                echo '<a href="' . esc_url(get_term_link($term, $term->taxonomy)) . '" title="Нажмите, чтобы перейти в рубрику">' . wp_get_attachment_image($term->image_id, 'thumbnail');
                echo '</a>';
            }
        }
    }
    echo '</div>';
    echo '<p>' . $categories_item->category_description;
    echo '</p></div>';
}
echo "</div>";
/* end  */
// the end of sub-cats list
// error here
//theme_post_wrapper(array('content' => ob_get_clean(), 'class' => 'breadcrumbs'));
// Display navigation to next/previous pages when applicable
?>
<div class="navigation"><?php posts_nav_link(); ?></div>

<div class="clear"></div><?php
// Start the Loop 
while (have_posts()) {
    the_post();
    ?>
    <div class="grid">
        <article <?php post_class(); ?>>
            <header>
                <div class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
            </header>
            <div class="entry-content">
                <?php
                // show thumbnails
                if (has_post_thumbnail()) {
                    ?><a href="<?php the_permalink(); ?>">
                        <?php
                        the_post_thumbnail(array(150, 150));
                        ?>
                    </a>
                    <?php
                }
                // get price and description from metabox
                $price = get_post_meta(get_the_ID(), 'gc_price', true);
                $descr = get_post_meta(get_the_ID(), 'gc_descr', true);
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

// Display navigation to next/previous pages when applicable
?>
<div class="clear"></div>
<div class="navigation"><?php posts_nav_link(); ?></div>
<p>The page is generated with taxomony-goods_category.php template</p>
<?php
get_footer();
