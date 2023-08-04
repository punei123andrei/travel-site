<?php

define('ZITEC_ACF_URL', get_stylesheet_directory_uri() . '/vendor/advanced-custom-fields/advanced-custom-fields-pro/');
define('ZITEC_ACF_PATH', get_stylesheet_directory() . '/vendor/advanced-custom-fields/advanced-custom-fields-pro/');

// Include the ACF plugin.
include_once(ZITEC_ACF_PATH . 'acf.php');

add_filter('acf/settings/url', function () {
    return ZITEC_ACF_URL;
});

// Enable or disable acf in admin
add_filter('acf/settings/show_admin', '__return_true');


// define path and URL to the ACFE plugin
// define('ZITEC_ACFE_PATH', get_stylesheet_directory() . '/vendor/acf-extended/');
// define('ZITEC_ACFE_URL', get_stylesheet_directory_uri() . '/vendor/acf-extended/');

// include the ACFE plugin
// include_once(ZITEC_ACFE_PATH . 'acf-extended.php');

// customize the url setting to fix asset URLs
// add_filter('acfe/settings/url', function () {
//     return ZITEC_ACFE_URL;
// });