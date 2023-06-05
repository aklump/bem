<?php

namespace AKlump\Bem;

use AKlump\Bem\Styles\Legacy;

/**
 * Provides BEM methods using legacy interface and styles.
 *
 * @deprecated
 */
final class BemLegacy {

  use BemTrait {
    bemModifier as traitBemModifier;
    bemElement as traitBemElement;
  }

  /**
   * BEM constructor.
   *
   * @param string $block
   *   The base to use for the BEM block.
   */
  public function __construct(string $block) {
    $this->bemSetBlock($block);
    $this->bemSetStyle(new Legacy());
  }

  public function bemModifier(string $modifier, $include_js = FALSE, $clean = TRUE): string {
    $output = $this->bemBlock();
    $output .= $this->bemStyle()->modifier();
    if ($clean) {
      $output .= $this->bemStyle()->normalizeModifierStub($modifier);
    }
    else {
      $output .= $modifier;
    }
    if ($include_js) {
      $output .= ' ' . $this->bemJsModifier($modifier);
    }

    return $output;
  }

  public function bemElement(string $element, bool $include_js = FALSE, $clean = TRUE): string {
    $output = $this->bemBlock();
    $output .= $this->bemStyle()->element();
    if ($clean) {
      $output .= $this->bemStyle()->normalizeElementStub($element);
    }
    else {
      $output .= $element;
    }
    if ($include_js) {
      $output .= ' ' . $this->bemJsElement($element);
    }

    return $output;
  }

  /**
   * Remove double underscores and hyphens to facilitate proper BEM parts.
   *
   * @param string $string
   *   A string to clean for use with BEM part.
   *
   * @return string
   *   The cleaned bem part string.
   *
   * @link https://en.bem.info/methodology/naming-convention/
   */
  public function cleanBem(string $string): string {
    return $this->bemStyle()->normalizeElementStub($string);
  }

  /**
   * @param string $string
   *
   * @return string
   * @url https://en.bem.info/methodology/naming-convention/#two-dashes-style
   *
   * // TODO Figure out how to implement this instead of clean.
   */
  public function twoDashStyle(string $string): string {
    $string = strtolower($string);
    $string = preg_replace('/[\W_]/', '-', $string);
    $string = preg_replace('/[-_]{2,}/', '-', $string);

    return $string;
  }

  /**
   * Return only the BEM block string prefixed for Javascript operations.
   *
   * @return string
   *   The 'js-' block string.
   */
  public function bemJsBlock(): string {
    $class = $this->bemStyle()->javascript();
    $class .= $this->bemBlock();

    return $class;
  }

  /**
   * Return only the BEM element prefixed for Javascript operations.
   *
   * @param string $element
   *   The element, less the block portion.
   *
   * @return string
   *   The BE(lement)M based on component name.
   */
  public function bemJsElement(string $element): string {
    $class = $this->bemStyle()->javascript();
    $class .= $this->bemElement($element, FALSE);

    return $class;
  }

  /**
   * Return only the BEM modifier prefixed for Javascript operations.
   *
   * @param string $modifier
   *   The modifier, less the block portion.
   *
   * @return string
   *   The BEM(odifier) based on component name.
   */
  public function bemJsModifier(string $modifier): string {
    $class = $this->bemStyle()->javascript();
    $class .= $this->bemModifier($modifier, FALSE);

    return $class;
  }


  /**
   * In addition to a bem element, adds a global class, e.g. "el__width".
   *
   * The global class allows for targeting an element regardless of the specific
   * bem block name, but by virture of the element part of the class, such as
   * for all components at once.  For example if you want to set the width on
   * any child component,  you could write your CSS like so: .parent>.el__width,
   * rather than .parent>.foo__width, where "foo" is the bem block.
   *
   * @param string $element
   * @param int $options
   *
   * @return string
   *
   * @deprecated Use \AKlump\Bem\BemInterface::bemElement($element,
   * BemInterface::GLOBAL) or \AKlump\Bem\BemInterface::bemElement($element, BemInterface::GLOBAL |
   * BemInterface::JS) instead.
   */
  public function bemElementWithGlobal(string $element, int $options = 0): string {
    $global = new Bem('bem');

    return implode(' ', [
      $this->bemElement($element, $options),
      $global->bemElement($element, $options),
    ]);
  }

}
