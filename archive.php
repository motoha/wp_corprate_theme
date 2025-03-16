<?php get_header(); ?>

<main>
    <h1><?php the_archive_title(); ?></h1>
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            the_title('<h2><a href="' . get_permalink() . '">', '</a></h2>');
            the_excerpt();
        }
    } else {
        echo '<p>No posts found.</p>';
    }
    ?>
</main>

<?php get_footer(); ?>
