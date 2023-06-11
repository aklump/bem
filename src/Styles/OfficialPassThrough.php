<?php

namespace AKlump\Bem\Styles;

/**
 * Official join strings with whitespace-only normalization.
 */
final class OfficialPassThrough implements StyleInterface {

  public function element(): string {
    return '__';
  }

  public function modifier(): string {
    return '--';
  }

  public function javascript(): string {
    return 'js-';
  }

  /**
   * Block
   *
   * @param string $block
   *
   * @return string
   */
  public function normalizeBlock(string $value): string {
    return trim($value);
  }

  /**
   * Element names may consist of Latin letters, digits, dashes.
   *
   * @param string $element
   *
   * @return string
   */
  public function normalizeElementStub(string $value): string {
    return trim($value);
  }

  /**
   * Modifier names may consist of Latin letters, digits, dashes.
   *
   * @param string $modifier
   *
   * @return string
   */
  public function normalizeModifierStub(string $value): string {
    return trim($value);
  }

}
