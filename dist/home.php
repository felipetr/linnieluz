<?php get_header();


?>
<main>
  <?php $menu_location = 'destaques';
    $locations = get_nav_menu_locations();

  // Verificar se o local do menu existe
    if (isset($locations[$menu_location])) {
        $menu_id = $locations[$menu_location];

        $menu_items = wp_get_nav_menu_items($menu_id);

        $menu_count = count($menu_items);
        ?>
    <div id="homeslider">

      <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
          <?php
            for ($i = 0; $i < $menu_count; $i++) {
                ?>
            <button
              type="button"
              data-bs-target="#carouselExampleIndicators"
              data-bs-slide-to="<?php echo $i; ?>"
              class="<?php echo $i === 0 ? 'active' : ''; ?>"
              aria-current="<?php echo $i === 0 ? 'true' : 'false'; ?>"
              aria-label="Slide <?php echo $i + 1; ?>">
            </button>
                <?php
            } ?>
        </div>
        <div class="carousel-inner">
            <?php
            wp_nav_menu(array(
            'theme_location' => 'destaques',
            'container' => false,
            'walker' => new Destaques_Walker_Nav_Menu()
            ));
            ?>
        </div>
      </div>
      <button class="carousel-control-prev"
      type="button"
      data-bs-target="#carouselExampleIndicators"
      data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next"
      type="button"
      data-bs-target="#carouselExampleIndicators"
      data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Próximo</span>
      </button>
    </div>
    <img class="homeslider_cutter" src="<?php echo get_template_directory_uri(); ?>/assets/images/divider.png">
    <?php } ?>
  <section class="subtitle">
    <?php echo get_bloginfo('description'); ?>
  </section>
  <img class="subtitle_cutter" src="<?php echo get_template_directory_uri(); ?>/assets/images/divider.png">
  <section id="posts" class="container">
    <h3 class="text-center posttitle">Artigos em Destaque</h3>
    <div class="row justify-content-center">
      <?php
      // Configura os argumentos para buscar os posts com o campo '_destaque_post' ativo
        $args = array(
        'post_type'      => 'post',        // Tipo de post
        'meta_key'       => '_destaque_post', // Campo personalizado
        'meta_value'     => '1',           // Valor do campo personalizado
        'posts_per_page' => 3,             // Limitar a 3 posts
        'orderby'        => 'date',        // Ordenar por data
        'order'          => 'DESC',        // Ordem decrescente (mais recentes primeiro)
        );

      // Cria uma consulta personalizada
        $destaques_query = new WP_Query($args);
        $haveposts = true;
      // Verifica se há posts
        if ($destaques_query->have_posts()) :
            while ($destaques_query->have_posts()) :
                $destaques_query->the_post();

                $destaque_image = get_post_meta(get_the_ID(), '_destaque_image', true);
                ?>
          <div class="col-12 col-md-4">

            <article class="post-articles mb-4" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
              <!-- Título do Post -->

              <figure>
                <img
                  style="background-image: url(<?php
                    if ($destaque_image) {
                        echo esc_attr($destaque_image);
                    } else {
                        echo get_template_directory_uri() . '/assets/images/news.svg';
                    } ?>);"
                  src="<?php echo get_template_directory_uri(); ?>/assets/images/postcutter.svg"
                  title="<?php the_title(); ?>"
                  alt="<?php the_title(); ?>">
              </figure>
              <div class="post-content p-4">
                <span class="mb-4"><?php the_title(); ?></span>

                <a href="<?php the_permalink(); ?>" title="Leia">Leia</a>
              </div>
            </article>
          </div>
            <?php endwhile;
            wp_reset_postdata(); // Reseta a consulta personalizada
        else :
            $haveposts = false; ?>
        <div class="col">
          <h2 class="noone">Nenhum artigo em destaque encontrado.</h2>
        </div>
        <?php endif; ?>

    </div>
    <div class="row justify-content-center">
      <div class="col-12 col-md-4">
        <a class="green-rounded-btn mb-4"
          href="<?php bloginfo('url'); ?>/category/artigos/"
          title="<?php if ($haveposts) {
                    echo 'Leia Mais';
                 } else {
                     echo "Veja todos os artigos";
                 } ?>">
          <?php if ($haveposts) {
                echo 'Leia Mais';
          } else {
              echo "Veja todos os artigos";
          } ?>
        </a>
      </div>
    </div>
  </section>
  <div class="container">
    <hr>
  </div>

  <section id="faq" class="container">
    <div class="home-faq-container p-4 mb-4 text-end">
      <h2 class="m-0 p-0">Dúvidas?</h2>
      <div class="row text-end mt-2 mb-4 pb-4">
        <div class="col-12 col-md-6 col-lg-8"></div>
        <div class="col-12 col-md-6  col-lg-4">
          Veja as perguntas frequentes ou mande sua pergunta e
          esclareça tudo sobre psicoterapia, psicologia e
          saúde mental!
        </div>
      </div>

      <a href="<?php bloginfo('url'); ?>/pergunta" class="destaque_btn" title="Clique Aqui">Clique Aqui</a>
    </div>
  </section>
</main>

<?php get_footer(); ?>