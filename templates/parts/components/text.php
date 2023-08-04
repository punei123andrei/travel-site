<?php

$text = $args['text'] ?? '';
$class = isset($args['class']) && !empty($args['class']) ? ' class="' . esc_attr($args['class']) . '"' : '';
$elementType = $args['elementType'] ?? 'div';
$hasDiv = isset($args['hasDiv']) && $args['hasDiv'] === false ? false : true;

$openElement = $hasDiv ? '<' . $elementType . $class . '>' : '';
$closeElement = $hasDiv ? '</' . $elementType . '>' : '';

if (!empty($text)) {
    echo $openElement . wp_kses_post($text) . $closeElement;
}
