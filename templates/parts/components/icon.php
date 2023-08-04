<?php

$name = $args['name'] ?? '';
$hasLink = isset($args['hasLink']) && $args['hasLink'] === true ? true : false;
$class = $args['class'] ?? '';

?>
<?php if(!empty($name)) { ?>

    <?php if($hasLink) { ?>
        <a href="#" class="<?php echo esc_attr($class) ?>">
    <?php } ?>

        <i class="bi bi-<?php echo esc_attr($name) ?>"></i>

    <?php if($hasLink) { ?>
        </a>
    <?php } ?>

<?php } ?>
