<?php

namespace TailCraft\Theme\Util;

class ParamList {
    protected $params = [];

    public function __construct() {
    }

    public function add($params) {
        $this->params = array_merge($this->params, $params);
    }

    public function set($key, $value) {
        $this->params[$key] = $value;
    }

    public function __toString() {
        return implode('&', array_map(
            function($k, $v) {
                return sprintf(
                    '%s=%s',
                    \esc_attr($k),
                    \esc_attr($v)
                );
            },
            array_keys($this->params),
            array_values($this->params)
        ) );
    }
}
