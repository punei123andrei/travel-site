<?php

namespace Genesis\Block;

use function Genesis\mix;

/**
 * Class AcfBlocks
 */
class Block
{

    /**
     * @var string
     * Define Block path
     */
    private string $blocksPath = '/templates/blocks/';

    /**
     * Define custom blocks prefix
     * @var string
     */
    private string $prefix = 'the-theme-name-text-domain'; // change this to theme slug

    /**
     * Custom blocks
     * @var array
     */
    private array $blocks = [
        // [
        //     'name'        => 'default-block',
        //     'title'       => 'Default block',
        //     'description' => 'A default block for this theme',
        //     'keywords'    => [],
        //     'jsx'         => false, // if innerBlocks use true here
        //     'type'        => [
        //         'page',
        //         'post',
        //     ],
        // ],
        // [
        //      'name'          => 'widget',
        //      'title'         => 'Default Widget Block',
        //      'description'   => 'A a default widget block.',
        //      'keywords'      => [],
        //      'jsx'           => true,
        //      'type'          => [
        //          'widgets',
        //      ],
        //  ],
    ];

    /**
     * Default core blocks
     * @var array
     */
    private array $defaultCoreAllowedBlocks = [
        // 'core/column',
        // 'core/columns',
        // 'core/embed',
        // 'core/group',
        // 'core/image',
        // 'core/missing',
        // 'core/shortcode',
        // 'core/video',
        // 'core/audio',
        // 'core/paragraph',
        // 'core/heading',
        // 'core/list',
        // 'core/list-item',
    ];

    /**
     * Default core widget blocks
     * @var array
     */
    private array $defaultCoreWidgetBlocks = [
        // 'core/list',
        // 'core/list-item',
        // 'core/image',
        // 'core/heading',
        // 'core/paragraph',
        // 'core/shortcode',
        // 'core/embed',
    ];

    /**
     * Init class
     */
    public function init(): void
    {
        if (function_exists('acf_register_block_type')) {

            // register categories
            add_filter('block_categories_all', [$this, 'registerAcfBlockCategories'], 10, 2);

            // register blocks
            add_action('init', [$this, 'registerAcfBlocks']);
        }

        // add_filter('render_block', [$this, 'wrapCoreBlocks'], 10, 2);
    }

    /**
     * Register acf blocks
     */
    public function registerAcfBlocks(): void
    {
        if (empty($this->blocks)) {
            return;
        }

        foreach ($this->blocks as $block) {

            // return early if no block name
            if (!isset($block['name'])) {
                continue;
            }

            // there is a block name but no actual block directory
            if (!file_exists($this->getBlockAbsolutePath($block['name']))) {
                continue;
            }

            $this->registerBlockType($block);
        }

    }

    /**
     * Register blocks depending on condition of type
     */
    private function registerBlockType($block): void
    {
        $blockPreviewImg = '/images/blocks/' . $this->prefix . '-' . $block['name'] . '.png';

        // custom post block args
        $postBlockArgs = [
            'post_types' => $block['type'],
            'category'   => $this->prefix,
            'example'    => [
                'attributes' => [
                    'mode' => 'preview',
                    'data' => [
                        'preview_image' => file_exists(get_template_directory() . '/public' . $blockPreviewImg) ? mix($blockPreviewImg) : '',
                    ],
                ],
            ],
        ];

        // custom widget block args
        $widgetsBlockArgs = [
            'category' => 'widgets',
        ];

        // default block args
        $blockArgs = [
            'name'            => $this->prefix . '-' . $block['name'],
            'title'           => ucfirst($this->prefix) . ' ' . $block['title'],
            'description'     => $block['description'] ?? '',
            'keywords'        => $block['keywords'] ?? [],
            'mode'            => 'auto',
            'supports'        => [
                'align'     => [],
                'mode'      => false,
                'multiple'  => true,
                'jsx'       => $block['jsx'] ?? false,
                'className' => true,
            ],
            'align_content'     => null,
            'render_template'   => $this->getBlockAbsolutePath($block['name']),
            'icon'              => '',
        ];

        if (in_array('post', $block['type']) || in_array('page', $block['type'])) {
            $blockArgs = array_merge($blockArgs, $postBlockArgs);
        }

        // we have type of widgets add category
        if (in_array('widgets', $block['type'])) {
            $blockArgs = array_merge($blockArgs, $widgetsBlockArgs);
        }

        // register args
        acf_register_block_type($blockArgs);
    }

