<?php
/*
 * Widgets Here
 */

/*
 * Categories
 */

// Creating the categories widget 
class Widget_Goods_Categories extends WP_Widget {

    function __construct() {
        parent::__construct(
                // Base ID of your widget
                'Widget_Goods_Categories',
                // Widget name will appear in UI
                'Goods Catalog Categories',
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
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        // This is where the code displays the output
        $taxonomy = 'goods_category';
        $orderby = 'name';
        $show_count = 1;      // 1 for yes, 0 for no
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
        // Widget admin form

        echo '<p>';
        echo '<label for="' . $this->get_field_id('title') . '">';
        _e('Title:');
        echo '</label>'; 
        echo '<input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' .   esc_attr($title) . '" />';
        echo '</p>';

    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

} // Class goods_categories_widget ends here

new Widget_Goods_Categories();

/*
 * Tags
 */

// Creating the tags widget 
class Widget_Goods_Tags extends WP_Widget {

    function __construct() {
        parent::__construct(
                // Base ID of your widget
                'Widget_Goods_Tags',
                // Widget name will appear in UI
                'Goods Catalog Tags',
                // Widget description
                array(
            'description' => __('Goods Catalog tags cloud', 'gcat')
        ));
        add_action('widgets_init', array ($this, 'goods_tags_load_widget')) ;
    }

    public function goods_tags_load_widget() {
        register_widget('Widget_Goods_Tags');
    }

    // Creating widget front-end
    public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		
                        // This is where the code displays the output
        $taxonomy = 'goods_tag';
        $orderby = 'name';

        $tag_args = array(
            'taxonomy' => $taxonomy,
            'orderby' => $orderby
        );
        echo '<ul>';
        wp_tag_cloud($tag_args);
        echo '</ul>';
                
                
		echo $args['after_widget'];
	}

    // Widget Backend 
    public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Products Tags', 'gcat');
        }
        // Widget admin form

        echo '<p>';
        echo '<label for="' . $this->get_field_id('title') . '">';
        _e('Title:');
        echo '</label>'; 
        echo '<input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' .   esc_attr($title) . '" />';
        echo '</p>';

    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

} // Class goods_tags_widget ends here

new Widget_Goods_Tags();