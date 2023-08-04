<?php

namespace Genesis\Theme;

/**
 * Class used to hold all theme setup logic
 */
class Theme
{

    /**
     * Theme constructor.
     */
    public function __construct()
    {
        $this->addSupport('title-tag')
            ->addSupport('custom-logo')
            ->addSupport('post-thumbnails')
            ->addSupport('responsive-embeds')
            ->addSupport('editor-styles')
            ->addSupport('customize-selective-refresh-widgets')
            ->addSupport('html5', [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'post-thumbnails',
            ]);


        $this->addCommentScript();
    }

    /**
     * @param $function
     */
    private function actionInit($function): void
    {
        add_action('init', function () use ($function) {
            $function();
        });
    }

    /**
     * @param $function
     */
    private function actionAfterSetup($function): void
    {
        add_action('after_setup_theme', function () use ($function) {
            $function();
        });
    }

    /**
     * Enqueue script on front end
     * @param $function
     * @return void
     */
    private function actionEnqueueScripts($function): void
    {
        add_action('wp_enqueue_scripts', function () use ($function) {
            $function();
        });
    }

    /**
     * @param $feature
     * @param null $options
     * @return $this
     */
    public function addSupport($feature, $options = null): Theme
    {
        $this->actionAfterSetup(function () use ($feature, $options) {
            if ($options) {
                add_theme_support($feature, $options);
            } else {
                add_theme_support($feature);
            }
        });
        return $this;
    }

    /**
     * @param string $postType
     * @param string $feature
     * @return $this
     */
    public function removePostTypeSupport(string $postType, string $feature): Theme
    {
        $this->actionInit(function () use ($postType, $feature) {
            remove_post_type_support($postType, $feature);
        });
        return $this;
    }

    /**
     * @param $feature
     * @return $this
     */
    public function removeSupport($feature): Theme
    {
        $this->actionInit(function () use ($feature) {
            remove_theme_support($feature);
        });
        return $this;
    }

    /**
     * @param string $domain
     * @param bool $path
     * @return $this
     */
    public function loadTextDomain(string $domain, bool $path = false): Theme
    {
        $this->actionAfterSetup(function () use ($domain, $path) {
            load_theme_textdomain($domain, $path);
        });
        return $this;
    }

