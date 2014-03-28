<?php
/*
 * Options Page for Goods Catalog
 */

class GoodsSettingsPage {

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
                'edit.php?post_type=goods', __('Goods Catalog Settings', 'gcat'), __('Goods Catalog Settings', 'gcat'), 'manage_options', 'goods-setting-admin', array($this, 'create_admin_page')
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
            <h2><?php echo __('Goods Catalog Plugin Settings', 'gcat'); ?></h2>           
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
                __('Plugin Info', 'gcat'), // Title
                array($this, 'print_catalog_info'), // Callback
                'goods-setting-admin' // Page
        );

// Section Start
        add_settings_section(
                'setting_section_id', // ID
                __('Catalog View Settings', 'gcat'), // Title
                array($this, 'print_section_info'), // Callback
                'goods-setting-admin' // Page
        );

        // Options Start
        add_settings_field(
                'items_per_page', // ID
                __('Products per page', 'gcat'), // Title 
                array($this, 'items_per_page_callback'), // Callback
                'goods-setting-admin', // Page
                'setting_section_id' // Section           
        );

        add_settings_field(
                'container_width', // ID
                __('Container Width', 'gcat'), // Title 
                array($this, 'container_width_callback'), // Callback
                'goods-setting-admin', // Page
                'setting_section_id' // Section           
        );
        add_settings_field(
                'center_container', // ID
                __('Center Container', 'gcat'), // Title 
                array($this, 'center_container_callback'), // Callback
                'goods-setting-admin', // Page
                'setting_section_id' // Section           
        );
        add_settings_field(
                'info_width', // ID
                __('Info Container Width on Product Page', 'gcat'), // Title 
                array($this, 'info_width_callback'), // Callback
                'goods-setting-admin', // Page
                'setting_section_id' // Section           
        );
        
// Categories Section Start
        add_settings_section(
                'categories_section_id', // ID
                __('Categories View Settings', 'gcat'), // Title
                array($this, 'print_categories_info'), // Callback
                'goods-setting-admin' // Page
        );        
        
        // Options Start
        add_settings_field(
                'show_category_thumb', // ID
                __('Show category\'s thumbnails', 'gcat'), // Title 
                array($this, 'show_category_thumb_callback'), // Callback
                'goods-setting-admin', // Page
                'categories_section_id' // Section           
        );
        
        add_settings_field(
                'show_category_descr', // ID
                __('Show category\'s description', 'gcat'), // Title 
                array($this, 'show_category_descr_callback'), // Callback
                'goods-setting-admin', // Page
                'categories_section_id' // Section           
        );

// Product Section Start
        add_settings_section(
                'product_section_id', // ID
                __('Product View Settings', 'gcat'), // Title
                array($this, 'print_product_info'), // Callback
                'goods-setting-admin' // Page
        );
        
        // Options Start    
        add_settings_field(
                'show_product_descr', // ID
                __('Show product\'s short description', 'gcat'), // Title 
                array($this, 'show_product_descr_callback'), // Callback
                'goods-setting-admin', // Page
                'product_section_id' // Section           
        );
        
        add_settings_field(
                'show_product_sku', // ID
                __('Show product\'s SKU', 'gcat'), // Title 
                array($this, 'show_product_sku_callback'), // Callback
                'goods-setting-admin', // Page
                'product_section_id' // Section           
        );

