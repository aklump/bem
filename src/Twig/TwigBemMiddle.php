<?php

namespace AKlump\Bem\Twig;

use AKlump\Bem\Fluent\BemMiddle;
use AKlump\Bem\Fluent\BemOutput;
use AKlump\Bem\Fluent\BemPurpose;
use AKlump\Bem\Fluent\Interfaces\MiddleInterface;
use AKlump\Bem\Fluent\Interfaces\PurposeInterface;
use AKlump\Bem\Fluent\Interfaces\StateInterface;
use AKlump\Bem\HasStateTrait;

/**
 * Decorator class written for the BEM Twig extension.
 *
 * @see \AKlump\Bem\Twig\BemExtension
 * @see \AKlump\Bem\Fluent\Bem
 */
final class TwigBemMiddle implements MiddleInterface {

  use HasStateTrait;

  public function __construct(StateInterface $state) {
    $this->setState($state);
  }

  public function modifier(string $modifier_stub): PurposeInterface {
    $middle = new BemMiddle($this->state);
    $this->setState($middle->modifier($modifier_stub)->getState());

    return $this;
  }

  public function plus_modifier(string $modifier_stub) {
    $middle = new BemMiddle($this->state);
    $this->setState($middle->plusModifier($modifier_stub)->getState());

    return $this;
  }

  public function plusModifier(string $modifier_stub): PurposeInterface {
    return $this->plus_modifier($modifier_stub);
  }

  public function js(): PurposeInterface {
    $purpose = new BemPurpose($this->state);
    $this->setState($purpose->js()->getState());

    return $this;
  }

  public function plus_js() {
    $purpose = new BemPurpose($this->state);
    $this->setState($purpose->plusJs()->getState());

    return $this;
  }

  public function plusJs(): PurposeInterface {
    return $this->plus_js();
  }

  public function plus_global() {
    $purpose = new BemPurpose($this->state);
    $this->setState($purpose->plusGlobal()->getState());

    return $this;
  }

  public function plusGlobal(): PurposeInterface {
    return $this->plus_global();
  }

  public function __toString() {
    return $this->toString();
  }

  public function toString(): string {
    $output = new BemOutput($this->state);

    return $output->toString();
  }

  public function toArray(): array {
    $output = new BemOutput($this->state);

    return $output->toArray();
  }

}