    /**
     * @param string $name
     * @param int $width
     * @param int $height
     * @param bool $crop
     * @return $this
     */
    public function addImageSize(string $name, int $width = 0, int $height = 0, bool $crop = false): Theme
    {
        $this->actionAfterSetup(function () use ($name, $width, $height, $crop) {
            add_image_size($name, $width, $height, $crop);
        });
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function removeImageSize(string $name): Theme
    {
        $this->actionAfterSetup(function () use ($name) {
            remove_image_size($name);
        });
        return $this;
    }


    /**
     * @param string $handle
     * @param string $src
     * @param array $deps
     * @param string|null $ver
     * @param string $media
     * @return $this
     */
    public function addStyle(string $handle, string $src = '', array $deps = [], ?string $ver = null, string $media = 'all'): Theme
    {
        $this->actionEnqueueScripts(function () use ($handle, $src, $deps, $ver, $media) {
            wp_enqueue_style($handle, $src, $deps, $ver, $media);
        });
        return $this;
    }

    /**
     * @param string $template
     * @param string $handle
     * @param string $src
     * @param array $deps
     * @param string|null $ver
     * @param string $media
     * @return $this
     */
    public function addTemplateStyle(string $template, string $handle, string $src = '', array $deps = [], ?string $ver = null, string $media = 'all'): Theme
    {
        $this->actionEnqueueScripts(function () use ($template, $handle, $src, $deps, $ver, $media) {
            if (is_page_template($template)) {
                wp_enqueue_style($handle, $src, $deps, $ver, $media);
            }
        });
        return $this;
    }

    /**
     * @param string $handle
     * @param string $src
     * @param array $deps
     * @param string|null $ver
     * @param false $in_footer
     * @return $this
     */
    public function addScript(string $handle, string $src = '', array $deps = [], ?string $ver = null, bool $in_footer = false): Theme
    {
        $this->actionEnqueueScripts(function () use ($handle, $src, $deps, $ver, $in_footer) {
            wp_register_script($handle, $src, $deps, $ver, $in_footer);
            wp_enqueue_script($handle);
        });
        return $this;
    }

    /**
     * @param string $template
     * @param string $handle
     * @param string $src
     * @param array $deps
     * @param string|null $ver
     * @param false $in_footer
     * @return $this
     */
    public function addTemplateScript(string $template, string $handle, string $src = '', array $deps = [], ?string $ver = null, bool $in_footer = false): Theme
    {
        $this->actionEnqueueScripts(function () use ($template, $handle, $src, $deps, $ver, $in_footer) {
            if (is_page_template($template)) {
                wp_enqueue_script($handle, $src, $deps, $ver, $in_footer);
            }
        });
        return $this;
    }

    /**
     * @return $this
     */
    public function addCommentScript(): Theme
    {
        $this->actionEnqueueScripts(function () {
            if (is_singular() && comments_open() && get_option('thread_comments')) {
                wp_enqueue_script('comment-reply');
            }
        });
        return $this;
    }

    /**
     * @param $handle
     * @return $this
     */
    public function removeStyle($handle): Theme
    {
        $this->actionEnqueueScripts(function () use ($handle) {
            wp_dequeue_style($handle);
            wp_deregister_style($handle);
        });
        return $this;
    }

    /**
     * @param $handle
     * @return $this
     */
    public function removeScript($handle): Theme
    {
        $this->actionEnqueueScripts(function () use ($handle) {
            wp_dequeue_script($handle);
            wp_deregister_script($handle);
        });
        return $this;
    }

    /**
     * @param array $locations
     * @return $this
     */
    public function addNavMenus(array $locations = []): Theme
    {
        $this->actionAfterSetup(function () use ($locations) {
            register_nav_menus($locations);
        });
        return $this;
    }

    /**
     * @param $location
     * @param $description
     * @return $this
     */
    public function addNavMenu($location, $description): Theme
    {
        $this->actionAfterSetup(function () use ($location, $description) {
            register_nav_menu($location, $description);
        });
        return $this;
    }

    /**
     * @param $location
     * @return $this
     */
    public function removeNavMenu($location): Theme
    {
        $this->actionAfterSetup(function () use ($location) {
            unregister_nav_menu($location);
        });
        return $this;
    }

    /**
     * @param $hookName
     * @param $callback
     * @param int $priority
     * @param int $accepted_args
     * @return $this
     */
    public function addFilter($hookName, $callback, $priority = 10, $accepted_args = 1): Theme
    {
        $this->actionInit(function () use ($hookName, $callback, $priority, $accepted_args) {
            add_filter($hookName, $callback, $priority, $accepted_args);
        });

        return $this;
    }

    /**
     * @param $hookName
     * @param $callback
     * @param int $priority
     * @return $this
     */
    public function removeFilter(string $hookName, $callback, int $priority = 10): Theme
    {
        $this->actionInit(function () use ($hookName, $callback, $priority) {
            remove_filter($hookName, $callback, $priority);
        });

        return $this;
    }

    /**
     * Get header fields from Theme Settings
     */
    public static function getHeaderFields(): array
    {
        return [
            'logo'              => get_field('logo', 'options') ?? '',
            'logo_mobile'       => get_field('logo_mobile', 'options') ?? '',
            'header_scripts'    => get_field('header_scripts', 'options') ?? '',
        ];
    }

    /**
     * Get footer fields from Theme Settings
     */
    public static function getFooterFields(): array
    {
        return [
            'copyright'         => get_field('copyright', 'options') ?? '',
            'footer_scripts'    => get_field('footer_scripts', 'options') ?? '',
            'social_links'      => get_field('social_links', 'options') ?? [],
        ];
    }

    /**
     * Get footer fields from Theme Settings
     * @return array
     */
    public static function getGeneralFields(): array
    {
        return [
            'default_image'     => get_field('default_image', 'options') ?? '',
            'email'             => get_field('email', 'options') ?? '',
            'phone'             => get_field('phone', 'options') ?? '',
            'address'           => get_field('address', 'options') ?? '',
            'mapUrl'            => get_field('map_url', 'options') ?? '',
        ];
    }
}
