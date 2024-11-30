<?php get_header(); ?>
<div class="container">
  <h1 class="blog-title">
    <?php if (is_author()) : ?>
        <?php echo $author_name ?>
    <?php elseif (is_category()) : ?>
        <?php single_cat_title(); ?>
    <?php elseif (is_tag()) : ?>
        <?php single_tag_title(); ?>
    <?php elseif (is_year()) : ?>
        <?php the_time('Y'); ?>
    <?php elseif (is_month()) : ?>
        <?php the_time('F Y'); ?>
    <?php else : ?>
      Histórico
    <?php endif; ?>
  </h1>

  <div class="row">
    <div class="col-12 col-md-6">
      <form role="search" method="get" class="search-form d-flex" action="<?php echo esc_url(home_url('/')); ?>">
        <div class="input-group">
          <input type="search"
          required class="form-control input-search"
          placeholder="Pesquisar..."
          value="<?php echo get_search_query(); ?>" name="s" />
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
        <?php endwhile;
        wp_reset_query(); ?>
  <?php else : ?>
    <h2 class="blog-none">Nenhum Artigo Cadastrado</h2>
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