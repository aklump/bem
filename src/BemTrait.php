<?php

namespace AKlump\Bem;

/**
 * Trait BemTrait handles block/element/modifier CSS.
 *
 * To use this trait your class must implement the method ::bemBlock, which
 * returns the base value for BEM concantenation.  Here is an example
 * implementation:
 *
 * @code
 *   public function bemBlock(): string {
 *     return 'user-collections';
 *   }
 * @endcode
 */
trait BemTrait {

  /**
   * Return the BEM block string.
   *
   * @return string
   *   The block string.
   */
  abstract public function bemBlock(): string;

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
  public function bemElement(string $element, bool $include_js = FALSE, bool $clean = TRUE): string {
    if ($clean) {
      $element = $this->cleanBem($element);
    }
    $output = $this->bemBlock() . '__' . $element;
    if (!$include_js) {
      return $output;
    }

    return $output . ' ' . $this->bemJsElement($element, $clean);
  }

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
  public function bemModifier(string $modifier, $include_js = FALSE, bool $clean = TRUE): string {
    if ($clean) {
      $modifier = $this->cleanBem($modifier);
    }
    $output = $this->bemBlock() . '--' . $modifier;
    if (!$include_js) {
      return $output;
    }

    return $output . ' ' . $this->bemJsModifier($modifier, $clean);
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
   * @param bool $include_js
   * @param bool $clean
   *
   * @return string
   */
  public function bemElementWithGlobal(string $element, bool $include_js = FALSE, bool $clean = TRUE): string {
    if (empty($this->bemGlobal)) {
      $this->bemGlobal = new \Drupal\front_end_components\Bem(\Drupal\front_end_components\Bem::GLOBAL);
    }

    return implode(' ', [
      $this->bemElement($element, $include_js, $clean),
      $this->bemGlobal->bemElement($element, $include_js, $clean),
    ]);
  }

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
  public function bemElementWithModifier(string $element, string $modifier, bool $include_js = FALSE) {
    $bem_element = $this->bemElement($element);
    $output = [$bem_element, "$bem_element--$modifier"];
    if ($include_js) {
      $js_bem_element = $this->bemJsElement($element);
      $output[] = $js_bem_element;
      $output[] = "$js_bem_element--$modifier";
    }

    return implode(' ', $output);
  }

  /**
   * Return only the BEM block string prefixed for Javascript operations.
   *
   * @return string
   *   The 'js-' block string.
   */
  public function bemJsBlock(): string {
    return 'js-' . $this->bemBlock();
  }

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
  public function bemJsElement(string $element, bool $clean = TRUE): string {
    if ($clean) {
      $element = $this->cleanBem($element);
    }

    return 'js-' . $this->bemBlock() . '__' . $element;
  }

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
  public function bemJsModifier(string $modifier, bool $clean = TRUE): string {
    if ($clean) {
      $modifier = $this->cleanBem($modifier);
    }

    return 'js-' . $this->bemBlock() . '--' . $modifier;
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
    $string = str_replace([' ', '.'], ['-', '-'], $string);
    $string = preg_replace('/_{2,}/', '_', $string);
    $string = preg_replace('/-{2,}/', '-', $string);

    return $string;
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

}
