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

  public function normalizeBlock(string $block): string {
    $block = strtolower($block);

    return $block;
  }

  public function normalizeElement(string $element): string {
    $element = strtolower($element);

    return $element;
  }

  public function normalizeModifer(string $modifier): string {
    $modifier = strtolower($modifier);

    return $modifier;
  }
}
