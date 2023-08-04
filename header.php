<?php

use Genesis\Theme\Theme;

$headerFields = Theme::getHeaderFields();

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>

    <?php
        // display header scripts
        if (!empty($headerFields['header_scripts'])) {
            echo $headerFields['header_scripts'];
        }
    ?>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=6.0"/>
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php get_template_part('templates/parts/favicon'); ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
