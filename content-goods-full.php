<?php
	


	$price = get_post_meta( get_the_ID(), 'goods_price', true );
	$excerpt = theme_get_content();
	$descr = '<b>Цена&#58; ' . $price . '</b>' . '<br>' . $excerpt;
	

	global $post;
	theme_post_wrapper(
		array(
				'id' => theme_get_post_id(), 
				'class' => theme_get_post_class(),
				'thumbnail' => theme_get_post_thumbnail(),
				'title' => '<a href="' . get_permalink( $post->ID ) . '" rel="bookmark" title="' . strip_tags(get_the_title()) . '">' . get_the_title() . '</a>', 
        'heading' => theme_get_option('theme_'.(is_single()?'single':'posts').'_article_title_tag'),
				'before' => theme_get_metadata_icons( '', 'header' ),
				'content' => $descr, 
				'after' => theme_get_metadata_icons( 'edit', 'footer' )
		)
	);
?>
