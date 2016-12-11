<?php

/**
 * Function gets HTML templates, there is a default
 * templates and you can define a custom path
 *
 * @author Alex Chizhov <ac@alexchizhov.com>
 * @param string $custom_templates_path Path to custom templates
 * @return string HTML Template
 */
function goods_template($custom_templates_path = '') {
	if ($custom_templates_path && file_exists($custom_templates_path)) {
		require_once $custom_templates_path;
	} else {
		require_once GOODS_CATALOG_PLUGIN_INC . '/templates.php';
	}
}

/**
 * Loads default wrapper or custom theme wrapper
 * and uses it as goods catalog template
 *
 * @author Alex Chizhov <ac@alexchizhov.com>
 * @param string $template
 * @return string
 */
function goods_wrapper($template) {
	if (
		is_post_type_archive('goods') ||
		is_tax('goods_category') ||
		is_tax('goods_tag') ||
		is_singular('goods')
	) {

		// Check if there is a wrapper template in child theme
		if (file_exists(get_stylesheet_directory() . '/goods-wrapper.php')) {
			$template = get_stylesheet_directory() . '/goods-wrapper.php';
		} else { // If none found include default wrapper
			$template = GOODS_CATALOG_PLUGIN_TEMPLATES . '/wrapper.php';
		}
	}

	return $template;
}

add_filter('template_include', 'goods_wrapper', 99);

/**
 * Loads template for categories
 *
 * @author Alex Chizhov <ac@alexchizhov.com>
 * @param array $category_list
 * @return string HTML template
 */
function goods_category($category_list) {

	ob_start();

	// Check if there is a wrapper template in child theme
	if (file_exists(get_stylesheet_directory() . '/content-goods_category.php')) {

		include get_stylesheet_directory() . '/content-goods_category.php';
	}
	// If none found include default wrapper
	else {
		include GOODS_CATALOG_PLUGIN_TEMPLATES . '/content-goods_category.php';
	}

	$template = ob_get_clean();

	echo $template;
}

function goods_grid() {
	ob_start();

	if (file_exists(get_stylesheet_directory() . '/content-goods_grid.php')) {

		include get_stylesheet_directory() . '/content-goods_grid.php';
	}
	// If none found include default wrapper
	else {
		include GOODS_CATALOG_PLUGIN_TEMPLATES . '/content-goods_grid.php';
	}

	$template = ob_get_clean();

	echo $template;
}
