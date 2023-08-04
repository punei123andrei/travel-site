<?php

$class = $args['class'] ?? '';
$container = $args['container'] ?? '';
$videoFile = $args['videoFile'] ?? '';

?>
<?php if (!empty($videoFile)) { ?>
    <div class="<?php echo esc_attr($class) ?>" data-video-container="<?php echo esc_attr($container) ?>" data-video-url="<?php echo esc_url($videoFile) ?>"></div>
    <div class="artplayer-app <?php echo esc_attr($container) ?>"></div>
<?php } ?>
