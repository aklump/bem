<?php

namespace AKlump\Bem\Tests\Legacy;

use AKlump\Bem\Legacy\Bem;
use AKlump\Bem\Legacy\BemInterface;
use AKlump\Bem\Tests\AssertTrait;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AKlump\Bem\Legacy\Bem
 */
final class BemTest extends TestCase {

  use AssertTrait;

  public function testBemGlobalSetBlockIsPerInstanceOnly() {
    $bem = new Bem('foo');
    $bem->bemGlobalSetBlock('element');
    $this->assertSameClassStringAnyOrder('foo element', $bem->bemBlock(BemInterface::GLOBAL));
    $bem = new Bem('foo');
    $this->assertSameClassStringAnyOrder('foo bem', $bem->bemBlock(BemInterface::GLOBAL));
  }

  public function testBemGlobalSetBlockAffectsClasses() {
    $bem = new Bem('foo');
    $bem->bemGlobalSetBlock('element');
    $this->assertSameClassStringAnyOrder('foo element', $bem->bemBlock(BemInterface::GLOBAL));
  }

  public function testElementWithModifierAndGlobalAndJsOptions() {
    $bem = new Bem('cookie');
    $result = $bem->bemElementWithModifier('dough', 'uncooked', BemInterface::GLOBAL | BemInterface::JS);
    $this->assertSameClassStringAnyOrder('cookie__dough bem__dough js-cookie__dough js-bem__dough cookie__dough--uncooked bem__dough--uncooked js-cookie__dough--uncooked js-bem__dough--uncooked', $result);
  }

  public function testElementWithModifierWithGlobalOption() {
    $bem = new Bem('cookie');
    $result = $bem->bemElementWithModifier('dough', 'uncooked', BemInterface::GLOBAL);
    $this->assertSameClassStringAnyOrder('cookie__dough bem__dough cookie__dough--uncooked bem__dough--uncooked', $result);
  }

  public function testElementWithModifierWithJsOption() {
    $bem = new Bem('cookie');
    $result = $bem->bemElementWithModifier('dough', 'uncooked', BemInterface::JS);
    $this->assertSameClassStringAnyOrder('cookie__dough js-cookie__dough cookie__dough--uncooked js-cookie__dough--uncooked', $result);
  }

  public function testElementWithModifierNoBase() {
    $bem = new Bem('cookie');
    $result = $bem->bemElementWithModifier('dough', 'uncooked', BemInterface::NO_BASE);
    $this->assertSameClassStringAnyOrder('cookie__dough--uncooked', $result);
  }

  public function testElementWithModifierNoOptions() {
    $bem = new Bem('cookie');
    $result = $bem->bemElementWithModifier('dough', 'uncooked');
    $this->assertSameClassStringAnyOrder('cookie__dough cookie__dough--uncooked', $result);
  }

  public function testBemGlobal() {
    $bem = new Bem('flower');
    $this->assertInstanceOf(BemInterface::class, $bem->bemGlobal());
    $this->assertSameClassStringAnyOrder('bem', $bem->bemGlobal()->bemBlock());
  }

  public function testBemModifierWithNoBaseOptionThrows() {
    $this->expectException(\InvalidArgumentException::class);
    $bem = new Bem('foo');
    $bem->bemModifier('bar', BemInterface::NO_BASE);
  }

  public function testBemModifier() {
    $bem = new Bem('sandwich');
    $this->assertSameClassStringAnyOrder('sandwich--meet', $bem->bemModifier('meet'));
    $this->assertSameClassStringAnyOrder('sandwich--meet js-sandwich--meet', $bem->bemModifier('meet', BemInterface::JS));
    $this->assertSameClassStringAnyOrder('sandwich--meet bem--meet', $bem->bemModifier('meet', BemInterface::GLOBAL));
    $this->assertSameClassStringAnyOrder('sandwich--meet js-sandwich--meet bem--meet js-bem--meet', $bem->bemModifier('meet', BemInterface::GLOBAL | BemInterface::JS));
    $this->assertSameClassStringAnyOrder('sandwich--meet js-sandwich--meet bem--meet js-bem--meet', $bem->bemModifier('meet', BemInterface::GLOBAL | BemInterface::JS));
  }

  public function testBemElementWithNoBaseOptionThrows() {
    $this->expectException(\InvalidArgumentException::class);
    $bem = new Bem('foo');
    $bem->bemElement('bar', BemInterface::NO_BASE);
  }

  public function testBemElement() {
    $bem = new Bem('tree');
    $this->assertSameClassStringAnyOrder('tree__trunk', $bem->bemElement('trunk'));
    $this->assertSameClassStringAnyOrder('tree__trunk js-tree__trunk', $bem->bemElement('trunk', BemInterface::JS));
    $this->assertSameClassStringAnyOrder('tree__trunk bem__trunk', $bem->bemElement('trunk', BemInterface::GLOBAL));
    $this->assertSameClassStringAnyOrder('tree__trunk js-tree__trunk bem__trunk js-bem__trunk', $bem->bemElement('trunk', BemInterface::GLOBAL | BemInterface::JS));
  }

  public function testBemBlockWithNoBaseOptionThrows() {
    $this->expectException(\InvalidArgumentException::class);
    $bem = new Bem('foo');
    $bem->bemBlock(BemInterface::NO_BASE);
  }

  public function testBemBlock() {
    $bem = new Bem('fish');
    $this->assertSameClassStringAnyOrder('fish', $bem->bemBlock());

    $bem = new Bem('fish');

    $this->assertSameClassStringAnyOrder('fish', $bem->bemBlock());
    $this->assertSameClassStringAnyOrder('fish js-fish', $bem->bemBlock(BemInterface::JS));

    // Javascript only class
    $this->assertSameClassStringAnyOrder('js-fish', $bem->bemBlock(BemInterface::JS | BemInterface::NO_BASE));

    // Add the global instance.
    $this->assertSameClassStringAnyOrder('fish bem', $bem->bemBlock(BemInterface::GLOBAL));
    $this->assertSameClassStringAnyOrder('fish js-fish bem js-bem', $bem->bemBlock(BemInterface::GLOBAL | BemInterface::JS));
  }


}
