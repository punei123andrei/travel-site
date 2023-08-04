<?php 

namespace Genesis;

use function Genesis\asset;

/** Register The Auto Loader */
if (!file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'the-theme-name-text-domain'));
}
require $composer;

function  gn_travel_styles() {
    // Main Style
    wp_enqueue_style( 'gn-travel-style', get_stylesheet_uri(), array(), '1.0' );

    // Template Styles
    wp_enqueue_style( 'gn-template-style', get_template_directory_uri() . '/dist/styles.css', array(), microtime() );
}

add_action( 'wp_enqueue_scripts', 'gn_travel_styles' );

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title'    => __('Travel Page Settings', 'genos'),
        'menu_title'    => __('Travel Page Settings', 'genos'),
        'menu_slug'     => 'theme-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}

// Enable SVG file uploads
function custom_mime_types( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'custom_mime_types' );
