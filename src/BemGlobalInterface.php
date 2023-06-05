<?php

namespace AKlump\Bem;

/**
 * Provides some adjunct innovations related to a "global" block concept.
 */
interface BemGlobalInterface {

  /**
   * Get the global block.
   *
   * @return string
   *   The global BEM block.
   */
  public function bemGlobal(): BemInterface;

}
