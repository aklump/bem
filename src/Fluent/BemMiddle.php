<?php

namespace AKlump\Bem\Fluent;

use AKlump\Bem\Fluent\Interfaces\MiddleInterface;
use AKlump\Bem\Fluent\Interfaces\PurposeInterface;
use AKlump\Bem\Fluent\Interfaces\StateInterface;
use AKlump\Bem\HasStateTrait;

final class BemMiddle implements MiddleInterface {

  use PurposeTrait;
  use OutputTrait;
  use HasStateTrait;

  public function __construct(StateInterface $state) {
    $this->setState($state);
  }

  public function modifier(string $modifier_stub): PurposeInterface {
    return new BemPurpose($this->state->set('modifier', $modifier_stub));
  }

  public function plusModifier(string $modifier_stub): PurposeInterface {
    return new BemPurpose($this->state->set('plusModifier', $modifier_stub));
  }

}
