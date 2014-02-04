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
            'Goods Catalog Settings', 
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
            <h2>Goods Catalog Plugin Settings</h2>           
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
            'Catalog View Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'goods-setting-admin' // Page
        );  

        add_settings_field(
            'items_per_page', // ID
            'Products per page', // Title 
            array( $this, 'items_per_page_callback' ), // Callback
            'goods-setting-admin', // Page
            'setting_section_id' // Section           
        );      

//        add_settings_field(
//            'title', 
//            'Title', 
//            array( $this, 'title_callback' ), 
//            'goods-setting-admin', 
//            'setting_section_id'
//        );      
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

//        if( isset( $input['title'] ) )
//            $new_input['title'] = sanitize_text_field( $input['title'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
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
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="title" name="goods_option_name[title]" value="%s" />',
            isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
        );
    }
}

if( is_admin() )
    $goods_settings_page = new GoodsSettingsPage();