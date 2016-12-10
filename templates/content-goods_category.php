<?php

/**
 * The list of subcategories in grid
 *
 * Loaded in:
 * home-goods_catalog.php
 * taxonomy-goods_category.php
 *
 */

global $catalog_option;

// check if current taxonomy doesn't have childs
if (empty($category_list)) {
//     echo "There are no subcategories";
}
// if has
else { ?>
	<div class="goods-categories-container">
		<?php foreach ($category_list as $categories_item) { ?>
		<div class="grid">
			<?php // show categories titles ?>
			<div class="goods-category-list-title">
				<a href="<?= esc_url(get_term_link($categories_item, $categories_item->taxonomy)) ?>"
				title="<?= sprintf(__("Go to cetegory %s", 'goods-catalog'), $categories_item->name) ?>">
					<?= $categories_item->name ?>
				</a>
			</div>

			<?php
			// show categories images
			// if the setting is enabled
			if (isset($catalog_option['show_category_thumb'])) { ?>
				<div class="goods-category-thumb-container">
					<?php
					$terms = apply_filters('taxonomy-images-get-terms', '', array('taxonomy' => 'goods_category'));
					$flag = FALSE;
					if (!empty($terms)) {
						foreach ((array) $terms as $term) {
							if ($term->term_id == $categories_item->term_id) {
								$img = wp_get_attachment_image($term->image_id, 'gc-image-thumb', '', array('class' => 'goods-category-thumb'));
								?>
								<a href="<?= esc_url(get_term_link($term, $term->taxonomy)) ?>">
									<?= $img ?>
								</a>
								<?php
								$flag = TRUE;
							}
						}
						if ($flag == FALSE) {
							?>
							<a href="<?= esc_url(get_term_link($categories_item, $categories_item->taxonomy)) ?>">
								<img class="goods-item-thumb" src="<?= esc_url(GOODS_CATALOG_PLUGIN_URL . '/img/gc.png') ?>" alt="">
							</a>
							<?php
						}
					}
					// show images if plugin Taxonomy Images not installed
					else { ?>
						<a href="<?= esc_url(get_term_link($categories_item, $categories_item->taxonomy)) ?>">
							<img class="goods-item-thumb" src="<?= esc_url(GOODS_CATALOG_PLUGIN_URL . '/img/gc.png') ?>" alt="">
						</a>
					<?php } ?>
				</div><!-- end .goods-category-thumb-container -->
		<?php }
		// show categories description
		// if the setting is enabled
		if (isset($catalog_option['show_category_descr_grid'])) {
			echo '<p>' . $categories_item->category_description . '</p>';
		}
		echo '</div>';
	}
}
