<?php 

function  gn_travel_styles() {
    // Main Style
    wp_enqueue_style( 'gn-travel-style', get_stylesheet_uri(), array(), '1.0' );

    // Template Styles
    wp_enqueue_style( 'gn-template-style', get_template_directory_uri() . '/dist/styles.css', array(), microtime() );
}

add_action( 'wp_enqueue_scripts', 'gn_travel_styles' );
