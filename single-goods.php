<?php
get_header();

if (have_posts()) {
    // Display navigation next/previous
    

    while (have_posts()) {
        the_post();

        // start functions
        $price = get_post_meta(get_the_ID(), 'gc_price', true);
        ?>
        <article <?php post_class(); ?>>
            <header>
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>
            <div class="entry-content">
                <?php
                echo '<div class="goods-item-thumb-container">';
                if (has_post_thumbnail()) {
                    $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
                    echo '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
                    the_post_thumbnail('medium' , array( 'class' => 'goods-item-thumb'));
                    echo '</a>';
                } else {
                    // show default image if the thumbnail is not found
                    echo '<img class="goods-item-thumb" src="' . plugins_url('img/gi.png', __FILE__) . '" alt="">';
                }
                echo '</div>';
                if ((isset($price)) && ($price != '')) {
                    echo "Price: $price";
                }
                the_content();
                ?>
            </div>
            <footer>
                <p>The page is generated with single-goods.php template</p>
            </footer>
        </article>
        <?php
    }

    // Display navigation to next/previous
    ?>
    <div class="navigation"><?php posts_nav_link(); ?></div>
    <?php
} else {
    get_404_template();
}
get_footer();