<?php

namespace AKlump\Bem\Fluent\Interfaces;

use AKlump\Bem\Styles\StyleInterface;

interface StateInterface {

  public function all(): array;

  public function set(string $name, $value);

  public function getType(): int;

  public function getPurpose(): int;

  public function getStyle(): StyleInterface;

  public function getGlobal(): string;
}
