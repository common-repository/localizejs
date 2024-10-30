<?php
/**
 * Plugin Name: Localize Integration
 * Plugin URI: http://wordpress.org/plugins/localizejs/
 * Description: Easily integrate Localize into your WordPress site.
 * Author: Localize
 * Version: 1.3.1
 * Author URI: https://localizejs.com
 */

/*  Copyright 2022 Localize (support@localizejs.com)

        Original version: 2015 by Jonathan Wu

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/**
 * Exit if absolute path
*/
if ( ! defined( 'ABSPATH' ) ) exit;

// imports
require(plugin_dir_path(__FILE__) . 'includes/class-localize-admin.php');
require(plugin_dir_path(__FILE__) . 'includes/class-localize-api.php');
require(plugin_dir_path(__FILE__) . 'includes/class-localize-main.php');
require(plugin_dir_path(__FILE__) . 'includes/class-localize-settings.php');


// Initialize Localize
add_action('init','init_function');


function init_function() {
    $localize_admin = new Localize_Admin();
    add_action( 'wp_enqueue_scripts', 'add_localizejs_script', 1);
    add_action( 'admin_menu', [$localize_admin, 'localize_plugin_menu']);
    add_action( 'admin_init', 'localize_plugin_settings');

};


function localize_settings_validate($input) {

    $message = __('Your settings are saved.');
    $type = 'updated';
    add_settings_error('localize_option_notice', 'localize_option_notice', $message, $type);
    return $input;
    
}

// SET LOCALIZE SCRIPT
function add_localizejs_script() {
    wp_deregister_script( 'localize' );
    wp_deregister_script( 'localizeFallback' );

    $project_key = get_option( 'project_key' );
    $localizejs_settings_url_options = get_option( 'localizejs_settings_url_options' );

    wp_register_script('localize', ( '//global.localizecdn.com/localize.js' ), false, null, false);
    wp_register_script('localizeFallback', plugins_url('/localizejs.js',__FILE__) , false, null, false);

    wp_enqueue_script( 'localize' );
    wp_enqueue_script( 'localizeFallback' );

    wp_localize_script( 'localizeFallback', 'PROJECT_KEY', $project_key);
    wp_localize_script( 'localizeFallback', 'URL_OPTIONS', $localizejs_settings_url_options);
    wp_localize_script( 'localizeFallback', 'ALLOW_INLINE_BREAK_TAGS', get_option('localizejs_settings_allow_inline_break_tags'));
    wp_localize_script( 'localizeFallback', 'AUTO_APPROVE', get_option('localizejs_settings_auto_approve'));
    wp_localize_script( 'localizeFallback', 'RETRANSLATE_ON_NEW_PHRASES', get_option('localizejs_settings_retranslate_on_new_phrases'));

    if ($localizejs_settings_url_options > 0 && $localizejs_settings_url_options <= 2) {
        init_languages();

        $langs = (defined('AVAILABLE_LANGUAGES')) ? json_decode(AVAILABLE_LANGUAGES) : [];

        $localize = new Localize_Main($langs);
        $localize_settings = new Localize_Settings();
        if ($localizejs_settings_url_options == 1) {
            $lang = $localize->detectLanguage() ?? SOURCE_LANGUAGE;
        }
        if ($lang) {
            wp_add_inline_script('localizeFallback', "const OVERRIDE_LANG = '${lang}'", 'before');
        }

        add_filter( 'walker_nav_menu_start_el', [$localize, 'addLanguageToLinks'], 10, 2);

        wp_localize_script( 'localizeFallback', 'AVAILABLE_LANGUAGES', $langs);
        wp_localize_script( 'localizeFallback', 'SOURCE_LANGUAGE', (defined('SOURCE_LANGUAGE')) ? SOURCE_LANGUAGE : NULL);
        wp_localize_script( 'localizeFallback', 'localize_conf', ['permalink_plain'=>$localize_settings->get_permalink_plain_set()]);
    } else {
        wp_localize_script( 'localizeFallback', 'AVAILABLE_LANGUAGES', []);
        wp_localize_script( 'localizeFallback', 'SOURCE_LANGUAGE', NULL);
    }
			


}

