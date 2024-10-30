<?php

if ( !class_exists('Localize_settings')) {
    class Localize_Settings
    {
        public function get_permalink_plain_set()
        {
            return get_option('permalink_structure') == "";
        }
    }
}