<?php

namespace AKlump\Bem\Fluent;

use AKlump\Bem\Fluent\Interfaces\OutputInterface;
use AKlump\Bem\Fluent\Interfaces\StateInterface;
use AKlump\Bem\HasStateTrait;

final class BemOutput implements OutputInterface {

  use OutputTrait;
  use HasStateTrait;

  public function __construct(StateInterface $state) {
    $this->setState($state);
  }

}
