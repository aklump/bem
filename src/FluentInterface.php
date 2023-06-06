<?php

namespace AKlump\Bem;

use AKlump\Bem\Styles\StyleInterface;

interface FluentInterface {

  public function setStyle(Styles\StyleInterface $style): void;

  public function getStyle(): StyleInterface;

  public function setGlobalBlock(string $global_block): void;

  public function setBlock(string $block): void;

  /**
   * Being a new chain for a BEM block.
   *
   * @return $this
   *
   * @throws \RuntimeException When making an invalid chain.
   */
  public function block(): ChainedInterface;

  /**
   * Begin a new chain for a BEM element.
   *
   * @param string $element
   *
   * @return $this
   *
   * @throws \RuntimeException When making an invalid chain.
   */
  public function element(string $element_stub): ChainedInterface;

  public function toArray(): array;
}
