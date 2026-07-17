<?php

namespace AKlump\Bem\Tests;

use AKlump\Bem\Fluent\Interfaces\BaseInterface;
use AKlump\Bem\State;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AKlump\Bem\State
 */
class StateTest extends TestCase {

  public function testGetGlobal() {
    $state = new State();
    $this->assertSame('bem', $state->getGlobal());
    $state->set('global', 'component');
    $this->assertSame('component', $state->getGlobal());
  }

  public function testGetType() {
    $state = new State();
    $this->assertSame(BaseInterface::BLOCK, $state->getType());

    $state->set('type', BaseInterface::ELEMENT);
    $this->assertSame(BaseInterface::ELEMENT, $state->getType());
  }

}
