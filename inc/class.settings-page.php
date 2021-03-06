<?php

/**
 * Options Page for Goods Catalog
 *
 * @since 0.9.0
 */

class Goods_Catalog_Settings_Page {

	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Start up
	 */
	public function __construct() {
		add_action('admin_menu', array($this, 'add_plugin_page'));
		add_action('admin_init', array($this, 'page_init'));
	}

	/**
	 * Add options page
	 */
	public function add_plugin_page() {
		// This page will be under "Settings"
		add_submenu_page(
			'edit.php?post_type=goods', __('Goods Catalog Settings', 'goods-catalog'), __('Goods Catalog Settings', 'goods-catalog'), 'manage_options', 'goods-setting-admin', array($this, 'create_admin_page')
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page() {
		// Set class property
		$this->options = get_option('goods_option_name');
		?>
		<div class="wrap">
		<?php screen_icon(); ?>
			<h2><?php echo __('Goods Catalog Plugin Settings', 'goods-catalog'); ?></h2>
			<form method="post" action="options.php">
				<?php
				// This prints out all hidden setting fields
				settings_fields('goods_option_group');
				do_settings_sections('goods-setting-admin');
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {
		register_setting(
			'goods_option_group', // Option group
			'goods_option_name', // Option name
			array($this, 'sanitize') // Sanitize
		);

		// Section Start
		add_settings_section(
			'info_section_id', // ID
			__('Plugin Info', 'goods-catalog'), // Title
			array($this, 'print_catalog_info'), // Callback
			'goods-setting-admin' // Page
		);

		// Section Start
		add_settings_section(
			'permalinks_section_id', // ID
			__('Catalog Permalinks Settings', 'goods-catalog'), // Title
			array($this, 'print_permalinks_section'), // Callback
			'goods-setting-admin' // Page
		);

		// Options Start
		add_settings_field(
			'gc_catalog_slug', // ID
			__('Catalog Home Page Slug', 'goods-catalog'), // Title
			array($this, 'gc_catalog_slug_callback'), // Callback
			'goods-setting-admin', // Page
			'permalinks_section_id' // Section
		);

		add_settings_field(
			'gc_category_slug', // ID
			__('Category Slug', 'goods-catalog'), // Title
			array($this, 'gc_category_slug_callback'), // Callback
			'goods-setting-admin', // Page
			'permalinks_section_id' // Section
		);

		add_settings_field(
			'gc_tag_slug', // ID
			__('Tag Slug', 'goods-catalog'), // Title
			array($this, 'gc_tag_slug_callback'), // Callback
			'goods-setting-admin', // Page
			'permalinks_section_id' // Section
		);

		// Section Start
		add_settings_section(
			'setting_section_id', // ID
			__('Common Settings', 'goods-catalog'), // Title
			array($this, 'print_section_info'), // Callback
			'goods-setting-admin' // Page
		);

		add_settings_field(
			'container_width', // ID
			__('Container Width', 'goods-catalog'), // Title
			array($this, 'container_width_callback'), // Callback
			'goods-setting-admin', // Page
			'setting_section_id' // Section
		);

		add_settings_field(
			'center_container', // ID
			__('Center Container', 'goods-catalog'), // Title
			array($this, 'center_container_callback'), // Callback
			'goods-setting-admin', // Page
			'setting_section_id' // Section
		);

		add_settings_field(
			'category_thumb_size', // ID
			__('Thumbnail size', 'goods-catalog'), // Title
			array($this, 'category_thumb_size_callback'), // Callback
			'goods-setting-admin', // Page
			'setting_section_id' // Section
		);

		// Categories Section Start
		add_settings_section(
			'categories_section_id', // ID
			__('Categories Settings', 'goods-catalog'), // Title
			array($this, 'print_categories_info'), // Callback
			'goods-setting-admin' // Page
		);

		// Options Start
		add_settings_field(
			'show_category_thumb', // ID
			__("Show category's thumbnails", 'goods-catalog'), // Title
			array($this, 'show_category_thumb_callback'), // Callback
			'goods-setting-admin', // Page
			'categories_section_id' // Section
		);

		add_settings_field(
			'show_category_descr', // ID
			__("Show category's description", 'goods-catalog'), // Title
			array($this, 'show_category_descr_callback'), // Callback
			'goods-setting-admin', // Page
			'categories_section_id' // Section
		);

		// Product Section Start
		add_settings_section(
			'product_section_id', // ID
			__('Product Settings', 'goods-catalog'), // Title
			array($this, 'print_product_info'), // Callback
			'goods-setting-admin' // Page
		);

		// Options Start

		add_settings_field(
			'items_per_page', // ID
			__('Products per page', 'goods-catalog'), // Title
			array($this, 'items_per_page_callback'), // Callback
			'goods-setting-admin', // Page
			'product_section_id' // Section
		);

		add_settings_field(
			'goods_orderby', // ID
			__('Goods order by', 'goods-catalog'), // Title
			array($this, 'goods_orderby_callback'), // Callback
			'goods-setting-admin', // Page
			'product_section_id' // Section
		);

		add_settings_field(
			'goods_order', // ID
			__('Goods order', 'goods-catalog'), // Title
			array($this, 'goods_order_callback'), // Callback
			'goods-setting-admin', // Page
			'product_section_id' // Section
		);

		add_settings_field(
			'show_product_descr', // ID
			__("Show product's short description", 'goods-catalog'), // Title
			array($this, 'show_product_descr_callback'), // Callback
			'goods-setting-admin', // Page
			'product_section_id' // Section
		);

		add_settings_field(
			'show_product_sku', // ID
			__("Show product's SKU", 'goods-catalog'), // Title
			array($this, 'show_product_sku_callback'), // Callback
			'goods-setting-admin', // Page
			'product_section_id' // Section
		);
		add_settings_field(
			'gc_product_price_prefix', // ID
			__('Product Price Prefix', 'goods-catalog'), // Title
			array($this, 'gc_product_price_prefix_callback'), // Callback
			'goods-setting-admin', // Page
			'product_section_id' // Section
		);
		add_settings_field(
			'gc_product_price_postfix', // ID
			__('Product Price Postfix', 'goods-catalog'), // Title
			array($this, 'gc_product_price_postfix_callback'), // Callback
			'goods-setting-admin', // Page
			'product_section_id' // Section
		);

		add_settings_field(
			'info_width', // ID
			__('Info Container Width on Product Page', 'goods-catalog'), // Title
			array($this, 'info_width_callback'), // Callback
			'goods-setting-admin', // Page
			'product_section_id' // Section
		);

		// Section Start
		add_settings_section(
			'sidebar_section_id', // ID
			__('Sidebar Settings', 'goods-catalog'), // Title
			array($this, 'print_section_sidebar'), // Callback
			'goods-setting-admin' // Page
		);

		// Options Start
		add_settings_field(
			'use_sidebar', // ID
			__("Use special sidebar", 'goods-catalog'), // Title
			array($this, 'use_sidebar_callback'), // Callback
			'goods-setting-admin', // Page
			'sidebar_section_id' // Section
		);
		add_settings_field(
			'sidebar_width', // ID
			__('Sidebar Width', 'goods-catalog'), // Title
			array($this, 'sidebar_width_callback'), // Callback
			'goods-setting-admin', // Page
			'sidebar_section_id' // Section
		);
	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize($input) {
		$new_input = array();

		if (isset($input['gc_catalog_slug']))
			$new_input['gc_catalog_slug'] = sanitize_text_field($input['gc_catalog_slug']);

		if (isset($input['gc_category_slug']))
			$new_input['gc_category_slug'] = sanitize_text_field($input['gc_category_slug']);

		if (isset($input['gc_tag_slug']))
			$new_input['gc_tag_slug'] = sanitize_text_field($input['gc_tag_slug']);

		if (isset($input['items_per_page']))
			$new_input['items_per_page'] = absint($input['items_per_page']);

		if (isset($input['goods_orderby']))
			$new_input['goods_orderby'] = sanitize_text_field($input['goods_orderby']);

		if (isset($input['goods_order']))
			$new_input['goods_order'] = sanitize_text_field($input['goods_order']);

		if (isset($input['container_width']))
			$new_input['container_width'] = absint($input['container_width']);

		if (isset($input['center_container']))
			$new_input['center_container'] = absint($input['center_container']);

		if (isset($input['info_width']))
			$new_input['info_width'] = absint($input['info_width']);

		if (isset($input['show_category_thumb']))
			$new_input['show_category_thumb'] = absint($input['show_category_thumb']);

		if (isset($input['category_thumb_size_w']))
			$new_input['category_thumb_size_w'] = absint($input['category_thumb_size_w']);

		if (isset($input['category_thumb_size_h']))
			$new_input['category_thumb_size_h'] = absint($input['category_thumb_size_h']);

		if (isset($input['show_category_descr_grid']))
			$new_input['show_category_descr_grid'] = absint($input['show_category_descr_grid']);

		if (isset($input['show_category_descr_page']))
			$new_input['show_category_descr_page'] = absint($input['show_category_descr_page']);

		if (isset($input['show_product_descr_grid']))
			$new_input['show_product_descr_grid'] = absint($input['show_product_descr_grid']);

		if (isset($input['show_product_descr_page']))
			$new_input['show_product_descr_page'] = absint($input['show_product_descr_page']);

		if (isset($input['show_product_sku_grid']))
			$new_input['show_product_sku_grid'] = absint($input['show_product_sku_grid']);

		if (isset($input['show_product_sku_page']))
			$new_input['show_product_sku_page'] = absint($input['show_product_sku_page']);

		if (isset($input['gc_product_price_prefix']))
			$new_input['gc_product_price_prefix'] = esc_html($input['gc_product_price_prefix']);

		if (isset($input['gc_product_price_postfix']))
			$new_input['gc_product_price_postfix'] = esc_html($input['gc_product_price_postfix']);

		if (isset($input['use_sidebar']))
			$new_input['use_sidebar'] = absint($input['use_sidebar']);

		if (isset($input['sidebar_width']))
			$new_input['sidebar_width'] = absint($input['sidebar_width']);

		return $new_input;
	}

	/**
	 * Print the Section text
	 */
	public function print_catalog_info() {
		print '<p>' . __('You can see the catalog on your site at:', 'goods-catalog') . ' <a href="' . get_post_type_archive_link('goods') . '">' .  get_post_type_archive_link('goods') .  '</a></p>';
		print '<p>';
		print __("Don't know how to set up the catalog? The instructions are available here: <a href='http://oriolo.wordpress.com/2014/03/25/goods-catalog-wordpress-plugin-that-creates-catalog-of-products'>in English</a>, <a href='http://oriolo.ru/dev/goods-catalog/quick-start'>in Russian</a>", 'goods-catalog');
		print '</p>';
		print '<p>';
		print __("Any problems or questions? Visit the plugin's <a href='http://wordpress.org/support/plugin/goods-catalo'>support forum</a> at WordPress.org", 'goods-catalog');
		print '</p>';
	}

	public function print_permalinks_section() {
		print __('Please notice, that every time you change permalinks you should also press "Save" on the <a href="%s">Permalinks Settings page</a>, and maybe update the menu items', 'goods-catalog');
	}

	public function print_section_info() {
		print __('The following settings will be applied to all catalog pages', 'goods-catalog');
	}

	public function print_categories_info() {
		print __('Set up the goods categories here', 'goods-catalog');
	}

	public function print_product_info() {
		print __('Set up the products here', 'goods-catalog');
	}

	public function print_section_sidebar() {
		print __('You can use special sidebar only in catalog pages. Please remember that sidebar from your theme can be not supported by Goods Catalog plugin', 'goods-catalog');
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function gc_catalog_slug_callback() {
		printf(
			'<input type="text" id="gc_catalog_slug" name="goods_option_name[gc_catalog_slug]" value="%s" />', isset($this->options['gc_catalog_slug']) ? esc_attr($this->options['gc_catalog_slug']) : 'catalog'
		);
		_e( ' by default: catalog', 'goods-catalog');
		echo '<p class="description">';
		$url = admin_url( 'options-permalink.php' );
		$text = __( 'Enter the slug of catalog home page', 'goods-catalog');
		printf($text, $url);
		echo '</p>';
	}

	public function gc_category_slug_callback() {
		printf(
			'<input type="text" id="gc_category_slug" name="goods_option_name[gc_category_slug]" value="%s" />', isset($this->options['gc_category_slug']) ? esc_attr($this->options['gc_category_slug']) : 'goods_category'
		);
		_e( ' by default: goods_category', 'goods-catalog' );
		echo '<p class="description">';
		$url = admin_url( 'options-permalink.php' );
		$text = '';
		printf($text, $url);
		echo '</p>';
	}

	public function gc_tag_slug_callback() {
		printf(
			'<input type="text" id="gc_tag_slug" name="goods_option_name[gc_tag_slug]" value="%s" />', isset($this->options['gc_tag_slug']) ? esc_attr($this->options['gc_tag_slug']) : 'goods_tag'
		);
		_e( ' by default: goods_tag', 'goods-catalog');
		echo '<p class="description">';
		$url = admin_url( 'options-permalink.php' );
		$text = '';
		printf($text, $url);
		echo '</p>';
	}

	public function items_per_page_callback() {
		printf(
			'<input type="number" step="1" id="items_per_page" class="small-text" name="goods_option_name[items_per_page]" value="%s" />', isset($this->options['items_per_page']) ? esc_attr($this->options['items_per_page']) : '12'
		);
	}

	public function goods_orderby_callback() {
		$orderby_options = array(
			'none' => __('none', 'goods-catalog'),
			'ID' => __('ID', 'goods-catalog'),
			'author' => __('author', 'goods-catalog'),
			'title' => __('title', 'goods-catalog'),
			'name' => __('slug', 'goods-catalog'),
			'date' => __('date', 'goods-catalog'),
			'modified' => __('last modified', 'goods-catalog'),
			'rand' => __('random', 'goods-catalog'),
			'comment_count' => __('number of comments', 'goods-catalog'),
			'menu_order' => __('menu order', 'goods-catalog'),
			'meta_value_num' => __('price', 'goods-catalog')
		);

		echo '<select id="goods_orderby" name="goods_option_name[goods_orderby]" class="small-text">';
		foreach ($orderby_options as $key => $value) {
			echo '<option value="' . $key . '"' . selected( $this->options['goods_orderby'], $key ) . '>' . $value . '</option>';
		}
		echo '</select>';
	}

	public function goods_order_callback() {
		echo '<p>
		<input type="radio" id="goods_order_asc" name="goods_option_name[goods_order]" value="ASC" checked ' . checked ( $this->options['goods_order'], 'ASC', false) . '/>' . __('ASC', 'goods-catalog') . '
		</p>
		<p>
		<input type="radio" id="goods_order_decs" name="goods_option_name[goods_order]" value="DESC" ' . checked ( $this->options['goods_order'], 'DESC', false) . '/>' . __('DESC', 'goods-catalog') .
		'</p>';
	}

	public function container_width_callback() {
		printf(
			'<input type="number" id="container_width" class="small-text" name="goods_option_name[container_width]" value="%s" />', isset($this->options['container_width']) ? esc_attr($this->options['container_width']) : '100'
		);
		echo '%, ' . __('by default 100', 'goods-catalog');
		echo '<p class="description">' . __("If the catalog's container is bigger than your theme's container, change it here", "goods-catalog") . '</p>';
	}

	public function center_container_callback() {
		?>
		<input type="checkbox" name="goods_option_name[center_container]" id="center_container" value="1" <?php checked(isset($this->options['center_container']), 1); ?> />
		<?php
		echo  '<p class="description">' . __("Add 'margin: 0 auto;' to the container. If you have changed container's width, you should also turn on this option", "goods-catalog") . '</p>';
	}

	public function info_width_callback() {
		printf(
			'<input type="number" id="info_width" class="small-text" name="goods_option_name[info_width]" value="%s" />', isset($this->options['info_width']) ? esc_attr($this->options['info_width']) : '60'
		);
		echo '%, ' . __('by default 60', 'goods-catalog');
		echo '<p class="description">'  . __("Set width of Product Info Container on single product page. In that container are located: name, price, SKU, short description, categories and tags of the product. With the smaller width the container will be on the right of product thumbnail, with the bigger width it will be under product thumbnail", "goods-catalog") . '</p>';
	}

	/*
	 * Category section
	 */
	public function show_category_thumb_callback() {
		?>
		<p><input type="checkbox" name="goods_option_name[show_category_thumb]" id="show_category_thumb" value="1" <?php checked(isset($this->options['show_category_thumb']), 1); ?> />
		<?php
		echo __('in grid', 'goods-catalog') . '</p>';
		echo '<p class="description">' . __("If you don't need thumbnails for the categories, please uncheck this option", 'goods-catalog') . '</p>';
	}

	public function category_thumb_size_callback() {
		_e('Width: ', 'goods-catalog');
		printf(
			'<input type="number" id="category_thumb_size_w" class="small-text" name="goods_option_name[category_thumb_size_w]" value="%s" />', isset($this->options['category_thumb_size_w']) ? esc_attr($this->options['category_thumb_size_w']) : '150'
		);
		_e('px', 'goods-catalog');
		echo ' ';
		_e('Height: ', 'goods-catalog');
		printf(
			'<input type="number" id="category_thumb_size_h" class="small-text" name="goods_option_name[category_thumb_size_h]" value="%s" />', isset($this->options['category_thumb_size_h']) ? esc_attr($this->options['category_thumb_size_h']) : '150'
		);
		_e('px', 'goods-catalog');

		echo '<p class="description">' . __("Set size of thumbnails for categories and products. After that please use <a href='http://wordpress.org/plugins/regenerate-thumbnails/'>Regenerate Thumbnails</a> plugin to rebuild images' sizes. Please notice, that default images for category and product will not be resized", "goods-catalog") . '</p>';
	}

	public function show_category_descr_callback() {
			?>
		<p><input type="checkbox" name="goods_option_name[show_category_descr_grid]" id="show_category_descr_grid" value="1" <?php checked(isset($this->options['show_category_descr_grid']), 1); ?> />
			<?php
			echo __('in grid', 'goods-catalog') . '</p>';
			?>
		<p><input type="checkbox" name="goods_option_name[show_category_descr_page]" id="show_category_descr_page" value="1" <?php checked(isset($this->options['show_category_descr_page']), 1); ?> />
			<?php
			echo __('in category page', 'goods-catalog') . '</p>';
			echo '<p class="description">' . __('If you don\'t need description for the categories, please uncheck this option', 'goods-catalog') . '</p>';
	}

	/*
	 * Product section
	 */
	public function show_product_descr_callback() {
		?>
	<p><input type="checkbox" name="goods_option_name[show_product_descr_grid]" id="show_product_descr_grid" value="1" <?php checked(isset($this->options['show_product_descr_grid']), 1); ?> />
		<?php
		echo __('in grid', 'goods-catalog') . '</p>';
		?>
	<p><input type="checkbox" name="goods_option_name[show_product_descr_page]" id="show_product_descr_page" value="1" <?php checked(isset($this->options['show_product_descr_page']), 1); ?> />
		<?php
		echo __('in single product page', 'goods-catalog') . '</p>';
	}

	public function show_product_sku_callback() {
		?>
	<p><input type="checkbox" name="goods_option_name[show_product_sku_grid]" id="show_product_sku_grid" value="1" <?php checked(isset($this->options['show_product_sku_grid']), 1); ?> />
		<?php
		echo __('in grid', 'goods-catalog') . '</p>';
		?>
	<p><input type="checkbox" name="goods_option_name[show_product_sku_page]" id="show_product_sku_page" value="1" <?php checked(isset($this->options['show_product_sku_page']), 1); ?> />
		<?php
		echo __('in single product page', 'goods-catalog') . '</p>';
	}

	public function gc_product_price_prefix_callback() {
		printf(
			'<input type="text" id="gc_product_price_prefix" name="goods_option_name[gc_product_price_prefix]" value="%s" />', isset($this->options['gc_product_price_prefix']) ? esc_attr($this->options['gc_product_price_prefix']) : ''
		);
		_e( ' by default: empty', 'goods-catalog' );
		echo '<p class="description">';
		$url = admin_url( 'options-permalink.php' );
		$text = __( "Currency prefix, for ex.: &#36; or &#128;. Just leave it emply if you don't need prefix", 'goods-catalog');
		printf($text, $url);
		echo '</p>';
	}

	public function gc_product_price_postfix_callback() {
		printf(
			'<input type="text" id="gc_product_price_postfix" name="goods_option_name[gc_product_price_postfix]" value="%s" />', isset($this->options['gc_product_price_postfix']) ? esc_attr($this->options['gc_product_price_postfix']) : ''
		);
		_e( ' by default: empty', 'goods-catalog' );
		echo '<p class="description">';
		$url = admin_url( 'options-permalink.php' );
		$text = __( "Currency postfix, for ex.: RUB. Just leave it emply if you don't need postfix", 'goods-catalog');
		printf($text, $url);
		echo '</p>';
	}

	/*
	 * Sidebar section
	 */
	public function use_sidebar_callback() {
		?>
		<input type="checkbox" name="goods_option_name[use_sidebar]" id="use_sidebar" value="1" <?php checked(isset($this->options['use_sidebar']), 1); ?> />
		<?php
		echo '<p class="description">' . __("Please turn the option on, if you would like to use the special sidebar for catalog", "goods-catalog") . '</p>';
	}

	public function sidebar_width_callback() {
		printf(
			'<input type="number" id="sidebar_width" class="small-text" name="goods_option_name[sidebar_width]" value="%s" />', isset($this->options['sidebar_width']) ? esc_attr($this->options['sidebar_width']) : '20'
		);
		echo '%, ' . __('by default 20', 'goods-catalog');
		echo '<p class="description">' . __("Set width of the Sidebar", "goods-catalog") . '</p>';
	}
}

if (is_admin()) {
	$goods_settings_page = new Goods_Catalog_Settings_Page();
}
