<?php

$file = $args['file'] ?? '';
$btnText = $args['btnText'] ?? '';
$class = $args['class'] ?? '';
$downloadAttr = isset($args['hasDownload']) && $args['hasDownload'] === true ? 'download' : '';
$btnClass = 'bttn bttn-link bttn-align-start bttn-no-icon mt-12 ';
$target = $file['target'] ?? '_self';
$target = '_blank' == $target ? $btnClass .= ' new-tab-link' : '';
$fileExtension = !empty($file['url']) ? 'filetype-' . getFileExtensionFromUrl($file['url']) : '';
$fileTitle = $args['fileTitle'] ?: $file['title'];

?>
<?php if (!empty($file['url'])) { ?>
    <a href="<?php echo esc_url($file['url']) ?>" <?php echo esc_attr($downloadAttr) ?> class="<?php echo esc_attr($class . '__item') ?>">
        <?php get_template_part('templates/parts/components/icon', null, [
            'name' => $fileExtension,
        ]); ?>
        <?php echo esc_html($fileTitle) ?>
    </a>
<?php } ?>
