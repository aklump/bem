<?php

namespace AKlump\Bem;


/**
 * Provides BEM style classnames.
 *
 * @link https://en.bem.info/methodology/naming-convention/
 */
interface BemInterface {

  /**
   * @var int with-javascript option.
   */
  const JS = 1;

  /**
   * @var int with-javascript option.
   */
  const GLOBAL = 2;

  /**
   * @var int without the bem base.  combine with JS to only get the JS class.
   * Combine with global to only get the global class.
   */
  const NO_BASE = 4;

  /**
   * Standalone entity that is meaningful on its own.
   *
   * @return string
   *   Return the block value.
   */
  public function bemBlock(): string;

  /**
   * Return the BEM element.
   *
   * A part of a block that has no standalone meaning and is semantically tied to its block.
   *
   * @param string $element
   *   The element, less the block portion.
   * @param int $options
   *
   * @return string
   *   The BE(lement)M based on component name.
   */
  public function bemElement(string $element, int $options = 0): string;

  /**
   * Return the BEM modifier.
   *
   * A flag on a block or element. Use them to change appearance or behavior.
   *
   * @param string $modifier
   *   The modifier, less the block portion.
   * @param int $options
   *
   * @return string
   *   The BEM(odifier) based on component name.
   */
  public function bemModifier(string $modifier, int $options = 0): string;

  /**
   * Generate an element and a modifier of that element.
   *
   * @code
   *   $this->bemElementWithModifier('subject', 'desktop');
   *   ...
   *   <div class="som-tile__subject som-tile__subject--desktop">lorem</div>
   * @endcode
   *
   * @param string $element
   *   The element, less the block portion.
   * @param string $modifier
   *   The modifier to be appended to the generated element; see @code example.
   * @param int $options
   *   Set this to true to also include the "js-" prefixed classes for a total
   *   of four classes.
   *
   * @return string
   *   The element and element/modifier, with optional javascript counterparts.
   */
  public function bemElementWithModifier(string $element, string $modifier, int $options = 0);

  /**
   * Return only the BEM block string prefixed for Javascript operations.
   *
   * @return string
   *   The 'js-' block string.
   */
  //  public function bemJsBlock(): string;

  /**
   * Return only the BEM element prefixed for Javascript operations.
   *
   * @param string $element
   *   The element, less the block portion.
   *
   * @return string
   *   The BE(lement)M based on component name.
   */
  //  public function bemJsElement(string $element): string;

  /**
   * Return only the BEM modifier prefixed for Javascript operations.
   *
   * @param string $modifier
   *   The modifier, less the block portion.
   *
   * @return string
   *   The BEM(odifier) based on component name.
   */
  //  public function bemJsModifier(string $modifier): string;
}
