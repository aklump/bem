<?php

namespace AKlump\Bem\Fluent;

use AKlump\Bem\Fluent\Interfaces\PurposeInterface;
use AKlump\Bem\Fluent\Interfaces\StateInterface;
use AKlump\Bem\HasStateTrait;

final class BemPurpose implements PurposeInterface {

  use OutputTrait;
  use PurposeTrait;
  use HasStateTrait;

  public function __construct(StateInterface $state) {
    $this->setState($state);
  }

}
