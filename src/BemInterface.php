<?php

namespace AKlump\Bem;


/**
 * Provides BEM style classnames.
 *
 * @link https://en.bem.info/methodology/naming-convention/
 */
interface BemInterface {

  /**
   * {@inheritdoc}
   */
  public function bemBlock(): string;

  /**
   * Return the BEM element.
   *
   * @param string $element
   *   The element, less the block portion.
   * @param bool $include_js
   *   Set this to true to also include a "js-" prefixed element class to be
   *   used explicitly by Javascript operations.
   * @param bool $clean
   *   When TRUE, $element will be processed to remove double hyphens and double
   *   underscores to follow a BEM naming convention.  In some cases you will
   *   not want this so set this to FALSE to avoid manipulation of the passed
   *   value.
   *
   * @return string
   *   The BE(lement)M based on component name.
   */
  public function bemElement(string $element, bool $include_js = FALSE, bool $clean = TRUE): string;

  /**
   * Return the BEM modifier.
   *
   * @param string $modifier
   *   The modifier, less the block portion.
   * @param bool $include_js
   *   Set this to true to also include a "js-" prefixed modifier class to be
   *   used explicitly by Javascript operations.
   * @param bool $clean
   *   When TRUE, $element will be processed to remove double hyphens and double
   *   underscores to follow a BEM naming convention.  In some cases you will
   *   not want this so set this to FALSE to avoid manipulation of the passed
   *   value.
   *
   * @return string
   *   The BEM(odifier) based on component name.
   */
  public function bemModifier(string $modifier, $include_js = FALSE, bool $clean = TRUE): string;

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
   * @param bool $include_js
   *   Set this to true to also include the "js-" prefixed classes for a total
   *   of four classes.
   *
   * @return string
   *   The element and element/modifier, with optional javascript counterparts.
   */
  public function bemElementWithModifier(string $element, string $modifier, bool $include_js = FALSE);

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
   * @param bool $include_js
   * @param bool $clean
   *
   * @return string
   */
  public function bemElementWithGlobal(string $element, bool $include_js = FALSE, bool $clean = TRUE): string;

  /**
   * Return only the BEM block string prefixed for Javascript operations.
   *
   * @return string
   *   The 'js-' block string.
   */
  public function bemJsBlock(): string;

  /**
   * Return only the BEM element prefixed for Javascript operations.
   *
   * @param string $element
   *   The element, less the block portion.
   * @param bool $clean
   *   When TRUE, $element will be processed to remove double hyphens and double
   *   underscores to follow a BEM naming convention.  In some cases you will
   *   not want this so set this to FALSE to avoid manipulation of the passed
   *   value.
   *
   * @return string
   *   The BE(lement)M based on component name.
   */
  public function bemJsElement(string $element, bool $clean = TRUE): string;

  /**
   * Return only the BEM modifier prefixed for Javascript operations.
   *
   * @param string $modifier
   *   The modifier, less the block portion.
   * @param bool $clean
   *   When TRUE, $element will be processed to remove double hyphens and double
   *   underscores to follow a BEM naming convention.  In some cases you will
   *   not want this so set this to FALSE to avoid manipulation of the passed
   *   value.
   *
   * @return string
   *   The BEM(odifier) based on component name.
   */
  public function bemJsModifier(string $modifier, bool $clean = TRUE): string;
}
