<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header">
      <div class="wrapper">
        <div class="site-header__logo">
          <?php 
          $site_logo = get_field('site_logo', 'options');
          ?>
          <img loading="lazy" src="<?php echo esc_url($site_logo); ?>" />
        </div>

        <div class="site-header__menu-icon">
          <div class="site-header__menu-icon__middle"></div>
        </div>

        <div class="site-header__menu-content">
          <div class="site-header__btn-container">
            <a href="#" class="btn open-modal">Get in Touch</a>
          </div>
          <nav class="primary-nav primary-nav--pull-right">
            <ul>
              <li><a href="#our-beginning" id="our-beginning-link">Our Beginning</a></li>
              <li><a href="#features" id="features-link">Features</a></li>
              <li><a href="#testimonials" id="testimonials-link">Testimonials</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </header>