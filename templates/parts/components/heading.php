<?php

$text = $args['text'] ?? '';
$class = isset($args['class']) && !empty($args['class']) ? ' class="' . esc_attr($args['class']) . '"' : '';
$headingType = $args['type'] ?? 'h1';
$hasLink = isset($args['hasLink']) && $args['hasLink'] === true ? true : false;
$hasIcon = isset($args['hasIcon']) && $args['hasIcon'] === true ? true : false;
$icon = $args['icon'] ?? '';
$url = $args['url'] ?? '';

$openElement = $hasLink ? '<a href="' . esc_url($url) . '">' : '';
$closeElement = $hasLink ? '</a>' : '';

if (!empty($text) || $text === '0') {
    echo '<' . esc_attr($headingType) . $class . '>';
        if ($hasIcon) {
            get_template_part('templates/parts/components/icon', null, [
                'name'  => $icon,
            ]);
        }
        echo $openElement . esc_html($text) . $closeElement;
    echo '</' . esc_attr($headingType) . '>';
}
