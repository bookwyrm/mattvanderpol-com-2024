<?php

namespace TailCraft\Theme\PostType;

use \PostTypes\PostType;

class CodeReference {
  protected static $is_setup = false;

  public static $name = 'code_reference';
  public static $singular = 'Code Reference';
  public static $plural = 'Code References';
  public static $slug = 'code-references';

  public static function setup() : void {
    if ( static::$is_setup ) { return; }

    static::setupPostType();
    static::setupHooks();

    static::$is_setup = true;
  }

  protected static function setupPostType() : void {
    $code_cpt = new PostType([
      'name' => static::$name,
      'singular' => static::$singular,
      'plural' => static::$plural,
    ]);

    $code_cpt->options([
      'supports' => [
        'title', 'editor', 'author', 'revisions', 'excerpt',
      ],
      'rewrite' => [
        'slug' => static::$slug,
        'with_front' => false,
      ],
      'has_archive' => false,
      'show_in_rest' => true, // For Block editor support
    ]);

    $code_cpt->taxonomy( 'post_tag' );
    $code_cpt->icon('dashicons-editor-code');

    $code_cpt->register();
  }


  protected static function setupHooks() {
    \add_filter('nav_menu_css_class', [ static::class, 'cleanNavItemClasses' ], 10, 2);
  }

  public static function cleanNavItemClasses($classes, $menu_item) {
    if ( \get_post_type() !== static::$name ) { return $classes; }

    $path = parse_url($menu_item->url, PHP_URL_PATH);
    if ( $path === sprintf('/%s/', static::$slug) ) {
      $classes[]= 'current_page_parent';
    } else {
      if ( in_array('current_page_parent', $classes) ) {
        $classes = array_filter($classes, fn($_) => $_ !== 'current_page_parent');
      }
    }
    return $classes;
  }
}

