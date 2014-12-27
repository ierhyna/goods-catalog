<?php

/*
 * Shortcodes to use with the catalog
 */

/*
 * Sitemap
 */

function GoodsSitemap() {
    $terms_args = array(
        'taxonomy' => 'goods_category', // get goods categories
        'orderby' => 'term_group',
        'hierarchical' => 1, // do not hide empty parent categories
    );
    $terms = get_terms('goods_category', $terms_args);
    if ($terms) :
        echo '<ul class="parents">';
        foreach ($terms as $term) :
            if ($parent = $term->parent) :
                $class = 'child';
            else :
                $class = 'parent';
            endif;

            echo '<li class="' . $class . '"><h3><a href="' . get_term_link($term) . '">' . $term->name . '</a></h3></li>';
            $parent = $term->parent;
            echo '<ul>';
            $query_args = array(
                'post_type' => 'goods',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'goods_category',
                        'field' => 'slug',
                        'terms' => $term->slug,
                        'include_children' => 0 // hide post from children categories in parent category
                    )
                )
            );
            $new = new WP_Query($query_args);
            while ($new->have_posts()) :
                $new->the_post();
                echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            endwhile;
            echo '</ul>';
        endforeach;
        echo '</ul>';
    endif;
}

add_shortcode('goods_sitemap', 'GoodsSitemap');


/*
 * Get newest products
 * Usage: [goods_newest number=3]
 */

// Add Shortcode
function GoodsNewest($atts) {

    // Attributes
    extract(shortcode_atts(
                    array(
        'number' => '3',
                    ), $atts)
    );

    // Code
    $output = '<div class="goods-insert">';
    $the_query = new WP_Query(array('post_type' => 'goods', 'posts_per_page' => $number));
    if ($the_query->have_posts()):
        while ($the_query->have_posts()):
            $the_query->the_post();
            $output .= goods_shortcode_output();
        endwhile;
    endif;
    wp_reset_query();
    return $output . '</div>';
}

add_shortcode('goods_newest', 'GoodsNewest');

// shortcode products from the category

/*
 * Categories Shortcode
 * Usage: [goods_categories]
 * many thanks to Alexander Chizhov & Pineapple Design Studio
 */

function GoodsCategories() {
 $terms_args = array(
  'taxonomy' => 'goods_category', // get goods categories
  'orderby' => 'term_group',
  'hierarchical' => 1, // do not hide empty parent categories
 );
 $terms = get_terms('goods_category', $terms_args);

 if ($terms) :
  echo '<div class="hp-categories" style="background-color:red;">';
  foreach ($terms as $term) :
   echo '<div class="hp-category-thumb">';
   $images = apply_filters('taxonomy-images-get-terms', '', array('taxonomy' => 'goods_category'));
   $flag = FALSE;
   if (!empty($images)) {
    foreach ((array) $images as $image) {
     if ($image->term_id == $term->term_id) {
      $img = wp_get_attachment_image($image->image_id, 'gc-category-thumb', '', array('class' => 'goods-category-thumb'));
      echo '<a href="' . esc_url(get_term_link($image, $image->taxonomy)) . '">' . $img . '</a>';
      $flag = TRUE;
     }
    }
    if ($flag == FALSE) {
     echo '<a href="' . esc_url(get_term_link($term, $term->taxonomy)) . '"><img class="goods-item-thumb" src="' . plugins_url('/img/gc.png', dirname(__FILE__)) . '" alt=""></a>';
    }
   } else {
    echo '<a href="' . esc_url(get_term_link($term, $term->taxonomy)) . '"><img class="goods-item-thumb" src="' . plugins_url('/img/gc.png', dirname(__FILE__)) . '" alt=""></a>';
   }
    echo '</div><div class="hp-category-title"><a href="' . get_term_link($term) . '">' . $term->name . '</a></div><div class="hp-category-more-link"><a href="'.get_term_link($term).'">'. __('Read more','gcat') .'</a></div>';
    $parent = $term->parent;
   endforeach;
  echo '</div>';
 endif;
}
add_shortcode('goods_categories', 'GoodsCategories');