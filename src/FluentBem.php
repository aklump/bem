<?php

namespace AKlump\Bem;

use AKlump\Bem\Styles\Official;
use AKlump\Bem\Styles\StyleInterface;

class FluentBem implements FluentInterface, ChainedInterface {

  const AND_PENDING = 'pending';

  const AND_JS = 'js';

  const AND_MODIFIER = 'modifier';

  private $state = [];

  /**
   * @var \AKlump\Bem\Styles\StyleInterface
   */
  private $style;

  public function __construct(string $block = '', string $global_block = BemInterface::GLOBAL_BLOCK) {
    $this->flush();
    $this->setBlock($block);
    $this->setGlobalBlock($global_block);
  }

  private function flush() {
    $this->state = [
      'block' => $this->state['block'] ?? NULL,
      'global' => $this->state['global'] ?? NULL,
      'previous' => $this->state['previous'] ?? NULL,
      'type' => NULL,
      'value' => NULL,
      'and' => NULL,
      'options' => 0,
      'modifiers' => [],
      'stack' => [],
    ];
  }

  public function setGlobalBlock(string $global_block): void {
    $this->state['global'] = $global_block;
  }

  public function setBlock(string $block): void {
    $this->state['block'] = $block;
  }

  /**
   * @inheritDoc
   */
  public function block(): ChainedInterface {
    $this->validateChain(__FUNCTION__);
    $this->flush();
    $this->state['type'] = BemInterface::BLOCK;
    $this->state['value'] = $this->state['block'] ?? '';

    return $this;
  }

  /**
   * @inheritDoc
   */
  public function element(string $element_stub): ChainedInterface {
    $this->validateChain(__FUNCTION__);
    $this->flush();
    $this->state['type'] = BemInterface::ELEMENT;
    $this->state['value'] = $element_stub;

    return $this;
  }

  /**
   * @return \AKlump\Bem\Styles\StyleInterface
   */
  public function getStyle(): StyleInterface {
    return $this->style ?? new Official();
  }

  /**
   * @param \AKlump\Bem\Styles\StyleInterface $style
   *
   * @return
   *   Self for chaining.
   */
  public function setStyle(Styles\StyleInterface $style): void {
    $this->style = $style;
  }

  public function and(): ChainedInterface {
    $this->state['previous'] = __FUNCTION__;
    $this->state['stack'][] = (string) $this;
    $this->state['and'] = TRUE;
    $this->state['options'] &= ~BemInterface::JS;

    return $this;
  }

  public function toArray(): array {
    return explode(' ', (string) $this);
  }

  public function modifier(string $modifier_stub): ChainedInterface {
    $this->state['previous'] = __FUNCTION__;
    $this->setNoBaseOption();
    $this->state['modifiers'][] = $modifier_stub;

    return $this;
  }

  public function js(): ChainedInterface {
    $this->state['previous'] = __FUNCTION__;
    $this->setNoBaseOption();
    $this->state['options'] |= BemInterface::JS;

    return $this;
  }

  public function global(): ChainedInterface {
    $this->state['previous'] = __FUNCTION__;
    $this->setNoBaseOption();
    $this->state['options'] |= BemInterface::GLOBAL;

    return $this;
  }

  private function setNoBaseOption() {
    if (empty($this->state['and'])) {
      $this->state['options'] |= BemInterface::NO_BASE;
    }
  }

  public function __toString() {
    $this->state['previous'] = __FUNCTION__;
    if (empty ($this->state['type'])) {
      return '';
    }
    $bem = new Bem($this->state['block'], $this->state['global']);

    switch ($this->state['type']) {
      case BemInterface::BLOCK:
        $class = $this->__toStringBlock($bem);
        break;

      case BemInterface::ELEMENT:
        $class = $this->__toStringElement($bem);
        break;

      default:
        return '';
    }

    // Remove potential duplication.
    $class = explode(' ', trim($class));
    $class = implode(' ', array_unique($class));

    return $class;
  }

  private function __toStringBlock(BemInterface $bem): string {
    $class = implode(' ', $this->state['stack']);
    // Base
    if (!($this->state['options'] & BemInterface::NO_BASE)) {
      $options = $this->state['options'];
      $options &= ~BemInterface::NO_BASE;
      $options &= ~BemInterface::JS;
      $options &= ~BemInterface::GLOBAL;
      $class .= ' ' . $bem->bemBlock($options);
    }

    if (empty($this->state['modifiers'])) {
      // Block JS
      if ($this->state['options'] & BemInterface::JS) {
        $options = $this->state['options'];
        $options |= BemInterface::NO_BASE;
        $options &= ~BemInterface::GLOBAL;
        $class .= ' ' . $bem->bemBlock($options);
      }
      // Block global
      if ($this->state['options'] & BemInterface::GLOBAL) {
        $options = $this->state['options'];
        $options &= ~BemInterface::NO_BASE;
        $options &= ~BemInterface::GLOBAL;
        $class .= ' ' . $bem->bemGlobal()->bemBlock($options);
      }
    }
    else {
      // Modifier
      $options = $this->state['options'];
      if (!($options & BemInterface::JS) && !($options & BemInterface::GLOBAL)) {
        $options &= ~BemInterface::NO_BASE;
      }
      foreach ($this->state['modifiers'] as $modifier) {
        $class .= ' ' . $bem->bemModifier($modifier, $options);
      }
    }

    return $class;
  }

  private function __toStringElement(BemInterface $bem): string {
    $class = implode(' ', $this->state['stack']);
    // Base
    if (!($this->state['options'] & BemInterface::NO_BASE)) {
      $options = $this->state['options'];
      $options &= ~BemInterface::NO_BASE;
      $options &= ~BemInterface::JS;
      $options &= ~BemInterface::GLOBAL;
      $class .= ' ' . $bem->bemElement($this->state['value'], $options);
    }

    if (empty($this->state['modifiers'])) {
      // Modifier JS
      if ($this->state['options'] & BemInterface::JS) {
        $options = $this->state['options'];
        $options |= BemInterface::NO_BASE;
        $options &= ~BemInterface::GLOBAL;
        $class .= ' ' . $bem->bemElement($this->state['value'], $options);
      }
      // Modifier global
      if ($this->state['options'] & BemInterface::GLOBAL) {
        $options = $this->state['options'];
        $options &= ~BemInterface::NO_BASE;
        $options &= ~BemInterface::GLOBAL;
        $class .= ' ' . $bem->bemGlobal()
            ->bemElement($this->state['value'], $options);
      }
    }
    else {
      // Element Modifier
      $options = $this->state['options'];
      if (!($options & BemInterface::JS) && !($options & BemInterface::GLOBAL)) {
        $options &= ~BemInterface::NO_BASE;
      }
      else {
        $options |= BemInterface::NO_BASE;
      }
      $element = explode(' ', $bem->bemElement($this->state['value'], $options));
      foreach ($this->state['modifiers'] as $modifier) {
        $element = array_map(function ($el) use ($modifier) {
          return $el . $this->getStyle()->modifier() . $modifier;
        }, $element);
        $class .= ' ' . implode(' ', $element);
      }
    }

    return $class;
  }

  private function validateChain(string $function) {
    $previous = $this->state['previous'] ?? NULL;
    $invalid = $function === 'block' && 'element' === $previous;
    $invalid = $invalid || $function === 'element' && 'block' === $previous;
    if ($invalid) {
      throw new \RuntimeException(sprintf('It is not allowed',));
    }
    $this->state['previous'] = $function;
  }
}
