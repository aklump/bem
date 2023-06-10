<?php

namespace AKlump\Bem\Fluent\Interfaces;

interface OutputInterface {

  public function toString(): string;

  public function toArray(): array;

  public function getState(): StateInterface;

}
