<?php get_header(); ?>
<div class="container">
  <h1 class="blog-title">
    Dúvidas
  </h1>


  <?php

    $args = [
    'post_type'      => 'pergunta',
    'posts_per_page' => -1, // Lista todos os itens
    'orderby'        => 'date', // Ordena pela data
    'order'          => 'ASC',  // Ordem crescente (mais antigos primeiro)
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        ?>
    <div class="accordion" id="accordionFaq">
        <?php
        while ($query->have_posts()) :
            $query->the_post();
            $slug = get_post_field('post_name', get_post());
            ?>
        <div class="accordion-item">
    <h2 class="accordion-header">
      <button
      class="accordion-button collapsed"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#collapse<?php echo $slug; ?>"
      aria-expanded="false"
      aria-controls="collapse<?php echo $slug; ?>">
            <?php the_title(); ?>
      </button>
    </h2>
    <div id="collapse<?php echo $slug; ?>" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
      <div class="accordion-body">
            <?php the_content(); ?>
      </div>
    </div>
  </div>
            <?php
        endwhile;
        wp_reset_postdata();
        ?>
    </div><?php
    else :
            echo '<h2 class="blog-none">Nenhuma Dúvida Cadastrado</h2>';
    endif;
    ?>

  <hr>
  <h3 class="text-green">Ainda tem dúvida?</h3>
  <p>Mande uma mensagem, respondarei assim que puder</p>


  <?php

    $formtag = get_option('contact_form_tag');

    $formtag = str_replace("\\", "", $formtag);
    echo do_shortcode($formtag); ?>


</div>
<?php get_footer(); ?>