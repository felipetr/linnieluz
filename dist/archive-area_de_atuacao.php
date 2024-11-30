<?php get_header(); ?>
<div class="container">
  <h1 class="blog-title">Áreas de Atuação</h1>


  <?php if (have_posts()) : ?>
    <div class="row justify-content-center">
        <?php while (have_posts()) :
            the_post(); ?>
        <div class="col text-center">
          <i class="atuacaoicon <?php echo get_post_meta($post->ID, '_icone', true); ?>"></i>

          <div class="atuacaotitle mt-2 text-center">
            <?php the_title(); ?>
          </div>
          <button class="btn btn-green btn-sm modal-btn mb-4" title="Saiba Mais">
          Saiba Mais
            <div class="modal-title"><?php the_title(); ?></div>
            <div class="modal-content"><?php the_content(); ?></div>
          </button>
        </div>
        <?php endwhile;
        wp_reset_query(); ?>
    </div>
  <?php else : ?>
    <h2 class="blog-none">Nenhuma Área de Atuação Cadastrada</h2>
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