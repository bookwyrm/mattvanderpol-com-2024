<?php

namespace TailCraft\Theme\ViewModel;

class Url {
    protected $url = '';
    protected static $wp_hostname = null;

    public function __construct(string $url) {
        $this->url = $url;
    }

    public function __toString()
    {
        return $this->url;
    }

    protected static function wpHostname() {
        if ( is_null(self::$wp_hostname) ) {
            self::$wp_hostname = wp_parse_url(home_url(), PHP_URL_HOST);
        }

        return self::$wp_hostname;
    }

    protected function strip() {
        return preg_replace(
            '@[^\w\/\-]+@',
            '',
            strtolower($this->url)
        );
    }

    public function asKey($suffix) {
        return esc_attr($this->strip() . '_' . $suffix);
    }

    public function isOffsite() {
        $url_host = wp_parse_url($this->url, PHP_URL_HOST);
        return $url_host !== self::wpHostname();
    }
}
