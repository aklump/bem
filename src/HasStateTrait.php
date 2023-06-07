<?php

namespace AKlump\Bem;


use AKlump\Bem\Fluent\Interfaces\StateInterface;

trait HasStateTrait {

  /**
   * @var \AKlump\Bem\Fluent\Interfaces\StateInterface
   */
  private $state;

  public function setState(StateInterface $state) {
    $this->state = $state;
  }

  public function getState(): StateInterface {
    return $this->state;
  }
}
