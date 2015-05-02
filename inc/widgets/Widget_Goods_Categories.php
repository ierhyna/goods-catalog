<?php
/**
 * Categories
 * 
 * @since 0.9.0
 */

// Creating the categories widget 
class Widget_Goods_Categories extends WP_Widget {

    function __construct() {
        parent::__construct(
                // Base ID of your widget
                'Widget_Goods_Categories',
                // Widget name will appear in UI
                'GC Categories',
                // Widget description
                array(
            'description' => __('Goods Catalog categories list', 'gcat')
        ));
        add_action('widgets_init', array($this, 'goods_categories_load_widget'));
    }

    public function goods_categories_load_widget() {
        register_widget('Widget_Goods_Categories');
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);

        $c = ! empty( $instance['count'] ) ? '1' : '0';

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        // This is where the code displays the output
        $taxonomy = 'goods_category';
        $orderby = 'name';
        $show_count = $c;      // 1 for yes, 0 for no
        $pad_counts = 0;      // do not count products in subcategories
        $hierarchical = 1;      // 1 for yes, 0 for no

        $cat_args = array(
            'taxonomy' => $taxonomy,
            'orderby' => $orderby,
            'show_count' => $show_count,
            'pad_counts' => $pad_counts,
            'hierarchical' => $hierarchical,
            'title_li' => ''
        );
        echo '<ul>';
        wp_list_categories($cat_args);
        echo '</ul>';

        echo $args['after_widget'];
    }

    // Widget Backend 
    public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Products Categories', 'gcat');
        }
        $count = isset($instance['count']) ? (bool) $instance['count'] :false;
        // Widget admin form
        ?>

        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
        <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts' ); ?></label></p><br />
    <?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['count'] = !empty($new_instance['count']) ? 1 : 0;
        return $instance;
    }

} // Class goods_categories_widget ends here
?>