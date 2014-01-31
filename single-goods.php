<?php
get_header();

if (have_posts()) {
    // Display navigation next/previous
    ?>
    <div class="navigation"><?php posts_nav_link(); ?></div>
    <?php
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
                if ((isset($price)) && ($price != '')) {
                        echo "Price: $price";
                }
                the_content();
                ?>
            </div>
            <footer>

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
get_footer(); ?>