// SET PROJECT KEY
function localize_plugin_settings() {
    register_setting( 'localize-settings-group', 'project_key' ,'localize_settings_validate');
    register_setting( 'localize-settings-group', 'localizejs_settings_url_options');
    register_setting( 'localize-settings-group', 'localizejs_settings_auto_approve', ['type' => 'boolean']);
    register_setting( 'localize-settings-group', 'localizejs_settings_allow_inline_break_tags', ['type' => 'boolean']);
    register_setting( 'localize-settings-group', 'localizejs_settings_retranslate_on_new_phrases', ['type' => 'boolean']);
}

function init_languages(){
    if (!defined('AVAILABLE_LANGUAGES')) {
        //call to get the source and target Languages through the API
        $localize_api = new Localize_API();
        $resultObj = $localize_api->getAvailableLangs();
        $available_languages = $resultObj === null ? '[]' : json_encode($resultObj->el);
        define('AVAILABLE_LANGUAGES', $available_languages);
        define('SOURCE_LANGUAGE', $resultObj === null ? 'en' : $resultObj->source);
    } 
}

function replace_siteurl($url) {
    
    $url_collection = json_decode(AVAILABLE_LANGUAGES);
    
    $url_array = explode('/', $_SERVER['REQUEST_URI']);
    
    $request_lang = $url_array[1];
    
    if (in_array($request_lang, $url_collection) && ($request_lang != SOURCE_LANGUAGE)) {
        return $url."/".$request_lang;
    } else {
        return $url;
    }
}

function replace_siteurl_subdomain($url) {
    
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    
    $url_collection = json_decode(AVAILABLE_LANGUAGES);
    
    $domainArr = explode('.', $domainName);

    if (in_array($domainArr[0], $url_collection)) {
        
        if ($domainArr[0] == SOURCE_LANGUAGE) {
            $domainName = implode(".",array_shift($domainArr));
            return $protocol.$domainName;
        } else {
            return  $protocol.$domainName;
        }
        
    }
    return  $protocol.$domainName;
    
}



function wp_append_query_string( $url, $id ) {

    $url_collection = json_decode(AVAILABLE_LANGUAGES);
    $request_lang = $_GET['lang'] ?? 'en';

    if (isset($request_lang) && $request_lang != SOURCE_LANGUAGE && in_array($request_lang, $url_collection)) {
        return add_query_arg( 'lang', $request_lang , $url );
    }
    return $url;
}


function unparse_url( $parsed_url , $ommit = array( ) )
{
    
    $url           = '';
    
    $p             = array();
    
    $p['scheme']   = isset( $parsed_url['scheme'] ) ? $parsed_url['scheme'] . '://' : ''; 
    
    $p['host']     = isset( $parsed_url['host'] ) ? $parsed_url['host'] : ''; 
    
    $p['port']     = isset( $parsed_url['port'] ) ? ':' . $parsed_url['port'] : ''; 
    
    $p['user']     = isset( $parsed_url['user'] ) ? $parsed_url['user'] : ''; 
    
    $p['pass']     = isset( $parsed_url['pass'] ) ? ':' . $parsed_url['pass']  : ''; 
    
    $p['pass']     = ( $p['user'] || $p['pass'] ) ? $p['pass']."@" : ''; 
    
    $p['path']     = isset( $parsed_url['path'] ) ? $parsed_url['path'] : ''; 
    
    $p['query']    = isset( $parsed_url['query'] ) ? '?' . $parsed_url['query'] : ''; 
    
    $p['fragment'] = isset( $parsed_url['fragment'] ) ? '#' . $parsed_url['fragment'] : '';
    
    if ( $ommit )
    {
        foreach ( $ommit as $key )
        {
            if ( isset( $p[ $key ] ) )
            {
                $p[ $key ] = '';    
            }
        }
    }
      
    return $p['scheme'].$p['user'].$p['pass'].$p['host'].$p['port'].$p['path'].$p['query'].$p['fragment']; 
}

function get_language_from_browser_url() {
    $localize_settings = new Localize_Settings();
    $url_collection = json_decode(AVAILABLE_LANGUAGES);

    if($localize_settings->get_permalink_plain_set()){
        $request_lang = $_GET['lang'];
    } else {
    
        $url_array = explode('/', $_SERVER['REQUEST_URI']);

        $request_lang = $url_array[1];
    }

    if (in_array($request_lang, $url_collection) && ($request_lang != SOURCE_LANGUAGE)) {
        return $request_lang;

    } else {
        return "";

    }
}

