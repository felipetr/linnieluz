<?php get_header(); ?>
<div class="container">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) :
            the_post(); ?>

            <h1 class="blog-title"><?php the_title(); ?></h1>
            <?php $image = get_post_meta($post->ID, '_destaque_image', true);
            if ($image) { ?>
                <figure class="postarchive-figure consultorio-figure">
                    <img
                        style="background-image:url(<?php echo $image; ?>)"
                        src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/consultorio_inv.png?v=2"
                        title="<?php the_title(); ?>"
                        alt="<?php the_title(); ?>"
                        class="w100">
                </figure>
            <?php } ?>
            <?php the_content(); ?>
        <?php endwhile; ?>
        <?php wp_reset_query(); ?>

    <?php endif; ?>

    <?php comments_template('', true); ?>
</div>
<?php get_footer(); ?>