<?php

namespace AKlump\Bem\Tests\Fluent;

use AKlump\Bem\Fluent\Bem;
use AKlump\Bem\Fluent\Interfaces\MiddleInterface;
use AKlump\Bem\Fluent\Interfaces\OutputInterface;
use AKlump\Bem\Fluent\Interfaces\PurposeInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AKlump\Bem\Fluent\Bem
 */
class BemExtendedTest extends TestCase {

  public function testTheBemClassCanBeExtended() {
    // This will protect that \AKlump\Bem\Fluent\Bem isn't made "final".
    $bem = new BemExtended('foo');
    $result = $bem->block();
    $this->assertInstanceOf(MiddleInterface::class, $result);
    $this->assertSame('foo', (string) $result);
  }

}

final class BemExtended extends Bem {

}
