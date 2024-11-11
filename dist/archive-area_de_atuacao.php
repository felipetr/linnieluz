<?php
// archive-area_de_atuacao.php

get_header(); ?>

<main id="primary" class="site-main">
    <header class="page-header">
        <h1 class="page-title">Áreas de Atuação</h1>
    </header>

    <?php if (have_posts()) : ?>
        <div class="area-de-atuacao-archive">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h2 class="entry-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>

            <div class="pagination">
                <?php
                the_posts_pagination(array(
                    'prev_text' => __('Anterior'),
                    'next_text' => __('Próximo'),
                ));
                ?>
            </div>
        </div>
    <?php else : ?>
        <p>Nenhuma área de atuação encontrada.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
