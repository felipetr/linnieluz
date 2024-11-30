<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>
    <?php
    if (!is_home()) :
        wp_title('|', true, 'right');
    endif;
    bloginfo('name');
    ?>
  </title>

  <meta name="author" content="Felipe Travassos">
  <meta name="author_url" content="https://felipetravassos.com">
  <meta name="version" content="<?php echo wp_get_theme()->get('Version'); ?>">

  <?php if (get_post_meta(get_the_ID(), 'meta_description', true)) : ?>
    <meta name="description" content="<?php echo esc_attr(get_post_meta(get_the_ID(), 'meta_description', true)); ?>">
  <?php endif; ?>

  <?php if (get_post_meta(get_the_ID(), 'meta_keywords', true)) : ?>
    <meta name="keywords" content="<?php echo esc_attr(get_post_meta(get_the_ID(), 'meta_keywords', true)); ?>">
  <?php endif; ?>
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.lineicons.com/5.0/lineicons.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
  integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link
  rel="stylesheet"
  href="<?php
    echo get_template_directory_uri();
    ?>/lib/linnieluzicons/linnieluzicons.css?v=<?php
  echo wp_get_theme()->get('Version');
?>">
  <link
  rel="stylesheet"
  href="<?php
    echo get_template_directory_uri();
    ?>/assets/css/styles.min.css?v=<?php
  echo wp_get_theme()->get('Version');
?>">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

  <header>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-6 col-lg-3">
          <a id="logo-a" href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>">
            <img class="logo"
              src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png"
              alt="<?php bloginfo('name'); ?>">
          </a>
        </div>
        <div class="col-6 col-lg-9 text-end">
          <button class="navbar-toggler navbar-button"
            type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav2"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation">

            <i class="navbar-icon lni lni-menu-hamburger-1"></i>

          </button>
          <nav id="navbarNav">
            <?php
            wp_nav_menu(array(
              'theme_location' => 'primary',
              'container' => false
            ));
            ?>
          </nav>
        </div>
      </div>
    </div>
  </header>
  <div id="navbarNav2pattern">
    <nav class="collapse navbar-collapse text-end" id="navbarNav2">
      <div class="menucontainer">
        <?php wp_nav_menu(array('theme_location' => 'primary')); ?></div>
    </nav>
  </div>
  <div id="container">
    <main>
      <div id="headerbg">
        <div>
        </div>
      </div>