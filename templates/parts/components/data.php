<?php

$data = $args['data'] ?? [];
$class = isset($args['class']) && !empty($args['class']) ? 'class="' . esc_attr($args['class']) . '"' : '';

$dataAttr = [];

foreach ($data as $attr) {
    if (!empty($attr['name']) && !empty($attr['value'])) {
        $dataAttr[] = esc_attr('data-' . $attr['name'] . '=' . $attr['value'] );
    }
}
$dataAttrString = implode(' ' , $dataAttr);

?>
<?php if ($dataAttr) { ?>
    <div <?php echo $class ?> <?php echo $dataAttrString ?>></div>
<?php } ?>
