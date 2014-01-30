<?php

/**
 *
 * archive.php
 *
 * The archive template. Used when a category, author, or date is queried.
 * Note that this template will be overridden by category.php, author.php, and date.php for their respective query types. 
 *
 * More detailed information about template’s hierarchy: http://codex.wordpress.org/Template_Hierarchy
 *
 */

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
//list terms in a given taxonomy using wp_list_categories (also useful as a widget if using a PHP Code plugin)

$taxonomy     = 'goods_category';
$orderby      = 'name'; 
$show_count   = 0;      // 1 for yes, 0 for no
$pad_counts   = 0;      // 1 for yes, 0 for no
$hierarchical = 1;      // 1 for yes, 0 for no
$title        = '';
$hide_empty   = 0;	// 1 for yes, 0 for no

$args = array(
  'taxonomy'     => $taxonomy,
  'orderby'      => $orderby,
  'show_count'   => $show_count,
  'pad_counts'   => $pad_counts,
  'hierarchical' => $hierarchical,
  'title_li'     => $title,
  'hide_empty'   => $hide_empty 
);

?>


<?php
/* descriptive cat list */
$cat_id = get_query_var('cat');
$catlist = get_categories('hide_empty=0&type=goods&taxonomy=goods_category&parent=0' . $cat_id);
echo "<div class='grid'>";

foreach($catlist as $categories_item)
{
echo '<div class="list-catalog"><h3><a href="' . get_category_link( $categories_item->term_id ) . '" title="' . sprintf( __( "Нажмите на изображение, чтобы перейти в рубрику %s" ), $categories_item->name ) . '" ' . '>' . $categories_item->name.'</a> </h3> ';

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
