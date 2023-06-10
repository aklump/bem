<?php

namespace AKlump\Bem\Fluent\Interfaces;

interface MiddleInterface extends PurposeInterface {

  public function modifier(string $modifier_stub): PurposeInterface;

  public function plusModifier(string $modifier_stub): PurposeInterface;
}
