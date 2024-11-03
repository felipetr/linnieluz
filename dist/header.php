<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>
    <?php
    if (!is_home()):
      wp_title('|', true, 'right');
    endif;
    bloginfo('name');
    ?>
  </title>

  <meta name="author" content="Felipe Travassos">
  <meta name="author_url" content="https://felipetravassos.com">
  <meta name="version" content="<?php echo wp_get_theme()->get('Version'); ?>">

  <?php if (get_post_meta(get_the_ID(), 'meta_description', true)): ?>
    <meta name="description" content="<?php echo esc_attr(get_post_meta(get_the_ID(), 'meta_description', true)); ?>">
  <?php endif; ?>

  <?php if (get_post_meta(get_the_ID(), 'meta_keywords', true)): ?>
    <meta name="keywords" content="<?php echo esc_attr(get_post_meta(get_the_ID(), 'meta_keywords', true)); ?>">
  <?php endif; ?>

  <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/fontawesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/lib/cleanalert/cleanalert.css">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/styles.css">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="headerbg"></div>
<header>
  <div class="container">
    <div class="row">
      <div class="col">
        <img class="logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="Linnie Luz - Psicóloga - CRP 02/24957"
        title="Linnie Luz - Psicóloga - CRP 02/24957">
      </div>
      <div class="col"><?php wp_nav_menu(array('theme_location' => 'primary')); ?></div>
    </div>
  </div>
</header>
