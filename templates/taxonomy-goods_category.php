<?php
/*
 * Template: Category page
 */

get_header();
echo '<div class="goods-catalog-container">';
load_template(dirname(__FILE__) . '/sidebar-goods.php');

$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
?>
<div class="goods-catalog">
    <div class="catalog-inner">
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
        if (have_posts()) { // fix 'undefined offset 0'
            $post = $posts[0];
        }
        ob_start();

        echo '<h2 class="single-category-title">' . single_cat_title('', false) . '</h2>';
        if (isset($catalog_option['show_category_descr_page'])) {
            echo '<p>' . category_description() . '</p>';
        }

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
        load_template(dirname(__FILE__) . '/loop-grid.php');
        ?>
        <div class="navigation">
            <?php
            // Display navigation to next/previous pages when applicable
            if (function_exists('goods_pagination'))
                goods_pagination();
            else
                posts_nav_link();
            ?>
        </div>
    </div>
</div>
<?php
echo '<div class="clear"></div>'; // fix for some themes
echo '</div>'; // goods-catalog-container
get_footer();
