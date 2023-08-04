<?php

namespace Genesis\Cleanup;

use Genesis\Block\Block;


/**
 * Class used for theme cleanup
 */
class Cleanup
{

    /**
     * Init function
     */
    public function init(): void
    {
        add_action('init', [$this, 'cleanHead']);
        add_action('admin_init', [$this, 'cleanDashboard']);

        add_action('do_feed_rss2_comments', [$this, 'cleanFeed'], 1);
        add_action('do_feed_atom_comments', [$this, 'cleanFeed'], 1);
        add_action('do_feed', [$this, 'cleanFeed'], 1);
        add_action('do_feed_rdf', [$this, 'cleanFeed'], 1);
        add_action('do_feed_rss', [$this, 'cleanFeed'], 1);
        add_action('do_feed_rss2', [$this, 'cleanFeed'], 1);
        add_action('do_feed_atom', [$this, 'cleanFeed'], 1);
        add_action('init', [$this, 'disableEmojis']);

        add_filter('xmlrpc_enabled', '__return_false');
        add_filter('xmlrpc_methods', [$this, 'disableXmlRpcMethods']);
        add_filter('comments_open', [$this, 'disableComments']);

        add_filter('deprecated_function_trigger_error', [$this, 'disableDeprecatedWarnings']);
        add_filter('deprecated_argument_trigger_error', [$this, 'disableDeprecatedWarnings']);
        add_filter('deprecated_file_trigger_error', [$this, 'disableDeprecatedWarnings']);
        add_filter('deprecated_hook_trigger_error', [$this, 'disableDeprecatedWarnings']);

        add_action('admin_bar_menu', [$this, 'removeCustomizerFromAdminBar'], 999);
        add_action('admin_menu', [$this, 'removeCustomizerFromMenu'], 999);

        add_action('wp_enqueue_scripts', [$this, 'deregisterCF7Scripts'], 99);
    }

    /**
     * Dequeue contact form scripts for specific blocks
     */
    public function deregisterCF7Scripts(): void
    {
        $block = new Block();

       // if there is no cf7 block then dequeue scripts
        if (!Block::displayBlockField('choose_form', 'acf/' . $block->getPrefix() . '-form')) {
            dequeueContactScripts();
        }
    }

    /**
     * Clean wp head
     */
    public function cleanHead(): void
    {
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
        remove_action('wp_head', 'rel_canonical');
        remove_action('wp_head', 'feed_links_extra', 3);
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'index_rel_link');
        remove_action('wp_head', 'parent_post_rel_link');
        remove_action('wp_head', 'start_post_rel_link');
        remove_action('wp_head', 'adjacent_posts_rel_link');
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
        remove_action('wp_head', 'rest_output_link_wp_head', 10);
        remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
        remove_action('wp_head', 'wp_oembed_add_host_js');
        remove_action('template_redirect', 'rest_output_link_header', 11, 0);
        remove_action('wp_head', 'wp_generator');
        add_filter('use_default_gallery_style', '__return_false');
        add_filter('show_recent_comments_widget_style', '__return_false');

        // Remove <p> and <br/> from Contact Form 7
        add_filter('wpcf7_autop_or_not', '__return_false');
    }

    /**
     * Clean wp feed
     */
    public function cleanFeed(): void
    {
        wp_die('There is no feed available. Please visit <a href="' . esc_url(home_url('/')) . '">home</a>!');
    }

    /**
     * @return void
     */
    public function disableEmojis(): void
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        add_filter('tiny_mce_plugins', [$this, 'disableEmojisTinymce']);
        add_filter('wp_resource_hints', [$this, 'disableEmojisRemoveDnsPrefetch'], 10, 2);
    }

    /**
     * Filter out the tinymce emoji plugin.
     * @param array $plugins
     * @return array
     */
    public function disableEmojisTinymce(array $plugins): array
    {
        if (is_array($plugins)) {
            return array_diff($plugins, ['wpemoji']);
        }

        return [];
    }

    /**
     * Remove emoji CDN hostname from DNS prefetching hints.
     *
     * @param array $urls URLs to print for resource hints.
     * @param $relationType
     * @return array
     */
    public function disableEmojisRemoveDnsPrefetch(array $urls, $relationType): array
    {
        if ('dns-prefetch' == $relationType) {
            /** This filter is documented in wp-includes/formatting.php */
            $emojiSvgUrl = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');

            $urls = array_diff($urls, [$emojiSvgUrl]);
        }

        return $urls;
    }

    /**
     * Disable xmlrpc
     */
    public function disableXmlRpcMethods(): array
    {
        return [];
    }

    /**
     * Clean wp admin dashboard
     */
    public function cleanDashboard(): void
    {
        if (current_user_can('manage_options')) {
            return;
        }

        remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
        remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
        remove_meta_box('dashboard_primary', 'dashboard', 'normal');
        remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
        remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
        remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
        remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
        remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
        remove_meta_box('dashboard_activity', 'dashboard', 'normal');
    }

    /**
     * Disable comments
     */
    public function disableComments(): bool
    {
        return false;
    }

    /**
     * Disable deprecated warnings
     */
    public function disableDeprecatedWarnings(): bool
    {
        return false;
    }

    /**
     * Removes customizer admin menu link
     */
    function removeCustomizerFromMenu(): void
    {
        $customize_url_arr = [];
        $customize_url_arr[] = 'customize.php'; // 3.x
        $customize_url = add_query_arg('return', urlencode(wp_unslash($_SERVER['REQUEST_URI'])), 'customize.php');
        $customize_url_arr[] = $customize_url; // 4.0 & 4.1

        if (current_theme_supports('custom-header') && current_user_can('customize')) {
            $customize_url_arr[] = add_query_arg('autofocus[control]', 'header_image', $customize_url); // 4.1
            $customize_url_arr[] = 'custom-header'; // 4.0
        }

        if (current_theme_supports('custom-background') && current_user_can('customize')) {
            $customize_url_arr[] = add_query_arg('autofocus[control]', 'background_image', $customize_url); // 4.1
            $customize_url_arr[] = 'custom-background'; // 4.0
        }

        foreach ($customize_url_arr as $customize_url) {
            remove_submenu_page('themes.php', $customize_url);
        }
    }

    /**
     * Disable customizer from admin bar
     * @param $wpAdminBar
     */
    public function removeCustomizerFromAdminBar($wpAdminBar): void
    {
        $wpAdminBar->remove_menu('customize');
    }
}
