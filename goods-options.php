<?php

/* 
 * Options Page for Goods Catalog
 */


class GoodsSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'Goods Catalog', 
            'manage_options', 
            'goods-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'goods_option_name' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2><?php echo __('Goods Catalog Plugin Settings', 'gcat'); ?></h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'goods_option_group' );   
                do_settings_sections( 'goods-setting-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'goods_option_group', // Option group
            'goods_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            __('Catalog View Settings', 'gcat'), // Title
            array( $this, 'print_section_info' ), // Callback
            'goods-setting-admin' // Page
        );  

        add_settings_field(
            'items_per_page', // ID
            __('Products per page', 'gcat'), // Title 
            array( $this, 'items_per_page_callback' ), // Callback
            'goods-setting-admin', // Page
            'setting_section_id' // Section           
        );      
/*
        add_settings_field(
            'tags_before', 
            'Tags before catalog', 
            array( $this, 'tags_before_callback' ), 
            'goods-setting-admin', 
            'setting_section_id'
        );
        add_settings_field(
            'tags_after', 
            'Tags after catalog', 
            array( $this, 'tags_after_callback' ), 
            'goods-setting-admin', 
            'setting_section_id'
        );  
*/
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['items_per_page'] ) )
            $new_input['items_per_page'] = absint( $input['items_per_page'] );
/*
        if( isset( $input['tags_before'] ) )
            $new_input['tags_before'] = sanitize_text_field( $input['tags_before'] );

        if( isset( $input['tags_after'] ) )
            $new_input['tags_after'] = sanitize_text_field( $input['tags_after'] );
*/
        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print __('Enter your settings below:', 'gcat');
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function items_per_page_callback()
    {
        printf(
            '<input type="number" step="1" id="items_per_page" class="small-text" name="goods_option_name[items_per_page]" value="%s" />',
            isset( $this->options['items_per_page'] ) ? esc_attr( $this->options['items_per_page']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values

        public function tags_before_callback()
    {
        printf(
            '<input type="text" id="tags_before" name="goods_option_name[tags_before]" value="%s" />',
            isset( $this->options['tags_before'] ) ? esc_attr( $this->options['tags_before']) : ''
        );
    }
     */
    /** 
     * Get the settings option array and print one of its values

    public function tags_after_callback()
    {
        printf(
            '<input type="text" id="tags_after" name="goods_option_name[tags_after]" value="%s" />',
            isset( $this->options['tags_after'] ) ? esc_attr( $this->options['tags_after']) : ''
        );
    }
     */
}

if( is_admin() )
    $goods_settings_page = new GoodsSettingsPage();
