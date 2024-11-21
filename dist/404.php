<?php get_header(); ?>
<div class="container text-center">
    <h1 class="blog-title">Ops! Algo deu errado...</h1>

    <p>Parece que a página que você está procurando não existe.</p>

    <p>Talvez ela tenha sido movida, renomeada ou nunca tenha existido.</p>
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
<?php get_footer(); ?>