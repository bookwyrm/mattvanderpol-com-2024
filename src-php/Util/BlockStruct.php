<?php

namespace TailCraft\Theme\Util;

class BlockStruct {
  protected $blocks;
  protected $block_lookup = [];
  protected $root;

  public function __construct($blocks) {
    $this->blocks = $blocks;
    $root_block = [
      'attrs' => [
        'id' => 'root',
      ],
      'innerBlocks' => $blocks,
    ];
    $this->root = new BlockNode($root_block, $this);
  }

  public function addLookup(string $block_id, BlockNode $node) {
    $this->block_lookup[$block_id] = $node;
  }

  public function findBlockNode(string $block_id) {
    if ( !empty($this->block_lookup[$block_id]) ) {
      return $this->block_lookup[$block_id];
    }

    return null;
  }

  public function findBlockNodeByInnerHtml(string $inner_html) {
    $key = md5($inner_html);
    return $this->findBlockNode($key);
  }
}
