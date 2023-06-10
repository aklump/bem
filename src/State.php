<?php

namespace AKlump\Bem;


use AKlump\Bem\Fluent\Interfaces\BaseInterface;
use AKlump\Bem\Fluent\Interfaces\StateInterface;

class State implements StateInterface {

  private $state = [];

  public function all(): array {
    return $this->state;
  }

  public function set(string $name, $value) {
    $this->state[$name] = $value;

    return $this;
  }

  public function getType(): int {
    $type = $this->all()['type'] ?? NULL;
    if ($type & BaseInterface::ELEMENT) {
      return $type;
    }

    return BaseInterface::BLOCK;
  }

  public function getBlock(): string {
    return $this->all()['block'] ?? '';
  }

  public function getGlobal(): string {
    return $this->all()['global'] ?? 'bem';
  }

  public function getPurpose(): int {
    return $this->all()['purpose'] ?? 0;
  }

  public function getStyle(): \AKlump\Bem\Styles\StyleInterface {
    return $this->all()['style'] ?? new \AKlump\Bem\Styles\Official();
  }
}
