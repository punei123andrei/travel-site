<?php

namespace TheThemeName;

use InvalidArgumentException;
use JsonException;

if (!function_exists('mix')) {
    /**
     * Get the path to a versioned Mix file
     *
     * @param string $path
     * @param string $manifestDirectory
     * @return string
     *
     * @throws \Exception
     */

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param string $haystack
     * @param string|string[] $needles
     * @return bool
     */
    function startsWith(string $haystack, $needles): bool
    {
        foreach ((array)$needles as $needle) {
            if ($needle !== '' && strpos($haystack, (string)$needle) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Generate the URL to a theme script or style
     *
     * @param string $path
     * @param string $manifestDirectory
     * @return string
     * @throws JsonException
     */
    function mix(string $path, string $manifestDirectory = ''): string
    {
        static $manifest;
        $publicFolder = '';
        $rootPath = get_template_directory() . '/public';
        if ($manifestDirectory && !startsWith($manifestDirectory, '/')) {
            $manifestDirectory = "/{$manifestDirectory}";
        } else {
            $manifestDirectory = $publicFolder;
        }

        if (!$manifest) {
            if (!file_exists($manifestPath = ($rootPath . $manifestDirectory . '/mix-manifest.json'))) {
                throw new InvalidArgumentException('The Mix manifest does not exist.');
            }
            $manifest = json_decode(file_get_contents($manifestPath), true, 512, JSON_THROW_ON_ERROR);
        }
        if (!startsWith($path, '/')) {
            $path = "/{$path}";
        }
        $path = $publicFolder . $path;

        if (!array_key_exists($path, $manifest)) {
            throw new InvalidArgumentException(
                "Unable to locate Mix file: {$path}. Please check your " .
                'webpack.mix.js output paths and try again.'
            );
        }

        return get_template_directory_uri() . '/public' . $manifestDirectory . $manifest[$path];
    }

    /**
     * Generate the URL to a theme asset.
     *
     * @param string $path
     * @return string
     */
    function asset(string $path): string
    {
        if (wp_http_validate_url($path)) {
            return $path;
        }

        return get_template_directory_uri() . '/public' . $path;
    }
}
