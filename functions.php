<?php 

namespace Genesis;

// use function Genesis\asset;

/** Register The Auto Loader */
if (!file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'the-theme-name-text-domain'));
}
require $composer;


use Genesis\Admin\AcfAutosize;
use Genesis\Theme\Theme;
use Genesis\Cleanup\Cleanup;

/**
 * Theme config files, global scope
 * @var array
 */
$configFiles = [
    'acf'           => 'app/config/acf',
    'helpers'       => 'app/config/helpers',
    'imageSizes'    => 'app/config/imgs',
    'rewrites'      => 'app/config/rewrites',
    'security'      => 'app/config/security',
    'tables'        => 'app/config/tables',
];

foreach ($configFiles as $config) {
    require_once get_stylesheet_directory() . "/$config.php";
}

add_action('acf/init', function () {

    /**
     * Acf autoresize boxes in admin
     * @var AcfAutosize
     */
    $acfResize = new AcfAutosize();
    $acfResize->init();

    /**
     * Add options page
     */
    if( function_exists('acf_add_options_page') ) {
        acf_add_options_page(array(
            'page_title'    => __('Travel Page Settings', 'genos'),
            'menu_title'    => __('Travel Page Settings', 'genos'),
            'menu_slug'     => 'theme-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ));
    }

});

/**
 * Cleanup logic
 */
$cleanup = new Cleanup();
$cleanup->init();


/**
 * Init theme
 */
$theme = new Theme();
$theme->addStyle('gn-travel-style', get_stylesheet_uri(), [], '1.1');
$theme->addStyle('gn-template-style', get_template_directory_uri() . '/dist/styles.css', [], microtime());