    /**
     * Gets a block absolute path
     *
     * @param string $blockName Blockname to check
     */
    private function getBlockAbsolutePath(string $blockName): string
    {
        return get_template_directory() . $this->blocksPath . $this->prefix . '-' . $blockName . '/index.php';
    }

    /**
     * Register custom blocks category
     *
     * @param array $categories Wordpress block categories
     * @param object $context The current block editor context.
     */
    public function registerAcfBlockCategories(array $categories, object $context): array
    {
        return array_merge(
            $categories,
            [
                [
                    'slug'  => $this->prefix,
                    'title' => ucfirst($this->prefix),
                ],
            ],
        );
    }

    /**
     * Get blocks size field block_size
     *
     */
    public static function getBlockSize(): string
    {
        return get_field('block_size') ?? 'container';
    }

    /**
     * Get blocks size field block_size
     *
     */
    public static function getBlockInnerSize(): string
    {
        return get_field('block_inner_size') ?? 'col-12';
    }

    /**
     * Get block per row items from block_per_row
     */
    public static function getBlockPerRow(): string
    {
        return get_field('block_per_row') ?? 'col-12 col-xl-4';
    }

    /**
     * Get background image
     *
     * @param boolean $subfield If should use get_sub_field() function
     */
    public static function getBlockBackgroundImage(bool $subfield = false)
    {
        return $subfield ? (get_sub_field('background_image') ?: []) : (get_field('background_image') ?: []);
    }

    /**
     * Get background color
     *
     * @param boolean $subfield If should use get_sub_field() function
     */
    public static function getBlockBackgroundColor(bool $subfield = false): string
    {
        return $subfield ? (get_sub_field('background_color') ?: '') : (get_field('background_color') ?: '');
    }

    /**
     * Get background overlay
     */
    public static function getBlockBackgroundOverlay(): bool
    {
        return get_field('background_overlay') ?? false;
    }

    /**
     * Get background overlay blur
     */
    public static function getBlockBackgroundOverlayBlur(): bool
    {
        return get_field('background_overlay_blur') ?? false;
    }

    /**
     * Get margins or paddings
     */
    public static function getBlockMarginOrPadding(string $what = 'margin', string $where = 'top'): string
    {
        return get_field('block_' . $what . '_' . $where) ?? '';
    }

    /**
     * Returns css style attribute rules from default block styling
     *
     */
    public static function getBlockStyles(array $additionalRules = []): string
    {
        // rule set
        $rules = [];

        $prefix = (new self)->getPrefix();

        // get background image array for all blocks
        $backgroundImage = self::getBlockBackgroundImage();

        $defaultStyleRules = [
            'background-color' => self::getBlockBackgroundColor(),
            'margin-top'       => self::getBlockMarginOrPadding(),
            'margin-bottom'    => self::getBlockMarginOrPadding('margin', 'bottom'),
            'padding-top'      => self::getBlockMarginOrPadding('padding', 'top'),
            'padding-bottom'   => self::getBlockMarginOrPadding('padding', 'bottom'),
        ];

        // add background image rules
        if ($backgroundImage) {
            $defaultStyleRules['background-image'] = $backgroundImage ? 'url(' . esc_url($backgroundImage['sizes'][$prefix . '-section-banner']) . ')' : '';
            $defaultStyleRules['background-size'] = 'cover';
            $defaultStyleRules['background-repeat'] = 'no-repeat';
        }

        // merge default rules with additional rules
        $mergedRules = array_merge($defaultStyleRules, $additionalRules);

        // add array key and value as rule (property: value)
        foreach ($mergedRules as $key => $value) {

            // if value is not empty or is not 0px add it to styles
            if (!empty($value) && '0px' != $value) {
                $rules[] = $key . ': ' . $value . ';';
            }
        }

        // return a string with rules
        return implode(' ', $rules);
    }

    /**
     * Display a background overlay
     */
    public static function displayBlockBackgroundOverlay(): string
    {
        $output = '';
        $className = '';

        // get background color
        $backgroundColor = self::getBlockBackgroundColor();
        $backgroundColor = !empty($backgroundColor) ? hex2rgba($backgroundColor, 0.8) : '';

        // get background overlay
        $backgroundOverlay = self::getBlockBackgroundOverlay();
        $className .= $backgroundOverlay ? ' has-overlay-bg' : '';

        // get background blur
        $bgOverlayBlur = self::getBlockBackgroundOverlayBlur();
        $className .= $bgOverlayBlur ? ' has-overlay-bg-blur' : '';
        $style = 'style="background: transparent linear-gradient(0deg, ' . $backgroundColor . ' 0%, ' . $backgroundColor . ' 100%);"';

        // if there is a background overlay and a background color make the element
        if ($backgroundOverlay && $backgroundColor) {
            $output .= '<div class="overlay' . esc_attr($className) . '" ' . $style . '></div>';
        }

        return $output;
    }

