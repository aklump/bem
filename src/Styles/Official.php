<?php

namespace AKlump\Bem\Styles;

final class Official implements StyleInterface {

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
    return $this->normalize($value);
  }

  /**
   * Element names may consist of Latin letters, digits, dashes.
   *
   * @param string $element
   *
   * @return string
   */
  public function normalizeElementStub(string $value): string {
    return $this->normalize($value);
  }

  /**
   * Modifier names may consist of Latin letters, digits, dashes.
   *
   * @param string $modifier
   *
   * @return string
   */
  public function normalizeModifierStub(string $value): string {
    return $this->normalize($value);
  }

  /**
   * Normalize a CSS class BEM part before it's combined.
   *
   * @param string $name_part
   *
   * @return string
   *
   * @link https://getbem.com/naming/
   */
  private function normalize(string $name_part) {
    $name_part = strtolower($name_part);

    // May consist of Latin letters, digits, and single dashes.
    $name_part = preg_replace('/[^a-z0-9-]/', '-', $name_part);

    // They may not contain multiple, consecutive dashes/underscores.
    $name_part = preg_replace('/[-]{2,}/', '-', $name_part);

    return $name_part;
  }

}
