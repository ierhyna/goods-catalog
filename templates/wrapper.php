<?php

/**
 * Template wrapper
 * 
 * Contains all the common code for catalog templates
 * 
 * @since 0.9.0
 */

 ?> 

<?php get_header( goods_catalog_template_base() ); ?>

<section id="primary">
	<div id="content" role="main">
		<?php include goods_catalog_template_path(); ?>
	</div>
</section>

<?php get_sidebar( goods_catalog_template_base() ); ?>

<?php get_footer( goods_catalog_template_base() ); ?>