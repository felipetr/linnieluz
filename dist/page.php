<?php get_header(); ?>

<?php if (have_posts()) {
    while (have_posts()) :
        the_post(); ?>
<div class="container">
<h1  class="blog-title"><?php the_title(); ?></h1>
            <?php the_content(); ?>
    <?php endwhile;
};
wp_reset_query(); ?>
</div>
<?php get_footer(); ?>