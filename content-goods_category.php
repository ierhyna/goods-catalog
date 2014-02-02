<?php
echo "<div>";

foreach ($category_list as $categories_item) {

    // show categories titles
    echo '<div class="grid"><div class="goods-category-list-title"><a href="' . esc_url(get_term_link($categories_item, $categories_item->taxonomy)) . '" title="' . sprintf(__("Go to cetegory %s", 'gcat'), $categories_item->name) . '" ' . '>' . $categories_item->name . '</a></div> ';

    // show categories images
    echo '<div class="goods-category-thumb-container">';
    $terms = apply_filters('taxonomy-images-get-terms', '', array('taxonomy' => 'goods_category'));
    $flag = FALSE;
    if (!empty($terms)) {
        foreach ((array) $terms as $term) {
            if ($term->term_id == $categories_item->term_id) {
                $img = wp_get_attachment_image($term->image_id, 'thumbnail', '', array('class' => 'goods-category-thumb'));
                echo '<a href="' . esc_url(get_term_link($term, $term->taxonomy)) . '">' . $img . '</a>';
                $flag = TRUE;
            }
        }
        if ($flag == FALSE) {
            echo '<a href="' . esc_url(get_term_link($categories_item, $categories_item->taxonomy)) . '"><img class="goods-item-thumb" src="' . plugins_url('img/gc.png', __FILE__) . '" alt=""></a>';
        }
    }

    // show categories description
    echo '</div><p>' . $categories_item->category_description . '</p></div>';
}
echo "</div><div class=\"clear\"></div>";