<?php

namespace TailCraft\Theme;

class Init {
    public static function run() : void {
        $instance = new static;
        $instance->setupHooks();
        new Customizer();
    }

    protected function setupHooks() {
        \add_action('init', [$this, 'disableEmoji']);
        \add_filter('upload_mimes', [ $this, 'allowJsonUpload' ]);
        \add_action('wp_enqueue_scripts', [ $this, 'enqueueAssets' ]);
        \add_action('after_setup_theme', [ $this, 'setupTheme' ]);
        \add_action('widgets_init', [ $this, 'setupWidgets' ]);
    }

    public function allowJsonUpload($mimes) {
        $mimes['json'] = 'text/plain';
        return $mimes;
    }

    public function enqueueAssets() : void {
        $css = new Asset('css/styles.css');
        /* $js = new Asset('js/app.js'); */
        \wp_enqueue_style('tailcraft', $css->url(), [], $css->version());
        /* \wp_enqueue_script('tailcraft', $js->url(), [], $js->version()); */
    }

    public function setupWidgets() : void {
        register_sidebar(
            [
                'name' => esc_html__('Footer', 'tailcraft'),
                'id' => 'footer',
                'description' => esc_html__('Footer Widgets', 'tailcraft'),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
            ]
        );
    }

    public function setupTheme() : void {
        \add_theme_support( 'title-tag' );
        \add_theme_support( 'post-formats', [ 'aside', 'image', 'video', 'quote', 'link' ] );

        register_nav_menus(
            array(
                'toolbar'      => __( 'Toolbar Menu', 'tailpress' ),
                'primary'      => __( 'Primary Menu', 'tailpress' ),
                'footer'       => __( 'Footer Menu', 'tailpress' ),
                'footer_legal' => __( 'Footer Legal Menu', 'tailpress' ),
            )
        );

        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            )
        );

        add_theme_support( 'custom-logo' );
        add_theme_support( 'post-thumbnails' );

        add_theme_support( 'align-wide' );
        add_theme_support( 'wp-block-styles' );

        add_theme_support( 'editor-styles' );
        $style_css = new Asset('css/editor-style.css');
        add_editor_style( $style_css->localPath() );

        add_image_size('focus', 346, 346);
        add_image_size('image-carousel', 400, 400, true);
    }

    public function disableEmoji() {
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
        add_filter( 'tiny_mce_plugins', function($plugins) {
            if ( is_array( $plugins ) ) {
                return array_diff( $plugins, array( 'wpemoji' ) );
            } else {
                return array();
            }
        });
    }
}


