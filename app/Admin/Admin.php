<?php

namespace Genesis\Admin;

/**
 * Class will hold all admin logic
 */
class Admin
{

    /**
     * Init class
     */
    public function init(): void
    {
        // empty for now
    }

    /**
     * @param string $handle
     * @param string $src
     * @param array $deps
     * @param string|null $ver
     * @param string $media
     * @return $this
     */
    public function addAdminStyle(string $handle, string $src = '', array $deps = [], ?string $ver = null, string $media = 'all'): Admin
    {
        $this->actionEnqueueAdminScripts(function () use ($handle, $src, $deps, $ver, $media) {
            wp_enqueue_style($handle, $src, $deps, $ver, $media);
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
    public function addAdminScript(string $handle, string $src = '', array $deps = [], ?string $ver = null, bool $inFooter = false): Admin
    {
        $this->actionEnqueueAdminScripts(function () use ($handle, $src, $deps, $ver, $inFooter) {
            wp_register_script($handle, $src, $deps, $ver, $inFooter);
            wp_enqueue_script($handle);
        });
        return $this;
    }

    /**
     * Add localized admin script
     *
     * @param  string  $handle                Name of the script. Should be unique.
     * @param  string  $src                   Full URL of the script, or path of the script
     * @param  array   $deps                  An array of registered script handles this script depends
     * @param string|null $ver                Script version
     * @param  boolean $inFooter              Whether to enqueue the script in footer or head
     * @param  string  $ajaxObject            Ajax object handle name
     * @param  array   $localisationArray     Array containing localization settings
     *
     */
    public function addAdminScriptLocalization(string $handle, string $src = '', array $deps = [], ?string $ver = null, bool $inFooter = false, $ajaxObject = 'ajax_admin', $localisationArray = []): Admin
    {
        $this->actionEnqueueAdminScripts(function () use ($handle, $src, $deps, $ver, $inFooter, $ajaxObject, $localisationArray) {
            wp_register_script($handle, $src, $deps, $ver, $inFooter);
            wp_localize_script($handle, $ajaxObject, $localisationArray);
            wp_enqueue_script($handle);

        });
        return $this;
    }

    /**
     * @param string $handle
     * @param string $src
     * @param array $deps
     * @param string|null $ver
     * @param false $inFooter
     * @return $this
     */
    public function addAcfAdminScript(string $handle, string $src = '', array $deps = [], ?string $ver = null, bool $inFooter = false): Admin
    {
        $this->actionAcfEnqueueAdminScripts(function () use ($handle, $src, $deps, $ver, $inFooter) {
            wp_register_script($handle, $src, $deps, $ver, $inFooter);
            wp_enqueue_script($handle);
        });
        return $this;
    }

    /**
     * @param string $handle
     * @param string $src
     * @param array $deps
     * @param string|null $ver
     * @param false $inFooter
     */
    public function addAcfAdminScriptFooter(string $handle, string $src = '', array $deps = [], ?string $ver = null, bool $inFooter = false): Admin
    {
        $this->actionAcfEnqueueAdminFooter(function () use ($handle, $src, $deps, $ver, $inFooter) {
            wp_register_script($handle, $src, $deps, $ver, $inFooter);
            wp_enqueue_script($handle);
        });
        return $this;
    }

    /**
     * @param string $handle
     * @param string $src
     * @param array $deps
     * @param string|null $ver
     * @param false $inFooter
     */
    public function addAcfAdminScriptHeader(string $handle, string $src = '', array $deps = [], ?string $ver = null, bool $inFooter = false): Admin
    {
        $this->actionAcfEnqueueAdminHeader(function () use ($handle, $src, $deps, $ver, $inFooter) {
            wp_register_script($handle, $src, $deps, $ver, $inFooter);
            wp_enqueue_script($handle);
        });
        return $this;
    }

    /**
     * Enqueue script on front end
     * @param $function
     */
    private function actionEnqueueAdminScripts($function): void
    {
        add_action('admin_enqueue_scripts', function () use ($function) {
            $function();
        });
    }

    /**
     * Enqueue script on front end
     * @param $function
     */
    public function actionAcfEnqueueAdminFooter($function): void
    {
        add_action('acf/input/admin_footer', function () use ($function) {
            $function();
        });
    }

    /**
     * Enqueue script on front end
     * @param $function
     */
    public function actionAcfEnqueueAdminHeader($function): void
    {
        add_action('acf/input/admin_head', function () use ($function) {
            $function();
        });
    }

    /**
     * Enqueue script on front end
     * @param $function
     */
    private function actionAcfEnqueueAdminScripts($function): void
    {
        add_action('acf/input/admin_enqueue_scripts', function () use ($function) {
            $function();
        });
    }

    /**
     * @param $function
     */
    private function actionAdminInit($function)
    {
        add_action('admin_init', function () use ($function) {
            $function();
        });
    }

    /**
     * @param $feature
     * @return $this
     */
    public function addEditorStyles($feature): Admin
    {
        $this->actionAdminInit(function () use ($feature) {
            add_editor_style($feature);
        });

        return $this;
    }
}
