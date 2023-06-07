<?php

namespace AKlump\Bem;

use AKlump\Bem\styles\StyleInterface;
use AKlump\Bem\Styles\Official;

/**
 * Provides BEM methods using the official style.
 *
 * To change the global or the style, create a new class with appropriate
 * interfaces.
 */
final class Bem implements BemInterface {

  use BemTrait;

  /**
   * BEM constructor.
   *
   * @param string $block
   *   The base to use for the BEM block.
   */
  public function __construct(string $block, string $global_block = BemInterface::GLOBAL_BLOCK) {
    $this->bemSetBlock($block);
    $this->bemGlobalSetBlock($global_block);
  }

}
