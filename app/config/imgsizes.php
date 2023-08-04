<?php

/**
 * Default images sizes -> overwritten by Theme->addImageSize()
 */
//theme support for thumbnails
add_theme_support('post-thumbnails');

//thumb sizes
add_image_size('home_banner_1x', 1920, 1080, true);
add_image_size('home_banner_2x', 3840, 2160, true);

add_image_size('small_card_photo_1x', 500, 245, true);
add_image_size('small_card_photo_2x', 800, 385, true);

add_image_size('modal_header_1x', 500, 245, true);
add_image_size('modal_header_2x', 1000, 500, true);
