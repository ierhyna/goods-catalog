<?php


get_header(); 
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );?>
<div class="art-layout-wrapper">
	<div class="art-content-layout">
		<div class="art-content-layout-row">
			<div class="art-layout-cell art-sidebar1">
				<?php get_sidebar('default'); ?>
				<div class="cleared"></div>
			</div>
			<div class="art-layout-cell art-content">
			<?php get_sidebar('top'); ?>
			<?php 
				if (have_posts()){
				
					global $posts;
					$post = $posts[0];
					
					ob_start();
			
						// if is taxonomy query for 'goods_category' taxonomy, modify query so only posts in that collection (not posts in subcollections) are shown.
						if (is_taxonomy('goods_category')) {
							if (get_query_var('goods_category')) {
							$taxonomy_term_id = $wp_query->queried_object_id;
							$taxonomy = 'goods_category';
							$unwanted_children = get_term_children($taxonomy_term_id, $taxonomy);
							$unwanted_post_ids = get_objects_in_term($unwanted_children, $taxonomy);

							// merge with original query to preserve pagination, etc.
							query_posts( array_merge( array('post__not_in' => $unwanted_post_ids), $wp_query->query) );
							}
						} //end of is_taxonomy
					
						echo '<h4>'. single_cat_title( '', false ) . '</h4>';
						echo '<p>'. category_description() . '</p>';
									
				}
				elseif( isset($_GET['paged']) && !empty($_GET['paged']) ) {
					 echo '<h4>'. __('Blog Archives', THEME_NS) . '</h4>';
				}

				// sub-cats list
/* descriptive cat list */
$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$args = array(
	'parent' => $current_term->term_id,
	'taxonomy' => $current_term->taxonomy,
	'hide_empty' => 0,
	'hierarchical' => true,
	'depth'  => 1
);

$catlist = get_categories($args);

echo "<div class='grid'>";

foreach($catlist as $categories_item)
{
echo '<div class="list-catalog"><h3><a href="' . esc_url( get_term_link( $categories_item, $categories_item->taxonomy ) ) . '" title="' . sprintf( __( "Нажмите на изображение, чтобы перейти в рубрику %s" ), $categories_item->name ) . '" ' . '>' . $categories_item->name.'</a> </h3> ';

echo '<div class="categoryoverview clearfix">';
    $terms = apply_filters( 'taxonomy-images-get-terms', '', array('taxonomy'  => 'goods_category') );
    if ( ! empty( $terms ) ) {

      foreach( (array) $terms as $term ) {
        if($term->term_id == $categories_item->term_id) {
           print '<a href="' . esc_url( get_term_link( $term, $term->taxonomy ) ) . '" title="Нажмите, чтобы перейти в рубрику">' . wp_get_attachment_image( $term->image_id, 'thumbnail' );
           echo '</a>';

        }
    }
}
echo '</div>';
echo '<p>'. $categories_item->category_description; echo '</p></div>';
}
echo "</div>";
/* end  */
				// the end of sub-cats list

				theme_post_wrapper(array('content' => ob_get_clean(), 'class' => 'breadcrumbs'));
				
				// Display navigation to next/previous pages when applicable
				if (theme_get_option('theme_top_posts_navigation')) {
					texguard_pagination();
				}
				?><div class="cleared"></div><?php
				// Start the Loop 
				while (have_posts()) {the_post(); ?>
					<div class="grid">
					<?php get_template_part('content-goods', get_post_format()); ?>
					</div>
				<?php
				}

				// Display navigation to next/previous pages when applicable
				if (theme_get_option('theme_bottom_posts_navigation')) {
					texguard_pagination();
					}
				else {
					theme_404_content();
				}
			?>
			<?php get_sidebar('bottom'); ?>
				<div class="cleared"></div>
			</div>
			            <div class="art-layout-cell art-sidebar2">
              <?php get_sidebar('secondary'); ?>
              <div class="cleared"></div>
            </div>
		</div>
	</div>
</div>
<div class="cleared"></div>
<?php get_footer();	
