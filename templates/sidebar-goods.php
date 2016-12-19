<?php
/**
 * Template: Sidebar
 */
if (!isset($catalog_option)) {
	global $catalog_option;
}

if (isset($catalog_option['use_sidebar'])) {
	?>

	<aside class="goods-sidebar">
		<?php if (!dynamic_sidebar('goods-sidebar')) { ?>

			<h3 class="widgettitle"><?= __('Goods Catalog Sidebar is Activated!', 'goods-catalog') ?></h3>
			<?= __('Hi! It is Goods Catalog Sidebar. Please <a href="/wp-admin/widgets.php">add some widgets</a> in there, and this message will be hidden automatically.', 'goods-catalog') ?>

		<?php } ?>
	</aside>
	<?php
}
?>
