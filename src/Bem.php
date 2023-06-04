<?php

namespace AKlump\Bem;

/**
 * Provides BEM style classnames.
 */
final class Bem implements BemInterface {

  const GLOBAL = 'component';

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
  public function bemBlock(): string {
    return $this->block;
  }

  /**
   * {@inheritdoc}
   */
  public function bemElementWithGlobal(string $element, bool $include_js = FALSE, bool $clean = TRUE): string {
    $global = new self(Bem::GLOBAL);

    return implode(' ', [
      $this->bemElement($element, $include_js, $clean),
      $global->bemElement($element, $include_js, $clean),
    ]);
  }

}
