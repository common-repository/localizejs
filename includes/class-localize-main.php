<?php
if ( !class_exists('Localize_Main')) {
    class Localize_Main
    {
        protected array $langs;
        protected Localize_Settings $localize_Settings;

        public function __construct($langs = [])
        {
            $this->langs = $langs;
            $this->localize_Settings = new Localize_Settings();
        }

        public function detectLanguage()
        {
            if ($this->localize_Settings->get_permalink_plain_set()) {
                return $_GET['lang'] ?? null;
            }
            return $this->findLanguageInUrl(get_permalink());
        }

        public function addLanguageToLinks($html, $args) {
            preg_match('/<a\s+(?:[^>]*?\s+)?href=(["\'])(.*?)\\1/', $html, $url);

            $wp_host = parse_url(get_home_url(), PHP_URL_HOST);
            $link_host = parse_url($url[2], PHP_URL_HOST);
            if ($wp_host !== $link_host) {
                return $html;
            }

            $link_lang = $this->localize_Settings->get_permalink_plain_set()
                ? $this->findLanguageInQuery($url[2])
                : $this->findLanguageInUrl($url[2]);

            if ($link_lang) {
                // this link already has a language tag
                return $html;
            }

            if ($this->localize_Settings->get_permalink_plain_set()) {
                // home url will have lang=xx if the chosen language is not the source
                $wp_lang = $this->findLanguageInQuery(get_home_url());
                if ($wp_lang) {
                    // if a language was found add it to this query.
                    return $this->addLanguageToUrlQuery($html, $url[2], $wp_lang);
                }
                return $html;
            }
            $wp_lang = parse_url(get_home_url(), PHP_URL_PATH);

            return $this->addLanguageToLink($html, $wp_host, $wp_lang);

        }

        /**
         * @param $html - the full html of the link
         * @param $url - must be href inside $html and is assumed to not have lang
         * @param $lang
         * @return string
         */
        private function addLanguageToUrlQuery($html, $url, $lang) {
            // check to see if there actually is a query on the url.
            $separator = parse_url($url, PHP_URL_QUERY) ? '&' : '?';
            return str_replace($url, "$url${separator}lang=$lang", $html);
        }

        /**
         * @param $html - the full html of the link
         * @param $wp_host
         * @param $wp_lang
         * @return string
         */
        private function addLanguageToLink($html, $wp_host, $wp_lang) {
            // home url will have language in it, so we replace the host name with the home url
            return str_replace($wp_host , "$wp_host$wp_lang", $html);
        }

        private function findLanguageInUrl($url) {
            preg_match('/\/(.*?)\//', parse_url($url, PHP_URL_PATH), $link);
            if (count($link) < 1) {
                return '';
            }
            if (array_search($link[1], $this->langs) !== false) {
                return $link[1];
            }
        }

        private function findLanguageInQuery($url) {
            // WP will sometimes add #038; before the ampersand which can throw off the parse_url command
            $query = parse_url(str_replace('#038;', '', $url), PHP_URL_QUERY);

            if (!$query) {
                return null;
            }

            parse_str($query, $queryArray);

            return $queryArray['lang'] ?? null;

        }
    }
}