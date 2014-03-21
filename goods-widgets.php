<?php
/*
 * Widgets Here
 */

/*
 * Categories
 */

// Creating the categories widget 
class goods_categories_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                // Base ID of your widget
                'goods_categories_widget',
                // Widget name will appear in UI
                'Goods Catalog Categories',
                // Widget description
                array(
            'description' => __('Goods Catalog categories list', 'gcat')
        ));
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
        ?>
        <p>
            <label for="<?php
            echo $this->get_field_id('title');
            ?>"><?php
                       _e('Title:');
                       ?></label> 
            <input class="widefat" id="<?php
            echo $this->get_field_id('title');
            ?>" name="<?php
                   echo $this->get_field_name('title');
                   ?>" type="text" value="<?php
                   echo esc_attr($title);
                   ?>" />
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

} // Class goods_categories_widget ends here

/*
 * Tags
 */

// Creating the tags widget 
class goods_tags_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                // Base ID of your widget
                'goods_tags_widget',
                // Widget name will appear in UI
                'Goods Catalog Tags',
                // Widget description
                array(
            'description' => __('Goods Catalog tags cloud', 'gcat')
        ));
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
        ?>
        <p>
            <label for="<?php
                   echo $this->get_field_id('title');
                   ?>"><?php
                _e('Title:');
                ?></label> 
            <input class="widefat" id="<?php
                   echo $this->get_field_id('title');
                   ?>" name="<?php
                   echo $this->get_field_name('title');
                   ?>" type="text" value="<?php
                   echo esc_attr($title);
                   ?>" />
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

} // Class goods_tags_widget ends here

/*
 * Register and load the widget
 */

function goods_categories_load_widget() {
    register_widget('goods_categories_widget');
}

add_action('widgets_init', 'goods_categories_load_widget');

function goods_tags_load_widget() {
    register_widget('goods_tags_widget');
}

add_action('widgets_init', 'goods_tags_load_widget');
