<?php

/**
 * Template: Tag page
 *
 * You can edit this template by coping into your theme's folder
 */

$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

global $posts;
$post = $posts[0];

ob_start();

echo '<h2 class="single-category-title">' . single_cat_title('', false) . '</h2>';

// Include the list of products in grid.
goods_grid();
?>
<div class="navigation">
	<?php
	// Display navigation to next/previous pages when applicable
	if (function_exists('goods_pagination')) {
		goods_pagination();
	} else {
		posts_nav_link();
	}
	?>
</div>
