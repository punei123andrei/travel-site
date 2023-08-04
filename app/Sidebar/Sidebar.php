<?php

namespace Genesis\Sidebar;

/**
 * Class used to hold all theme sidebars
 */
class Sidebar
{
    /**
     * Init function
     */
    public function init(): void
    {
        // add_action('init', [$this, 'sidebars']);
    }

    /**
     * Register sidebars
     */
    public function sidebars(): void
    {

        $sidebars = [
            [
                'name'          => __('Page sidebar', 'the-theme-name-text-domain'),
                'id'            => 'page-sidebar',
                'before_widget' => '',
                'after_widget'  => '',
                'before_title'  => '<h6>',
                'after_title'   => '</h6>',
            ],
            [
                'name'          => __('Footer Sidebar 1', 'the-theme-name-text-domain'),
                'id'            => 'footer-sidebar-1',
                'before_widget' => '<div class="footer-widget">',
                'after_widget'  => '</div>',
                'before_title'  => '<h6>',
                'after_title'   => '</h6>',
            ],
            [
                'name'          => __('Footer Sidebar 2', 'the-theme-name-text-domain'),
                'id'            => 'footer-sidebar-2',
                'before_widget' => '<div class="footer-widget">',
                'after_widget'  => '</div>',
                'before_title'  => '<h6>',
                'after_title'   => '</h6>',
            ],
        ];

        foreach ($sidebars as $sidebar) {
            register_sidebar([
                'name'          => $sidebar['name'],
                'id'            => $sidebar['id'],
                'before_widget' => $sidebar['before_widget'],
                'after_widget'  => $sidebar['after_widget'],
                'before_title'  => $sidebar['before_title'],
                'after_title'   => $sidebar['after_title'],
            ]);
        }
    }
}
