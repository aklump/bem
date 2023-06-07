<?php

namespace AKlump\Bem\Fluent;

use AKlump\Bem\Fluent\Interfaces\BaseInterface;
use AKlump\Bem\Fluent\Interfaces\MiddleInterface;
use AKlump\Bem\HasStateTrait;
use AKlump\Bem\State;
use AKlump\Bem\Styles\StyleInterface;

final class Bem implements BaseInterface {

  use HasStateTrait;

  public function __construct(string $block, string $global = NULL, StyleInterface $style = NULL) {
    $this->setState(new State());
    $this->state
      ->set('block', $block)
      ->set('global', $global)
      ->set('style', $style);
  }

  public function block(): MiddleInterface {
    return new BemMiddle($this->state->set('type', BaseInterface::BLOCK));
  }

  public function element(string $element_stub): MiddleInterface {
    return new BemMiddle(
      $this->state
        ->set('type', BaseInterface::ELEMENT)
        ->set('value', $element_stub)
    );
  }

}
