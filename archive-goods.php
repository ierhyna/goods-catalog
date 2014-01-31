<?php

get_header();
$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

//list terms in a given taxonomy using wp_list_categories (also useful as a widget if using a PHP Code plugin)

$taxonomy = 'goods_category';
$orderby = 'name';
$show_count = 0;      // 1 for yes, 0 for no
$pad_counts = 0;      // 1 for yes, 0 for no
$hierarchical = 1;      // 1 for yes, 0 for no
$title = '';
$hide_empty = 0; // 1 for yes, 0 for no

$args = array(
    'taxonomy' => $taxonomy,
    'orderby' => $orderby,
    'show_count' => $show_count,
    'pad_counts' => $pad_counts,
    'hierarchical' => $hierarchical,
    'title_li' => $title,
    'hide_empty' => $hide_empty
);
?>


<?php

// descriptive cat list
$cat_id = get_query_var('cat');
$catlist = get_categories('hide_empty=0&type=goods&taxonomy=goods_category&parent=0' . $cat_id);
echo "<div class='grid'>";

foreach ($catlist as $categories_item) {
    echo '<div class="list-catalog"><h3><a href="' . esc_url(get_term_link($categories_item, $categories_item->taxonomy)) . '" title="' . sprintf(__("Go to cetegory %s"), $categories_item->name) . '" ' . '>' . $categories_item->name . '</a> </h3> ';

    echo '<div class="categoryoverview clearfix">';
    $terms = apply_filters('taxonomy-images-get-terms', '', array('taxonomy' => 'goods_category'));
    if (!empty($terms)) {

        foreach ((array) $terms as $term) {
            if ($term->term_id == $categories_item->term_id) {
                print '<a href="' . esc_url(get_term_link($term, $term->taxonomy)) . '" title="Нажмите, чтобы перейти в рубрику">' . wp_get_attachment_image($term->image_id, 'thumbnail');
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
?>  
<p>The page is generated with archive-goods.php template</p>
<?php

get_footer();