    /**
     * Gets block classes
     *
     * @param array $block Block element to get classes for
     *
     */
    public static function getBlockClasses(array $block): string
    {
        if (!$block) {
            return '';
        }

        // get block name
        $blockName = getBlockName($block['name']);

        // get block size
        $blockSize = self::getBlockSize();

        $prefix = (new self)->getPrefix();

        $classes = [];

        // get additional block classes from admin Advanced
        if (isset($block['className']) && !empty($block['className'])) {
            $classes[] = ' ' . $block['className'];
        }

        $className = implode('', $classes);

        // construct block class name
        return $blockName . '-block ' . $prefix . '-custom-block ' . $blockSize . $className;
    }

    /**
     * Alter wp core blocks and wrap then in bootstrap structure
     * Front end function only
     *
     * @param string $blockContent Block content
     * @param array $block Block data
     *
     */
    public function wrapCoreBlocks(string $blockContent, array $block): string
    {
        // check block list
        $checkBlocks = $this->blockInList($block['blockName'], $this->defaultCoreAllowedBlocks);

        // check default blocks and wrap with bootstrap markup if not in admin
        if ($checkBlocks) {

            // add bootstrap to default blocks except column
            if ('core/column' != $block['blockName'] && 'core/columns' != $block['blockName']) {
                $html = '';
                $html .= outputBootstrapWrapped($blockContent);
                return $html;
            }
        }

        return $blockContent;
    }

    /**
     * Check if specific block is a block list and is not on admin and there is no ajax request
     *
     * @param string $blockName Block name to check
     * @param array $blockList Block list to check against
     *
     */
    private function blockInList(string $blockName, array $blockList): bool
    {
        return in_array($blockName, $blockList, true);
    }

    /**
     * Allow blocks to admin editor view
     *
     * @param string $allowedBlocks Allowed block string
     * @param  [type] $editorContext               Editor context
     *
     */
    public function allowCoreBlocksToAdminView(string $allowedBlocks, $editorContext)
    {
        // get all acf ase blocks
        $aseBlocks = $this->blocks;

        $allowed = [];

        // get current acf allowed blocks
        foreach ($aseBlocks as $block) {
            $allowed[] = 'acf/' . $this->prefix . '-' . $block['name'];
        }

        // allow blocks if in edit-widgets screen
        if ('core/edit-widgets' === $editorContext->name) {

            // merge core allowed blocks in widgets with acf
            $allowedInWidgets = array_merge($this->defaultCoreWidgetBlocks, $allowed);

            return $allowedInWidgets;
        }

        // allow blocks on pages, posts edit screens
        if ('core/edit-post' === $editorContext->name) {

            $widgetBlock = array_search('acf/ase-widget', $allowed);

            if($widgetBlock !== false) {

                // remove widget block from allowed acf blocks
                unset($allowed[$widgetBlock]);

                // reindex allowed acf blocks
                $allowed = array_values($allowed);
            }

            // merge core allowed blocks in posts with acf
            $allowedInPosts = array_merge($this->defaultCoreAllowedBlocks, $allowed);

            return $allowedInPosts;
        }

        // return 1
        return $allowedBlocks;
    }

    /**
     * Get field value by field name of a block name if that exists in content
     *
     * @param string $field Field name to get value
     * @param string $blockName Block name to look for the field value
     * @return bool
     */
    public static function displayBlockField(string $field, string $blockName): bool
    {
        // return early
        if (empty($field) && empty($blockName)) {
            return false;
        }

        // get blocks from content with parse_blocks
        $blocks = self::parseBlocks(get_the_ID());

        foreach ($blocks as $block) {
            if ($block['blockName'] == $blockName) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get blocks from post content by id
     *
     * @param  int   $id        Post id to retrieve blocks from
     */
    public static function parseBlocks(int $id): array
    {
        return parse_blocks(get_the_content('', false, $id)) ?? [];
    }

    /**
     * Prefix getter
     *
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

}