function check_query_string_exists($url_query_str) {
    $url_query_str_arr = explode("=",$url_query_str);
    if (count($url_query_str_arr) > 0) {
        if ($url_query_str_arr[0] == "lang") {
            return true;
        } else {
            return false;
        }
    }
}

function query_string_update_lang($url_query) {
    
    $url_query_arr = explode("&",html_entity_decode($url_query));

    if(strpos($url_query, "lang=") !== false){

        $final_query_string = array();
        foreach ($url_query_arr as &$url_query_str) {

            if (check_query_string_exists($url_query_str)) {

                $lang = get_language_from_browser_url();
                if (!empty($lang)) {
                    $final_query_string[] = "lang=".$lang;
                }
            } else { 
                $final_query_string[] = $url_query_str;
            }
        }

    } else {
        $final_query_string[] = get_language_from_browser_url();
    }
    return implode("&",$final_query_string);
}


function add_language_to_abs_url_path($components = array()) {

    $url_str = $components['path'];
    $localize_settings = new Localize_Settings();
    
    if (!$localize_settings->get_permalink_plain_set()) {
        
        add_language_to_url_path($url_str);
        
    } else {

        $url_query = $components['query'];

        $query_str_resp = query_string_update_lang($url_query);
        $components['query'] = $query_str_resp;
    }
    return unparse_url($components);
    
}


function add_language_to_url_path($url_str) {
    $localize_settings = new Localize_Settings();
    if (!$localize_settings->get_permalink_plain_set()) {
        if ($url_str[0] == "/") {
            $url = substr($url_str, 1);
            $removedSlash=true;
        }
        $url_arr = explode("/",$url);   

        if (count($url_arr) > 0) {
            $lng = $url_arr[0];

            $request_lang = get_language_from_browser_url();

            if (!empty($request_lang)) {
                if ($lng == $request_lang) {
                    return $url_str;
                } else {
                    return (($removedSlash)?"/".$request_lang:"")."/".$url;
                }

            } else {
                return $url_str;

            }
        }
    } 
    return $url;
}

function wp_append_query($string) {
    $regexp = "<a\s[^>]*href=(\"??)([^#\"][^\" >]*?)\1[^>]*>(.*)<\/a>";
    preg_match_all("/$regexp/siU", $string, $matchArray);
    
    foreach (array_unique($matchArray[2]) as $match){
        $components = parse_url($match);

        if (!empty($components['host']) ) {
            //handle for absolute path
            $retlink = add_language_to_abs_url_path($components);
        } else {
            //handle for relative path
            $retlink = add_language_to_url_path($match);
        }
        
        $string = str_replace($match, $retlink, $string); 
        
    }
    return $string;
}

function wp_permalink_plain() {

    add_filter( 'page_link', 'wp_append_query_string', 10, 2 );
    add_filter( 'post_link', 'wp_append_query_string', 10, 2 );
    add_filter( 'term_link','wp_append_query_string', 10, 2 );
    add_filter( 'post_type_archive_link', 'wp_append_query_string', 10, 2 );
    add_filter( 'day_link', 'wp_append_query_string', 10, 2 );
    add_filter( 'month_link', 'wp_append_query_string', 10, 2 );
    add_filter( 'year_link', 'wp_append_query_string', 10, 2 );
    add_filter( 'home_url', 'wp_append_query_string', 10, 2  );
}

function localizejs_get_settings()  {
    $localize_settings = new Localize_Settings();
    $url_options = get_option( 'localizejs_settings_url_options' );
    if ($url_options == 0) {
        // do nothing
    }
    else if ($url_options == 1) {
        init_languages();
        add_filter( 'the_content', 'wp_append_query', 10, 3 );
        if ($localize_settings->get_permalink_plain_set()) {
            wp_permalink_plain();
        } else {
            add_filter('option_home', 'replace_siteurl');
        }
    }
    else if ($url_options == 2) {
        init_languages();
        add_filter( 'the_content', 'wp_append_query', 10, 3 );
        if ($localize_settings->get_permalink_plain_set()) {
            wp_permalink_plain();
        }
        add_filter('option_home', 'replace_siteurl_subdomain');
        
    }

}

add_action('init','localizejs_get_settings',1);
