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
class BemTest extends TestCase {

  public function testModifierNormalizationIsRunning() {
    $bem = new Bem('foo--bar');
    $this->assertSame('foo-bar__baz-bar--lorem-ipsum-dolar', $bem->element('baz   bar ')
      ->modifier('lorem__ipsum--dolar ')
      ->toString());
  }

  public function testElementNormalizationIsRunning() {
    $bem = new Bem('foo--bar');
    $this->assertSame('foo-bar__baz-bar', $bem->element('baz   bar ')
      ->toString());
  }

  public function testBlockNormalizationIsRunning() {
    $bem = new Bem('foo--bar');
    $this->assertSame('foo-bar', $bem->block()->toString());
  }

  public function testElement() {
    $bem = new Bem('foo');
    $result = $bem->element('bar');
    $result = $bem->element('bar');
    $this->assertInstanceOf(MiddleInterface::class, $result);
    $this->assertSame('foo__bar', (string) $result);
  }

  public function testClassSortOrder() {
    $bem = new Bem('kilo', 'alpha');

    $result = $bem->block()->plusJs()->plusGlobal();
    $this->assertInstanceOf(OutputInterface::class, $result);
    $this->assertSame('kilo js-kilo js-alpha alpha', (string) $result);

    $bem = new Bem('kilo', 'zulu');
    $result = $bem->block()->plusJs()->plusGlobal();
    $this->assertInstanceOf(OutputInterface::class, $result);
    $this->assertSame('kilo js-kilo js-zulu zulu', (string) $result);
  }

  public function testBlockPlusJs() {
    $bem = new Bem('foo');
    $result = $bem->block()->plusJs();
    $this->assertInstanceOf(OutputInterface::class, $result);
    $this->assertSame('foo js-foo', (string) $result);
  }

  public function testBlockPlusGlobalPlusJs() {
    $bem = new Bem('foo');
    $result = $bem->block()->plusGlobal()->plusJs();
    $this->assertInstanceOf(OutputInterface::class, $result);
    $this->assertSame('foo js-foo js-bem bem', (string) $result);

    $result = $bem->block()->plusJs()->plusGlobal();
    $this->assertInstanceOf(OutputInterface::class, $result);
    $this->assertSame('foo js-foo js-bem bem', (string) $result);
  }

  public function testBlockPlusGlobalJs() {
    $bem = new Bem('foo');
    $result = $bem->block()->plusGlobal()->js();
    $this->assertInstanceOf(OutputInterface::class, $result);
    $this->assertSame('js-foo js-bem', (string) $result);
    $result = $bem->block()->js()->plusGlobal();
    $this->assertInstanceOf(OutputInterface::class, $result);
    $this->assertSame('js-foo js-bem', (string) $result);
  }

  public function testBlockPlusGlobal() {
    $bem = new Bem('foo');
    $result = $bem->block()->plusGlobal();
    $this->assertInstanceOf(OutputInterface::class, $result);
    $this->assertSame('foo bem', (string) $result);
  }

  public function testBlockJs() {
    $bem = new Bem('foo');
    $result = $bem->block()->js();
    $this->assertInstanceOf(OutputInterface::class, $result);
    $this->assertSame('js-foo', (string) $result);
  }

  public function testBlockPlusModifier() {
    $bem = new Bem('foo');
    $result = $bem->block()->plusModifier('has-image');
    $this->assertInstanceOf(PurposeInterface::class, $result);
    $this->assertSame('foo foo--has-image', (string) $result);
  }

  public function testBlockModifier() {
    $bem = new Bem('foo');
    $result = $bem->block()->modifier('has-image');
    $this->assertInstanceOf(PurposeInterface::class, $result);
    $this->assertSame('foo--has-image', (string) $result);
  }

  public function testElementPlusModifier() {
    $bem = new Bem('foo');
    $result = $bem->element('story')->plusModifier('has-image');
    $this->assertInstanceOf(PurposeInterface::class, $result);
    $this->assertSame('foo__story foo__story--has-image', (string) $result);
  }

  public function testElementModifier() {
    $bem = new Bem('foo');
    $result = $bem->element('story')->modifier('has-image');
    $this->assertInstanceOf(PurposeInterface::class, $result);
    $this->assertSame('foo__story--has-image', (string) $result);
  }

  public function testBlock() {
    $bem = new Bem('foo');
    $result = $bem->block();
    $this->assertInstanceOf(MiddleInterface::class, $result);
    $this->assertSame('foo', (string) $result);
  }

}
