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
final class Bem implements BemInterface, BemGlobalInterface {

  use BemTrait;

  /**
   * @var string
   */
  private $block;

  /**
   * BEM constructor.
   *
   * @param string $block
   *   The base to use for the BEM block.
   */
  public function __construct(string $block) {
    $this->block = $block;
  }

  /**
   * {@inheritdoc}
   */
  public function getBemBlock(): string {
    return $this->block;
  }

  /**
   * {@inheritdoc}
   */
  public function getBemGlobalBlock(): string {
    return 'bem';
  }

  public function getBemStyle(): StyleInterface {
    return new Official();
  }

}
