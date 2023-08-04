<?php
/*
Template Name: Travel Agency
*/

get_header();
$path = 'templates/template-parts/travel/template';
get_template_part($path, 'hero');
get_template_part($path, 'beginning');
get_template_part($path, 'features');
get_template_part($path, 'testimonials');
get_footer();