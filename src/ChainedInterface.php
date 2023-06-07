<?php

namespace AKlump\Bem;

interface ChainedInterface {

  public function and(): ChainedInterface;

  public function modifier(string $modifier_stub): ChainedInterface;

  public function js(): ChainedInterface;

  public function global(): ChainedInterface;


}
