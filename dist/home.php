<?php get_header(); ?>

<main>
  <section class="hero">
    <h1>Bem-vindo ao Meu Site!</h1>
    <p>Esta é a página inicial do meu tema WordPress.</p>
    <p>Esta é a página inicial do meu tema WordPress.</p>
    <p>Esta é a página inicial do meu tema WordPress.</p>
    <p>Esta é a página inicial do meu tema WordPress.</p>
    <p>Esta é a página inicial do meu tema WordPress.</p>
    <p>Esta é a página inicial do meu tema WordPress.</p>
    <p>Esta é a página inicial do meu tema WordPress.</p>
    <p>Esta é a página inicial do meu tema WordPress.</p>
    <p>Esta é a página inicial do meu tema WordPress.</p>
    <p>Esta é a página inicial do meu tema WordPress.</p>
    <p>Esta é a página inicial do meu tema WordPress.</p>
    <p>Esta é a página inicial do meu tema WordPress.</p>
    <p>Esta é a página inicial do meu tema WordPress.</p>
    <p>Esta é a página inicial do meu tema WordPress.</p>
  </section>

  <section class="posts">
    <h2>Posts Recentes</h2>
    <?php if (have_posts()) : ?>
      <ul>
        <?php while (have_posts()) :
            the_post(); ?>
          <li>
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            <p><?php the_excerpt(); ?></p>
          </li>
        <?php endwhile; ?>
      </ul>
        <?php the_posts_navigation(); ?>
    <?php else : ?>
      <p>Nenhum post encontrado.</p>
    <?php endif; ?>
  </section>
</main>

<?php get_footer(); ?>
