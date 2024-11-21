<?php get_header(); ?>
<div class="container">
  <h1 class="blog-title"><?php printf(__('Resultados da pesquisa por: %s'), '' . get_search_query() . ''); ?></h1>
  <div class="row">
    <div class="col-12 col-md-6">
      <form role="search" method="get" class="search-form d-flex" action="<?php echo esc_url(home_url('/')); ?>">
        <div class="input-group">
          <input type="search" required class="form-control input-search" placeholder="Pesquisar..." value="<?php echo get_search_query(); ?>" name="s" />
          <div class="input-group-append">
            <button type="submit" class="form-control btn-search">
              <i class="fa-solid fa-search"></i>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <hr>
  <?php if (have_posts()) : ?>

    <?php while (have_posts()) :
      the_post(); ?>
      <?php

      $image = get_post_meta($post->ID, '_destaque_image', true);
      if (!$image) {
        $image = get_template_directory_uri() . '/assets/images/news.svg';
      }

      posttag(get_the_title(), get_the_excerpt(), get_the_permalink(), $image);

      ?>
    <?php endwhile; ?>
  <?php else : ?>
    <div class="container text-center">
      <h2 class="blog-title">Hmmm... não encontrei nada!</h2>

      <p>Parece que não há resultados para a sua busca.</p>
      <div class="row justify-content-center">
        <div class="col-8 col-sm-4 col-md-3 col-lg-2">
          <img
            title="<?php bloginfo('name'); ?>"
            class="my-4 w100"
            src="<?php echo get_template_directory_uri(); ?>/assets/images/notfound.svg"
            alt="<?php bloginfo('name'); ?>">
        </div>
      </div>
    </div>

</div>
<?php endif; ?>

<?php if ($wp_query->max_num_pages > 1) : ?>
  <div class="prev">
    <?php next_posts_link(__('&larr; Mais antigos')); ?>
  </div>
  <div class="next">
    <?php previous_posts_link(__('Mais Novos &rarr;')); ?>
  </div>
<?php endif; ?>
</div>
<?php get_footer(); ?>