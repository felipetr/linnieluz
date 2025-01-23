<?php get_header(); ?>
<div class="container">
  <h1 class="blog-title">Áreas de Atuação</h1>

  <?php 
  // Modificando a consulta padrão para ordenar pelos slugs e sem paginação
  $args = array(
      'post_type' => 'area_de_atuacao', // ou o tipo de post que você estiver usando, como 'area_atuacao'
      'orderby'   => 'slug',  // Ordena pelo slug
      'order'     => 'ASC',   // Ordem crescente (alfabética)
      'posts_per_page' => -1   // Exibe todos os posts sem paginação
  );
  $query = new WP_Query($args); 

  if ($query->have_posts()) : ?>
    <div class="row justify-content-center">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
        <div class="col-12 col-md-6 col-lg-4 mb-4  text-center">
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
        wp_reset_postdata(); ?>
    </div>
  <?php else : ?>
    <h2 class="blog-none">Nenhuma Área de Atuação Cadastrada</h2>
  <?php endif; ?>

</div>
<?php get_footer(); ?>
