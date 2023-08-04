<?php

$imageArray = $args['image'] ?? [];
$imageSize = $args['imageSize'] ?? '';
$image = $imageArray ? (!empty($imageSize) ? $imageArray['sizes'][$imageSize] : $imageArray['url'] ) : '';
$width = $imageArray ? $imageArray['width'] : '';
$height = $imageArray ? $imageArray['height'] : '';
$alt = $imageArray ? $imageArray['alt'] : '';
$class = isset($args['class']) && !empty($args['class']) ? 'class="' . esc_attr($args['class']) . '"' : '';

?>

<?php if($image) { ?>
    <img src="<?php echo esc_url($image) ?>" alt="<?php echo esc_html($alt) ?>" width="<?php echo esc_attr($width) ?>" height="<?php echo esc_attr($height) ?>" <?php echo $class ?> />
<?php } ?>
