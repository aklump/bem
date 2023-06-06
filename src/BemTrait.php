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

  private $bemGlobalBlock = BemInterface::GLOBAL_BLOCK;

  /**
   * {@inheritdoc}
   */
  public function bemGlobalSetBlock(string $global_block = BemInterface::GLOBAL_BLOCK): void {
    $this->bemGlobalBlock = $global_block;
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
  public function bemGlobal(): BemInterface {
    return new self($this->bemGlobalBlock);
  }

  protected function bemStyle(): StyleInterface {
    return $this->bemStyle ?? new \AKlump\Bem\Styles\Official();
  }

  /**
   * {@inheritdoc}
   */
  public function bemBlock(int $options = 0): string {
    $this->validateNoBaseOption(__FUNCTION__, $options);
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
   * Validate the BemInterface::NO_BASE option for a given method.
   *
   * @param string $method
   *   The shortname, e.g. "__FUNCTION__" taken from a class method.
   * @param int $options
   *   The options used.
   *
   * @return void
   */
  private function validateNoBaseOption(string $method, int $options): void {
    $no_base_option_was_used = (bool) ($options & BemInterface::NO_BASE);
    if (!$no_base_option_was_used) {
      return;
    }
    $allowed_in_methods = ['bemElementWithModifier'];
    if (in_array($method, $allowed_in_methods)) {
      return;
    }
    $no_base_option_is_allowed = ($options & BemInterface::GLOBAL) || ($options & BemInterface::JS);
    if (!$no_base_option_is_allowed) {
      throw new \InvalidArgumentException(sprintf('The NO_BASE option is not allowed for %s', $method));
    }
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
    $this->validateNoBaseOption(__FUNCTION__, $options);
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
    $this->validateNoBaseOption(__FUNCTION__, $options);
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
    $this->validateNoBaseOption(__FUNCTION__, $options);
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
