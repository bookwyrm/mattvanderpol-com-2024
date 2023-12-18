<?php

namespace TailCraft\Theme\Partial;

class Image {
    protected $height = null;
    protected $width = null;
    protected $size_loaded = false;
    protected $attachment_id = null;
    protected $size_ratio = 1;
    protected $url = null;
    protected $classes = '';
    protected $attrs = [];

    public function __construct(
        int $attachment_id, 
        int $size_ratio = 1, 
        $classes = '', 
        array $attrs = []
    ) {
        $this->attachment_id = $attachment_id;
        $this->size_ratio = is_null($size_ratio) ? 1 : $size_ratio;
        if ( is_array($classes) ) {
            $classes = implode(' ', $classes);
        }
        $this->classes = $classes;
        $this->attrs = $attrs;
    }

    public static function fromFeatured(
        int $post_id,
        ?int $fallback_attachment_id = null,
        $size_ratio = 1,
        $classes = ''
    ) {
        if ( $attachment_id = get_post_thumbnail_id($post_id) ) {
            return new static($attachment_id, $size_ratio, $classes);
        }

        if ( !is_null($fallback_attachment_id) ) {
            return new static($fallback_attachment_id, $size_ratio, $classes);
        }

        return new NullImage();
    }

    protected function loadSize() {
        if ( $this->size_loaded ) { return true; }

        $image_data = wp_get_attachment_image_src($this->attachment_id, 'full');
        if ( is_array($image_data) ) {
            $this->url = $image_data[0];
            $this->width = $image_data[1];
            $this->height = $image_data[2];
            $this->size_loaded = true;
        }

        return $this->size_loaded;
    }

    public function height() {
        if ( $this->loadSize() ) {
            return $this->height;
        }
    }

    public function width() {
        if ( $this->loadSize() ) {
            return $this->width;
        }
    }

    protected function getAspectRatioClass() {
        if ( $this->loadSize() ) {
            $aspect_ratio = $this->width / $this->height;
            if ($aspect_ratio > 0.9 && $aspect_ratio < 1.1) {
                return 'ar-square';
            }
            if ( $aspect_ratio < 0.9 ) {
                return 'ar-portrait';
            }
            if ( $aspect_ratio > 2.5 ) {
                return 'ar-landscape--wide';
            }
            return 'ar-landscape';
        }
        return '';
    }

    protected function maybeChangeSize() {
        if ( $this->size_ratio == 1 || $this->size_ratio == 0 ) { return; }

        $that = $this;
        $filter_fn = function($html) use (&$filter_fn, $that) {
            remove_filter('wp_get_attachment_image', $filter_fn);
            $scaled_width = $that->size_ratio * $that->width();
            $scaled_height = $that->size_ratio * $that->height();
            return preg_replace(
                [ '/width=".*?"\s*/', '/height=".*?"\s*/' ],
                [
                    sprintf('width="%d"', $scaled_width),
                    sprintf('height="%d"', $scaled_height),
                ],
                $html
            );
        };
        add_filter('wp_get_attachment_image', $filter_fn);
    }

    protected function maybesetSizeRatio() {
        if ( $this->size_ratio != 1 ) { return; }

        $this->loadSize();
        $filename = basename($this->url);
        if ( strpos($filename, '@4x') ) {
            $this->size_ratio = 0.25;
        } else if ( strpos($filename, '@3x') ) {
            $this->size_ratio = 0.333;
        } else if ( strpos($filename, '@2x') ) {
            $this->size_ratio = 0.5;
        }
    }

    public function __toString() {
        $classes = $this->classes . ' ' . $this->getAspectRatioClass();
        $attrs = array_merge($this->attrs, [ 'class' => $classes ]);

        $this->maybeSetSizeRatio();
        $this->maybeChangeSize();
        return wp_get_attachment_image($this->attachment_id, 'full', false, $attrs);
    }

    public function render($classes = '') {
        if ( !empty($classes) ) {
            $this->classes .= ' ' . $classes;
        }
        echo $this;
    }
}

