<?php

namespace AKlump\Bem\Twig;

use AKlump\Bem\Fluent\Bem;
use AKlump\Bem\Fluent\BemOutput;
use AKlump\Bem\Fluent\Interfaces\BaseInterface;
use AKlump\Bem\Fluent\Interfaces\MiddleInterface;
use AKlump\Bem\HasStateTrait;
use AKlump\Bem\State;

/**
 * Decorator class written for the BEM Twig extension.
 *
 * @see \AKlump\Bem\Twig\BemExtension
 * @see \AKlump\Bem\Fluent\Bem
 */
final class TwigBem implements BaseInterface {

  use HasStateTrait;

  /**
   * @var \AKlump\Bem\Fluent\Bem
   */
  private $base;

  /**
   * @var \AKlump\Bem\State
   */
  private $state;

  public function __construct(string $block, string $global) {
    $this->setState(new State());
    $this->state
      ->set('block', $block)
      ->set('global', $global);
    $this->base = new Bem($block, $global);
  }

  public function block(): MiddleInterface {
    $this->validateBlockIsNotEmpty();
    $this->setState($this->base->block()->getState());

    return new TwigBemMiddle($this->state);
  }

  public function element(string $element_stub): MiddleInterface {
    $this->validateBlockIsNotEmpty();
    $this->setState($this->base->element($element_stub)->getState());

    return new TwigBemMiddle($this->state);
  }

  private function validateBlockIsNotEmpty() {
    if (empty($this->state->getBlock())) {
      throw new \RuntimeException('You must call bem_set_block() before all other functions.');
    }
  }

  public function __toString() {
    $output = new BemOutput($this->state);

    return $output->toString();
  }

}
