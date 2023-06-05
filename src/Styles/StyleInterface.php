<?php

namespace AKlump\Bem\Styles;

interface StyleInterface {

  public function element(): string;

  /**
   * Mutate element portion before it's returned as a full classname.
   *
   * This could be used to remove '__' for example, which would be an invalid
   * substring in an official element name.
   *
   * @return string
   *   The normalized element portion of the block+element class.
   */
  public function normalizeElement(string $element): string;

  public function normalizeBlock(string $block): string;

  public function modifier(): string;

  /**
   * Mutate modifier portion before it's returned as a full classname.
   *
   * This could be used to remove '--' for example, which would be an invalid
   * substring in an official modifier name.
   *
   * @return string
   *   The normalized element portion of the block+modifier class.
   */
  public function normalizeModifer(string $modifier): string;

  /**
   * @return string
   *   The classname prefix to indicate a JS class.
   *
   * @see \AKlump\Bem\BemInterface::bemJsBlock
   * @see \AKlump\Bem\BemInterface::bemJsElement
   * @see \AKlump\Bem\BemInterface::bemJsModifier
   */
  public function javascript(): string;

}