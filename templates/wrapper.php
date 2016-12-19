<?php
/**
 * Template wrapper
 *
 * Contains all the common code for catalog templates
 *
 * @since 0.9.0
 */
get_header();
?>

<div class="goods-catalog-container">

	<?php
	// Load the sidebar
	load_template(dirname(__FILE__) . '/sidebar-goods.php');
	?>

	<div class="goods-catalog">
		<div class="catalog-inner">
			<?php show_gc_breadcrumbs(); ?>
			<?php goods_template(); ?>
		</div>
	</div>

	<div class="clear"></div>

</div>

<?php
get_footer();
