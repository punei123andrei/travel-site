<?php

$url = $args['url'] ?? '';
$text = $args['text'] ?? '';
$downloadAttr = isset($args['hasDownload']) && $args['hasDownload'] === true ? 'download' : '';
$class = 'bttn bttn-link ';
$class .= $args['class'] ?? '';
$target = $args['target'] ?? '_self';
$target = '_blank' == $target ? $class .= ' new-tab-link' : '';

?>

<?php if (!empty($url) && !empty($text)) { ?>
    <a href="<?php echo esc_url($url) ?>" <?php echo esc_attr($downloadAttr) ?> class="<?php echo esc_attr($class) ?>"><?php echo esc_html($text) ?></a>
<?php } ?>
