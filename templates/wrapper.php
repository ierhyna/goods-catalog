<?php

/**
 * Template wrapper
 * 
 * Contains all the common code for catalog templates
 * 
 * @since 0.9.0
 */

get_header( goods_catalog_template_base() ); ?>

<div class="goods-catalog-container">

	<?php
	load_template ( dirname( __FILE__ ) . '/sidebar-goods.php' ) ;
	?>
	<section id="primary">
		<div id="content" role="main">
			<?php include goods_catalog_template_path(); ?>
		</div>
	</section>

	<?php get_sidebar( goods_catalog_template_base() ); ?>

</div><?php // goods-catalog-container

get_footer( goods_catalog_template_base() ); ?>