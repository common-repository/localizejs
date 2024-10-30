<?php
if ( !class_exists('Localize_API')) {

    class Localize_API
    {
        function getAvailableLangs()
        {

            $project_key = get_option('project_key');

            $args = ['headers' => ['Content-Type: application/json']];
            $url = "https://global.localizecdn.com";

            $response = wp_remote_get($url . "/api/lib/" . $project_key . "/t?v=000&requestor=wp", $args);
            return json_decode(wp_remote_retrieve_body($response));
        }
    }
}