<?php

namespace AKlump\Bem\Fluent\Interfaces;

interface BaseInterface {

  const BLOCK = 1;

  const ELEMENT = 2;

  public function block(): MiddleInterface;

  public function element(string $element_stub): MiddleInterface;
}
