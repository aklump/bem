<?php

namespace AKlump\Bem;

use AKlump\Bem\Styles\StyleInterface;

/**
 * Shared fulfillment of the Bem Interfaces.
 *
 * To use this trait your class must implement the abstract methods.  Refer to
 * \AKlump\Bem\Bem as a usage example.
 */
trait BemTrait {

  /**
   * @var string
   */
  private $_bemBlock;

  /** @var \AKlump\Bem\BemInterface */
  private $_bemGlobal;

  public function bemBlock(int $options = 0): string {
    if (!isset($this->_bemBlock)) {
      $this->_bemBlock = $this->getBemStyle()
        ->normalizeBlock($this->getBemBlock());
    }
    $classes = [];
    $classes[] = $this->_bemBlock;
    if ($options & BemInterface::NO_BASE) {
      $classes = [];
    }
    if ($options & BemInterface::JS) {
      $classes[] = $this->getBemStyle()->javascript() . $this->_bemBlock;
    }
    if ($options & BemInterface::GLOBAL) {
      $classes[] = $this->bemGlobal()
        ->bemBlock($this->getGlobalOptions($options));
    }

    return implode(' ', $classes);
  }

  /**
   * Return the BEM element.
   *
   * @param string $element
   *   The element, less the block portion.
   * @param bool $options
   *
   * @return string
   *   The BE(lement)M based on component name.
   */
  public function bemElement(string $element, int $options = 0): string {
    $base = $this->bemBlock();
    $base .= $this->getBemStyle()->element();
    $base .= $this->getBemStyle()->normalizeElement($element);

    $classes = [];
    $classes[] = $base;
    if ($options & BemInterface::NO_BASE) {
      $classes = [];
    }
    if ($options & BemInterface::JS) {
      $classes[] = $this->getBemStyle()->javascript() . $base;
    }
    if ($options & BemInterface::GLOBAL) {
      $classes[] = $this->bemGlobal()
        ->bemElement($element, $this->getGlobalOptions($options));
    }

    return implode(' ', $classes);
  }

  /**
   * Return the BEM modifier.
   *
   * @param string $modifier
   *   The modifier, less the block portion.
   * @param int $options
   *
   * @return string
   *   The BEM(odifier) based on component name.
   */
  public function bemModifier(string $modifier, int $options = 0): string {
    $base = $this->bemBlock();
    $base .= $this->getBemStyle()->modifier();
    $base .= $this->getBemStyle()->normalizeModifer($modifier);

    $classes[] = $base;
    if ($options & BemInterface::NO_BASE) {
      $classes = [];
    }
    if ($options & BemInterface::JS) {
      $classes[] = $this->getBemStyle()->javascript() . $base;
    }
    if ($options & BemInterface::GLOBAL) {
      $classes[] = $this->bemGlobal()
        ->bemModifier($modifier, $this->getGlobalOptions($options));
    }

    return implode(' ', $classes);
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
   * @param int $options
   *
   * @return string
   *   The element and element/modifier, with optional javascript counterparts.
   */
  public function bemElementWithModifier(string $element, string $modifier, int $options = 0) {
    $classes = explode(' ', $this->bemElement($element, $options));
    foreach ($classes as $class) {
      $classes[] = "$class--$modifier";
    }

    return implode(' ', $classes);
  }

  public function bemGlobal(): BemInterface {
    if (!isset($this->_bemGlobal)) {
      $this->_bemGlobal = new static($this->getBemStyle()
        ->normalizeBlock($this->getBemGlobalBlock()));
    }

    return $this->_bemGlobal;
  }

  abstract public function getBemBlock(): string;

  abstract public function getBemGlobalBlock(): string;

  abstract public function getBemStyle(): StyleInterface;


  /**
   * @return array
   *   An array of option combinations that are not allowed.
   */
  private function getInvalidOptionCombinations(): array {
    return [
      BemInterface::GLOBAL | BemInterface::NO_BASE,
      BemInterface::GLOBAL | BemInterface::JS | BemInterface::NO_BASE,
    ];
  }

  private function getGlobalOptions(int $options): int {
    foreach ($this->getInvalidOptionCombinations() as $invalid_option_combination) {
      if ($options === $invalid_option_combination) {
        throw new \OutOfBoundsException("Invalid options combination.");
      }
    }

    $global_options = 0;
    if ($options & BemInterface::JS) {
      $global_options = $global_options | BemInterface::JS;
    }

    return $global_options;
  }

}
