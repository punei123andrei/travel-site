<?php

namespace Genesis\Post;

use WP_Query;

/**
 * Class will hold all posts logic
 */
class Post
{

    /**
     * Init class
     */
    public function init(): void
    {
        // add_action('init', [$this, 'registerPostTypes']);
        // add_action('init', [$this, 'registerTaxonomies']);
    }

    /**
     * Register custom post types
     */
    public function registerPostTypes(): void
    {
        $postTypes = [
            // events
            [
                'slug'                => 'events',
                'name'                => __('Events', 'the-theme-name-text-domain'),
                'singular_name'       => __('Event', 'the-theme-name-text-domain'),
                'all_items'           => __('events', 'the-theme-name-text-domain'),
                'add_new_item'        => __('Event', 'the-theme-name-text-domain'),
                'hierarchical'        => false,
                'taxonomies'          => [
                    'category-events',
                ],
                'supports'            => [
                    'title',
                    'editor',
                    'custom-fields',
                    'thumbnail'
                ],
                'show_in_rest'        => true,
                'public'              => true,
                'show_ui'             => true,
                'show_in_nav_menus'   => false,
                'publicly_queryable'  => true,
                'exclude_from_search' => false,
                'has_archive'         => false,
                'query_var'           => true,
                'can_export'          => true,
                'rewrite'             => [
                    'slug'          => 'evenimente',
                    'with_front'    => false,
                ],
                'capability_type'     => 'post',
                'menu_position'       => 6,
                'menu_icon'           => 'dashicons-calendar-alt',
            ],

        ];

        foreach ($postTypes as $postType) {

            $labels = [
                'name'          => $postType['name'],
                'singular_name' => $postType['singular_name'],
                'all_items'     => sprintf(__('All %s', 'the-theme-name-text-domain'), $postType['all_items']),
                'add_new'       => sprintf(__('Add New %s', 'the-theme-name-text-domain'), $postType['add_new_item']),
                'add_new_item'  => sprintf(__('Add %s', 'the-theme-name-text-domain'), $postType['add_new_item']),
                'edit'          => $postType['singular_name'],
                'edit_item'     => sprintf(__('Edit %s', 'the-theme-name-text-domain'), $postType['singular_name']),
                'new_item'      => sprintf(__('New %s', 'the-theme-name-text-domain'), $postType['singular_name']),
                'view_item'     => sprintf(__('View %s', 'the-theme-name-text-domain'), $postType['singular_name']),
                'search_items'  => sprintf(__('Search %s', 'the-theme-name-text-domain'), $postType['singular_name']),
            ];

            $args = [
                'labels'              => $labels,
                'hierarchical'        => $postType['hierarchical'] ?? true,
                'show_in_rest'        => $postType['show_in_rest'] ?? false,
                'supports'            => $postType['supports'] ?? '',
                'public'              => $postType['public'] ?? true,
                'show_ui'             => $postType['show_ui'] ?? true,
                'show_in_nav_menus'   => $postType['show_in_nav_menus'] ?? true,
                'publicly_queryable'  => $postType['publicly_queryable'] ?? true,
                'exclude_from_search' => $postType['exclude_from_search'] ?? true,
                'has_archive'         => $postType['has_archive'] ?? true,
                'query_var'           => $postType['query_var'] ?? true,
                'can_export'          => $postType['can_export'] ?? true,
                'rewrite'             => $postType['rewrite'] ?? [
                    'slug' => $postType['slug'],
                ],
                'capability_type'     => $postType['capability_type'] ?? 'post',
                'menu_position'       => $postType['menu_position'] ?? 6,
                'menu_icon'           => $postType['menu_icon'] ?? false,
            ];

            register_post_type($postType['slug'], $args);
        }
    }

    /**
     * Register taxonomies
     *
     */
    public function registerTaxonomies(): void
    {
        $taxonomies = [
            [
                'post_type'     => 'events',
                'slug'          => 'category-events',
                'singular_name' => __('Category', 'the-theme-name-text-domain'),
                'plural_name'   => __('Categories', 'the-theme-name-text-domain'),
                'all_items'     => __('categories', 'the-theme-name-text-domain'),
                'add_new'       => __('category', 'the-theme-name-text-domain'),
            ],
        ];

        foreach ($taxonomies as $taxonomy) {
            $labels = [
                'name'          => $taxonomy['plural_name'],
                'singular_name' => $taxonomy['singular_name'],
                'search_items'  => sprintf(__('Search %s'), $taxonomy['singular_name']),
                'all_items'     => __('All', 'the-theme-name-text-domain'),
                'edit_item'     => sprintf(__('Edit %s', 'the-theme-name-text-domain'), $taxonomy['add_new']),
                'update_item'   => sprintf(__('Update %s', 'the-theme-name-text-domain'), $taxonomy['add_new']),
                'add_new_item'  => sprintf(__('Add %s', 'the-theme-name-text-domain'), $taxonomy['add_new']),
                'new_item_name' => sprintf(__('New %s name', 'the-theme-name-text-domain'), $taxonomy['add_new']),
                'menu_name'     => $taxonomy['plural_name'],
            ];

            $rewrite = $taxonomy['rewrite'] ?? [
                'slug' => $taxonomy['slug'],
            ];

            register_taxonomy($taxonomy['slug'], $taxonomy['post_type'], [
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'hierarchical'       => true,
                'show_in_rest'       => true,
                'show_in_menu'       => true,
                'show_in_nav_menus'  => true,
                'show_admin_column'  => true,
                'query_var'          => true,
                'meta_box_cb'        => true,
                'rewrite'            => $rewrite,
            ]);
        }
    }

    /**
     * Get taxonomies list by post type
     *
     * @param string $postType
     * @return string
     */
    public static function getTaxonomiesListByPostType(string $postType): string
    {
        $taxonomyObject = get_object_taxonomies($postType);
        $taxonomies = [];

        foreach ($taxonomyObject as $taxonomy) {
            $taxonomies[] = $taxonomy;
        }

        return implode(',', $taxonomies);
    }

    /**
     * Get posts by args
     *
     * @param  array $args Query arguments for WP_Query
     * @return array
     */
    public static function getPostsByArgs(array $args): array
    {
        return self::performQuery($args);
    }

    public static function getQueryByArgs(array $args): object
    {
        return new WP_Query($args);
    }

    /**
     * Perform a WP_Query with specific args
     *
     * @param  array $args Arguments passed to WP_Query
     * @return array
     */
    public static function performQuery(array $args): array
    {
        // query
        $query = self::getQueryByArgs($args);

        // return empty array if no posts found
        if (!$query->posts) {
            return [];
        }

        return $query->posts;
    }

    /**
     * Return a post type for a post id
     *
     * @param string $postId
     * @return string
     */
    public static function getPostTypeByPostId(string $postId): string
    {
        // bail early
        if (empty($postId)) {
            return '';
        }

        // get post by id
        $post = get_post($postId);

        return !empty($post) ? $post->post_type : '';
    }
}
