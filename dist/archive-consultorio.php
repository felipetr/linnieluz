<?php get_header(); ?>
<div class="container">
  <h1 class="blog-title">Consultórios</h1>

  <?php
  query_posts([
    'post_type' => 'consultorio',
    'order' => 'ASC',
    'orderby' => 'date',
    'posts_per_page' => -1,
  ]);
  ?>
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) :
      the_post(); ?>
      <?php

      $image = get_post_meta($post->ID, '_thumbnail', true);
      if (!$image) {
        $image = get_template_directory_uri() . '/assets/images/consultorio.svg';
      }

      $text = '<div>' . get_post_meta($post->ID, '_endereco', true) . '</div>';
      if (get_post_meta($post->ID, '_telefone', true)) {
        $text .= '<div> Telefone: ' . get_post_meta($post->ID, '_telefone', true) . '</div>';
      }
      if (get_post_meta($post->ID, '_email', true)) {
        $text .= '<div> E-mail: ' . get_post_meta($post->ID, '_email', true) . '</div>';
      }
      posttag(get_the_title(), $text, get_the_permalink(), $image, false);

      ?>
    <?php endwhile;
    wp_reset_query(); ?>
  <?php else : ?>
    <h2 class="blog-none">Nenhum Consultório Cadastrado</h2>
  <?php endif; ?>

  <?php if ($wp_query->max_num_pages > 1) : ?>
    <div class="prev">
      <?php next_posts_link(__('&larr; Older posts')); ?>
    </div>
    <div class="next">
      <?php previous_posts_link(__('Newer posts &rarr;')); ?>
    </div>
  <?php endif; ?>

</div>
<?php get_footer(); ?>