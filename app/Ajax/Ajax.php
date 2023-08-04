<?php

namespace Genesis\Ajax;

/**
 * Class will hold all ajax logic
 */
class Ajax
{

    /**
     * Init class
     */
    public function init()
    {
        // add_action('wp_ajax_actionHandler', [$this, 'actionHandler']);
        // add_action('wp_ajax_nopriv_actionHandler', [$this, 'actionHandler']);
    }

    /**
     * Checks ajax request by checking the nonce, referrer and action
     *
     * @param  string $nonceAction               Nonce action
     * @param  string $nonceKey                  Nonce key
     * @param  string $jsAction                  Javascript action
     */
    private function checkAjaxRequest(string $nonceAction, string $nonceKey, string $jsAction):  bool
    {

        // Check referer
        if (!check_ajax_referer($nonceAction, $nonceKey, false)) {
            return false;
        }

        // check action
        if (!isset($_POST['action']) || $jsAction != $_POST['action']) {
            return false;
        }

        // return
        return true;
    }

    /**
     * Get posts by post type if there is a relationship field type request from ajax
     *
     * @return [type] [description]
     */
    public function actionHandler()
    {
        // verify ajax request
        if (!$this->checkAjaxRequest('ajax_admin', 'security', 'actionHandler')) {
            wp_send_json_error();
        }

        // custom stuff here


        // create return data
        $results = [
            'results' => '',
        ];

        // send back stuff
        wp_send_json($results);
    }
}
