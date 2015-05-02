<?php
/*
 * Template: Tag page
 */

$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

global $posts;
$post = $posts[0];

ob_start();

echo '<h2 class="single-category-title">' . single_cat_title('', false) . '</h2>';

load_template(dirname(__FILE__) . '/content-goods_grid.php');
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
