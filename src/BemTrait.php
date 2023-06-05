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
  private $bemBlock;

  protected static $bemGlobal = 'bem';

  /**
   * {@inheritdoc}
   */
  public static function bemGlobalSetBlock(string $global_block = 'bem'): void {
    self::$bemGlobal = $global_block;
  }

  /**
   * {@inheritdoc}
   */
  public function bemSetBlock(string $block): void {
    $this->bemBlock = $this->bemStyle()
      ->normalizeBlock($block);
  }

  /**
   * {@inheritdoc}
   */
  public function bemSetStyle(StyleInterface $style): void {
    $this->bemStyle = $style;
  }

  /**
   * {@inheritdoc}
   */
  public static function bemGlobal(): BemInterface {
    return new self(self::$bemGlobal);
  }

  protected function bemStyle(): StyleInterface {
    return $this->bemStyle ?? new \AKlump\Bem\Styles\Official();
  }

  /**
   * {@inheritdoc}
   */
  public function bemBlock(int $options = 0): string {
    if (!isset($this->bemBlock)) {
      throw new \RuntimeException(sprintf('You must call %s->bemSetBlock() first', static::class));
    }
    $classes = [];
    $classes[] = $this->bemBlock;
    if ($options & BemInterface::NO_BASE) {
      $classes = [];
    }
    if ($options & BemInterface::JS) {
      $classes[] = $this->bemStyle()->javascript() . $this->bemBlock;
    }
    if ($options & BemInterface::GLOBAL) {
      $classes[] = $this->bemGlobal()
        ->bemBlock($options & ~BemInterface::GLOBAL);
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
    $base .= $this->bemStyle()->element();
    $base .= $this->bemStyle()->normalizeElementStub($element);

    $classes = [];
    $classes[] = $base;
    if ($options & BemInterface::NO_BASE) {
      $classes = [];
    }
    if ($options & BemInterface::JS) {
      $classes[] = $this->bemStyle()->javascript() . $base;
    }
    if ($options & BemInterface::GLOBAL) {
      $classes[] = $this->bemGlobal()
        ->bemElement($element, $options & ~BemInterface::GLOBAL);
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
    $base .= $this->bemStyle()->modifier();
    $base .= $this->bemStyle()->normalizeModifierStub($modifier);

    $classes[] = $base;
    if ($options & BemInterface::NO_BASE) {
      $classes = [];
    }
    if ($options & BemInterface::JS) {
      $classes[] = $this->bemStyle()->javascript() . $base;
    }
    if ($options & BemInterface::GLOBAL) {
      $classes[] = $this->bemGlobal()
        ->bemModifier($modifier, $options & ~BemInterface::GLOBAL);
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
    $element_options = $options & ~BemInterface::NO_BASE;
    $classes = explode(' ', $this->bemElement($element, $element_options));
    if ($options & BemInterface::NO_BASE) {
      foreach ($classes as &$class) {
        $class = "$class--$modifier";
      }
    }
    else {
      foreach ($classes as $class) {
        $classes[] = "$class--$modifier";
      }
    }

    return implode(' ', $classes);
  }

}
