<?php

namespace AKlump\Bem\Styles;

/**
 * @deprecated
 */
final class Legacy implements StyleInterface {

  public function element(): string {
    return '__';
  }

  public function modifier(): string {
    return '--';
  }

  public function javascript(): string {
    return 'js-';
  }

  public function normalizeElement(string $element): string {
    $element = str_replace([' ', '.'], ['-', '-'], $element);
    $element = preg_replace('/_{2,}/', '_', $element);
    $element = preg_replace('/-{2,}/', '-', $element);

    return $element;
  }

  public function normalizeModifer(string $modifier): string {
    $string = $modifier;
    $string = str_replace([' ', '.'], ['-', '-'], $string);
    $string = preg_replace('/_{2,}/', '_', $string);
    $string = preg_replace('/-{2,}/', '-', $string);

    return $string;
  }

  public function normalizeBlock(string $block): string {
    return $block;
  }

}
