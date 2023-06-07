<?php

namespace AKlump\Bem\Fluent;

use AKlump\Bem\Fluent\Interfaces\PurposeInterface;


trait PurposeTrait {

  public function js(): PurposeInterface {
    $purpose = $this->state->getPurpose();
    $purpose |= PurposeInterface::JS;
    $purpose &= ~PurposeInterface::PLUS_JS;

    return new BemPurpose($this->state->set('purpose', $purpose));
  }

  public function plusJs(): PurposeInterface {
    $purpose = $this->state->getPurpose();
    $purpose |= PurposeInterface::PLUS_JS;
    $purpose &= ~PurposeInterface::JS;

    return new BemPurpose($this->state->set('purpose', $purpose));
  }

  public function plusGlobal(): PurposeInterface {
    $purpose = $this->state->getPurpose();
    $purpose |= PurposeInterface::PLUS_GLOBAL;

    return new BemPurpose($this->state->set('purpose', $purpose));
  }
}
