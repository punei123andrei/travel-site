<?php

namespace TheThemeName\Widget;

/**
 * Class used to hold all theme sidebars
 */
class Widget
{

    /**
     * Return true or false if a specific custom acf widget is to be
     * displayed on a page or not
     * @return [type] [description]
     */
    public static function showWidgetIn($block): bool
    {

        // bail if in admin
        if (is_admin()) {
            return true;
        }

        $currentId = get_queried_object()->ID;
        $showIn = get_field('show_in') ?: [];

        // if there is something selected and current id is in selected id
        $showWidget = $showIn && in_array($currentId, $showIn);

        // get current language
        $currentLanguage = apply_filters('wpml_current_language', null);

        // check if current language is block language or all is selected
        $currentOrAll = isset($block['wpml_language']) ? ($currentLanguage === $block['wpml_language'] || 'all' === $block['wpml_language']) : 'all';

        // no pages selected and current lang or all or
        // user selected a page to show the widget and current lang or all
        if ((!$showIn && $currentOrAll) || ($showWidget && $currentOrAll)) {
            return true;
        }

        return false;
    }

    /**
     * Get all sidebars widgets
     */
    public static function getAllWidgets()
    {
        $widgets = wp_get_sidebars_widgets();

        if (!isset($widgets) && !is_array($widgets)) {
            return;
        }

        global $wp_widget_factory;

        $blocks = [];

        foreach($widgets as $key => $value) {

            // Skip for inactive widgets
            if ($key == 'wp_inactive_widgets') {
                continue;
            }

            if (!isset($value) && !is_array($value) && empty($value)) {
                return;
            }

            foreach($value as $widgetId) {

                $parsedId = wp_parse_widget_id($widgetId);

                $widgetObject = $wp_widget_factory->get_widget_object($parsedId['id_base']);

                if ($widgetObject && isset($parsedId['number'])) {

                    $all_instances = $widgetObject->get_settings();
                    $instance = $all_instances[$parsedId['number']];
                    $serializedInstance = serialize($instance);

                    $prepared = [];

                    $prepared['instance']['encoded'] = base64_encode($serializedInstance);
                    $prepared['instance']['hash'] = wp_hash($serializedInstance);

                    if (!empty($widgetObject->widget_options['show_instance_in_rest'])) {

                        // Use for JSON result {} and not [] because of ajax
                        $prepared['instance']['raw'] = empty($instance) ? new stdClass : $instance;

                        if (!empty($prepared['instance']['raw']['content'])) {
                            $blocks[] = parse_blocks($prepared['instance']['raw']['content']);
                        }
                    }
                }
            }
        }

        return $blocks;
    }
}