// Section Start
        add_settings_section(
                'sidebar_section_id', // ID
                __('Sidebar Settings', 'gcat'), // Title
                array($this, 'print_section_sidebar'), // Callback
                'goods-setting-admin' // Page
        );

        // Options Start
        add_settings_field(
                'use_sidebar', // ID
                __('Use plugin\'s sidebar', 'gcat'), // Title 
                array($this, 'use_sidebar_callback'), // Callback
                'goods-setting-admin', // Page
                'sidebar_section_id' // Section           
        );
        add_settings_field(
                'sidebar_width', // ID
                __('Sidebar Width', 'gcat'), // Title 
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
        if (isset($input['items_per_page']))
            $new_input['items_per_page'] = absint($input['items_per_page']);

        if (isset($input['container_width']))
            $new_input['container_width'] = absint($input['container_width']);

        if (isset($input['center_container']))
            $new_input['center_container'] = absint($input['center_container']);

        if (isset($input['info_width']))
            $new_input['info_width'] = absint($input['info_width']);
        
        if (isset($input['show_category_thumb']))
            $new_input['show_category_thumb'] = absint($input['show_category_thumb']);
        
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
        print '<p>' . __( 'You can see the catalog on your site at:', 'gcat' ) . ' <a href="' . get_home_url() . '/catalog">' . get_home_url() . '/catalog</a></p>';
        print __('<p>Don\' know how to set up the catalog? The instructions are available here: <a href="http://oriolo.wordpress.com/2014/03/25/goods-catalog-wordpress-plugin-that-creates-catalog-of-products/">in English</a>, <a href="http://oriolo.ru/goods-catalog/">in Russian</a></p>', 'gcat');
        print __('<p>Any problems or questions? Visit the plugin\'s <a href="http://wordpress.org/support/plugin/goods-catalog">support forum</a> at WordPress.org</p>', 'gcat');
    }

    public function print_section_info() {
        print __('Enter your settings below:', 'gcat');
    }
    
    public function print_categories_info() {
        print __('Enter your settings below:', 'gcat');
    }

    public function print_product_info() {
        print __('Enter your settings below:', 'gcat');
    }

    public function print_section_sidebar() {
        print __('If your theme\'s sidebar loads correctly on the catalog pages, you do not need to change anything here', 'gcat');
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function items_per_page_callback() {
        printf(
                '<input type="number" step="1" id="items_per_page" class="small-text" name="goods_option_name[items_per_page]" value="%s" />', isset($this->options['items_per_page']) ? esc_attr($this->options['items_per_page']) : '12'
        );
    }

    public function container_width_callback() {
        printf(
                '<input type="number" id="container_width" class="small-text" name="goods_option_name[container_width]" value="%s" />', isset($this->options['container_width']) ? esc_attr($this->options['container_width']) : '100'
        );
        echo '%, ' . __('by default 100', 'gcat');
        echo "<p>" . __("If the catalog's container is bigger than your theme's container, change it here", "gcat") . "</p>";
    }

    public function center_container_callback() {
        ?>
        <input type="checkbox" name="goods_option_name[center_container]" id="center_container" value="1" <?php checked(isset($this->options['center_container']), 1); ?> />
        <?php
        echo "<p>" . __("Add 'margin: 0 auto;' to the container. If you have changed container's width, you should also turn on this option", "gcat") . "</p>";
    }

    public function info_width_callback() {
        printf(
                '<input type="number" id="info_width" class="small-text" name="goods_option_name[info_width]" value="%s" />', isset($this->options['info_width']) ? esc_attr($this->options['info_width']) : '60'
        );
        echo '%, ' . __('by default 60', 'gcat');
        echo "<p>" . __("Set width of Product Info Container on single product page. In that container are located: name, price, SKU, short description, categories and tags of the product. With the smaller width the container will be on the right of product thumbnail, with the bigger width it will be under product thumbnail", "gcat") . "</p>";
    }
    
    /*
     * Category section
     */
    
    public function show_category_thumb_callback() {    
        ?>
        <p><input type="checkbox" name="goods_option_name[show_category_thumb]" id="show_category_thumb" value="1" <?php checked(isset($this->options['show_category_thumb']), 1); ?> />
        <?php
        echo __('in grid', 'gcat') . '</p>';
        echo '<p>' . __( 'If you don\'t need thumbnails for the categories, please uncheck this option', 'gcat' ) . '</p>';
    }
    
    public function show_category_descr_callback() {
        ?>
        <p><input type="checkbox" name="goods_option_name[show_category_descr_grid]" id="show_category_descr_grid" value="1" <?php checked(isset($this->options['show_category_descr_grid']), 1); ?> />
        <?php
        echo __('in grid', 'gcat') . '</p>';
        ?>
        <p><input type="checkbox" name="goods_option_name[show_category_descr_page]" id="show_category_descr_page" value="1" <?php checked(isset($this->options['show_category_descr_page']), 1); ?> />
        <?php
        echo __('in category page', 'gcat') . '</p>';
        echo '<p>' . __( 'If you don\'t need description for the categories, please uncheck this option', 'gcat' ) . '</p>';
    }
    
    /*
     * Product section
     */
    
    public function show_product_descr_callback() {
        ?>
        <p><input type="checkbox" name="goods_option_name[show_product_descr_grid]" id="show_product_descr_grid" value="1" <?php checked(isset($this->options['show_product_descr_grid']), 1); ?> />
        <?php
        echo __('in grid', 'gcat') . '</p>';
        ?>
        <p><input type="checkbox" name="goods_option_name[show_product_descr_page]" id="show_product_descr_page" value="1" <?php checked(isset($this->options['show_product_descr_page']), 1); ?> />
        <?php
        echo __('in single product page', 'gcat') . '</p>';
    }
    
    public function show_product_sku_callback() {
        ?>
        <p><input type="checkbox" name="goods_option_name[show_product_sku_grid]" id="show_product_sku_grid" value="1" <?php checked(isset($this->options['show_product_sku_grid']), 1); ?> />
        <?php
        echo __('in grid', 'gcat') . '</p>';
        ?>
        <p><input type="checkbox" name="goods_option_name[show_product_sku_page]" id="show_product_sku_page" value="1" <?php checked(isset($this->options['show_product_sku_page']), 1); ?> />
        <?php
        echo __('in single product page', 'gcat') . '</p>';
    }

    /*
     * Sidebar section
     */

    public function use_sidebar_callback() {
        ?>
        <input type="checkbox" name="goods_option_name[use_sidebar]" id="use_sidebar" value="1" <?php checked(isset($this->options['use_sidebar']), 1); ?> />
        <?php
        echo "<p>" . __("WARNING: the plugin's sidebar is under testing. If this option brokes your layot, just uncheck it, and please write me a letter with the theme name: sokolovskaja.irina@gmail.com. I'll be extremely thankful if you also would attach some screenshots", "gcat") . "</p>";
    }

    public function sidebar_width_callback() {
        printf(
                '<input type="number" id="sidebar_width" class="small-text" name="goods_option_name[sidebar_width]" value="%s" />', isset($this->options['sidebar_width']) ? esc_attr($this->options['sidebar_width']) : '20'
        );
        echo '%, ' . __('by default 20', 'gcat');
        echo "<p>" . __("Set width of the Sidebar", "gcat") . "</p>";
    }

}

if (is_admin()) {
    $goods_settings_page = new GoodsSettingsPage();
}