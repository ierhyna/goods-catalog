<?php

/**
 * Create metabox for goods post type
 * 
 * @since 0.9.0
 * 
 */

function Call_Goods_Catalog_Metabox() {
    new Goods_Catalog_Metabox();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'Call_Goods_Catalog_Metabox' );
    add_action( 'load-post-new.php', 'Call_Goods_Catalog_Metabox' );
}

/*
 * The Class.
 */
class Goods_Catalog_Metabox {

    protected $prefix;
    protected $fields;

    /*
     * Hook into the appropriate actions when the class is constructed.
     */
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
        add_action( 'save_post', array( $this, 'save' ) );

        $prefix = 'gc_';
        $this->fields = array(
            array(
                'name' => __('Price', 'gcat'),
                'desc' => __('Enter price here', 'gcat'),
                'id' => $prefix . 'price',
                'type' => 'text',
                'std' => ''
            ),
            array(
                'name' => __('SKU', 'gcat'),
                'desc' => __('Enter product ID (SKU)', 'gcat'),
                'id' => $prefix . 'sku',
                'type' => 'text',
                'std' => ''
            ),
            array(
                'name' => __('Short Description', 'gcat'),
                'desc' => __('Enter description here', 'gcat'),
                'id' => $prefix . 'descr',
                'type' => 'textarea',
                'std' => ''
            )
        );
    }

    /*
     * Adds the meta box container.
     */
    public function add_meta_box( $post_type ) {
        $post_types = array('goods');     //limit meta box to certain post types
        if ( in_array( $post_type, $post_types )) {
            add_meta_box(
                'goods_meta_box'
                ,__( 'Item Options', 'gcat' )
                ,array( $this, 'render_meta_box_content' )
                ,$post_type
                ,'normal'
                ,'high'
            );
        }
    }

    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function save( $post_id ) {

        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        if ( ! isset( $_POST['goods_meta_box_nonce'] ) )
            return $post_id;

        $nonce = $_POST['goods_meta_box_nonce'];

        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'goods_catalog_inner_meta_box' ) )
            return $post_id;

        // If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
            return $post_id;

        // Check the user's permissions.
        if ( 'page' == $_POST['post_type'] ) {

            if ( ! current_user_can( 'edit_page', $post_id ) )
                return $post_id;
    
        } else {

            if ( ! current_user_can( 'edit_post', $post_id ) )
                return $post_id;
        }

        /* OK, its safe for us to save the data now. */

        foreach ($this->fields as $field) {
            if (isset($_POST[$field['id']])) {
                // POST field sent - update
                //$new = sanitize_text_field ( $_POST [$field[ 'id' ]] );
                $new =  $_POST [$field[ 'id' ]] ;
                update_post_meta($post_id, $field['id'], $new);
            } else {
                // POST field not sent - delete
                $old = get_post_meta($post_id, $field['id'], true);
                delete_post_meta($post_id, $field['id'], $old);
            }
        }
    }


    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content( $post ) {

        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'goods_catalog_inner_meta_box', 'goods_meta_box_nonce' );

        // Use get_post_meta to retrieve an existing value from the database.
        $value = get_post_meta( $post->ID, '_my_meta_value_key', true );

        // Display the form, using the current value.

        echo '<table class="form-table">';
        foreach ($this->fields as $field) {
        // get current post meta data
            $meta = get_post_meta($post->ID, $field['id'], true);
            echo '<tr>',
            '<th style="width:20%"><label for="'. __($field['name'],'gcat'). '">', __($field['name'],'gcat'), '</label></th>',
            '<td>';
            switch ($field['type']) {
                case 'text':
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />'. __($field['desc'],'gcat').'';
                    break;
                case 'textarea':
                    echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />'. __($field['desc'],'gcat').'';
                    break;
            }
            echo '</td><td>',
            '</td></tr>';
        }
        echo '</table>';
    }
}