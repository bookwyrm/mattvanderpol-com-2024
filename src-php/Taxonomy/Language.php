<?php

namespace TailCraft\Theme\Taxonomy;

use PostTypes\Taxonomy;
use TailCraft\Theme\PostType\CodeReference;

class Language {
  protected static $is_setup = false;
  public static $name = 'language';
  public static $singular = 'Language';
  public static $plural = 'Languages';
  public static $slug = 'language';


  public static function setup() : void {
    if ( static::$is_setup ) { return; }

    static::setupTaxonomy();
    static::setupHooks();

    static::$is_setup = true;
  }

  protected static function setupTaxonomy() : void {
    $tax = new Taxonomy([
      'name' => static::$name,
      'singular' => static::$singular,
      'plural' => static::$plural,
      'slug' => static::$slug,
    ]);

    $tax->posttype( CodeReference::$name );

    $tax->register();
  }

  protected static function setupHooks() {
    add_filter('post_class_taxonomies', [static::class, 'postClassTaxonomies']);
  }

  public static function postClassTaxonomies(
    array $taxonomies
  ) : array {
    if ( isset($taxonomies[static::$name]) ) { 
      unset($taxonomies[static::$name]);
    }
    return $taxonomies;
  }
}

