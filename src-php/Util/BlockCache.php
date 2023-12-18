<?php

namespace TailCraft\Theme\Util;

class BlockCache {
  protected static $cache = [];

  public static function blocksForPost(int $post_id) {
    $key = sprintf('post_%d', $post_id);
    if ( !isset(static::$cache[$key]) ) {
      $post = get_post($post_id);
      static::$cache[$key] = new BlockStruct( parse_blocks($post->post_content) );
    }

    return static::$cache[$key];
  }
}

