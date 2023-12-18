<?php

namespace TailCraft\Theme\Util;

use TailCraft\Theme\BlockOverrides\BlockOverridesBase;
use TailCraft\Theme\Blocks\BlockBase;

class BlockNode {
  protected $parent;
  protected $source;
  protected $id = '';
  protected $type = '';
  protected $children = [];

  public function __construct(
    array $block,
    BlockStruct $struct,
    ?BlockNode $parent = null
  ) {
    $this->source = $block;
    $this->type = $block['blockName'] ?? '';
    $this->id = $this->idForBlock($block);

    $this->parent = $parent;
    $struct->addLookup($this->id, $this);
    $this->parseInnerBlocks($struct);
  }

  protected function idForBlock($block) {
    $name = $block['blockName'] ?? '';
    if ( 
        strpos($name, 'acf/') === 0 
        || strpos($name, 'tailcraft/') === 0
    ) {
      return BlockBase::generateId($block);
    }

    if ( strpos($name, 'core/') === 0 ) {
      return BlockOverridesBase::generateId($block);
    }

    return '';
  }

  public function getAttr($name, $default = '') {
    return !empty($this->source['attrs'][$name])
      ? $this->source['attrs'][$name]
      : $default
    ;
  }

  public function getData($name, $default = '') {
    $data = $this->getAttr('data', []);
    return !empty($data[$name]) ? $data[$name] : $default;
  }

  protected function parseInnerBlocks($struct) {
    if ( !is_array($this->source['innerBlocks']) ) { return; }

    foreach ( $this->source['innerBlocks'] as $inner_block ) {
      $this->children[]= new BlockNode(
        $inner_block,
        $struct,
        $this
      );
    }
  }

  public function getBlockSource() {
    return $this->source;
  }

  public function getParent() {
    return $this->parent;
  }

  public function getChildren() {
    return $this->children;
  }

  public function getSiblings() {
    $siblings_and_self = $this->parent->getChildren();
    return array_filter(
      $siblings_and_self,
      function($node) { return $node !== $this; }
    );
  }

  public function getPrevSiblings() {
    $siblings_and_self = $this->parent->getChildren();
    $prev_siblings = [];
    foreach ( $siblings_and_self as $node ) {
      if ( $node === $this ) { break; }
      $prev_siblings[]= $node;
    }

    return $prev_siblings;
  }

  public function getNextSiblings() {
    $siblings_and_self = array_reverse($this->parent->getChildren());
    $next_siblings = [];
    foreach ( $siblings_and_self as $node ) {
      if ( $node === $this ) { break; }
      $next_siblings[]= $node;
    }

    return array_reverse($next_siblings);
  }

  public function hasChildOfType($type) {
    foreach ( $this->children as $child ) {
      if ( $child->type === $type ) {
        return true;
      }
    }

    return false;
  }

  public function hasDescendentOfType($type) {
    foreach ( $this->children as $child ) {
      if ( $child->type === $type ) {
        return true;
      }

      if ( $child->hasDescendentOfType($type) ) {
        return true;
      }
    }

    return false;
  }

  public function hasAncestorBlockOfType($type) : bool {
    return is_a($this->findAncestorBlockOfType($type), static::class);
  }

  public function hasParentOfType($type) : bool {
    if ( !is_a($this->parent, static::class) ) {
      return false;
    }

    return $this->parent->type === $type;
  }

  public function findAncestorBlockOfType($type) {
    if ( $this->type === $type ) {
      return $this;
    }

    if ( !is_a($this->parent, static::class) ) {
      return;
    }

    return $this->parent->findAncestorBlockOfType($type);
  }
}

