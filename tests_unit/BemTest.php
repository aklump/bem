<?php

namespace AKlump\Bem\Tests;

use AKlump\Bem\Bem;
use AKlump\Bem\BemInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AKlump\Bem\Bem
 */
final class BemTest extends TestCase {

  public function testSetGlobalBlockAffectsAllInstances() {
    $bem1 = new Bem('peanut');
    $this->assertSameClassStringAnyOrder('peanut bem', $bem1->bemBlock(BemInterface::GLOBAL));

    Bem::bemGlobalSetBlock('butter');
    $bem2 = new Bem('peanut');
    $this->assertSameClassStringAnyOrder('peanut butter', $bem1->bemBlock(BemInterface::GLOBAL));
    $this->assertSameClassStringAnyOrder('peanut butter', $bem2->bemBlock(BemInterface::GLOBAL));

    // Reset back to the default for other tests.
    Bem::bemGlobalSetBlock();
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

  public function testBemModifier() {
    $bem = new Bem('sandwich');
    $this->assertSameClassStringAnyOrder('sandwich--meet', $bem->bemModifier('meet'));
    $this->assertSameClassStringAnyOrder('sandwich--meet js-sandwich--meet', $bem->bemModifier('meet', BemInterface::JS));
    $this->assertSameClassStringAnyOrder('sandwich--meet bem--meet', $bem->bemModifier('meet', BemInterface::GLOBAL));
    $this->assertSameClassStringAnyOrder('sandwich--meet js-sandwich--meet bem--meet js-bem--meet', $bem->bemModifier('meet', BemInterface::GLOBAL | BemInterface::JS));
  }

  public function testBemElement() {
    $bem = new Bem('tree');
    $this->assertSameClassStringAnyOrder('tree__trunk', $bem->bemElement('trunk'));
    $this->assertSameClassStringAnyOrder('tree__trunk js-tree__trunk', $bem->bemElement('trunk', BemInterface::JS));
    $this->assertSameClassStringAnyOrder('tree__trunk bem__trunk', $bem->bemElement('trunk', BemInterface::GLOBAL));
    $this->assertSameClassStringAnyOrder('tree__trunk js-tree__trunk bem__trunk js-bem__trunk', $bem->bemElement('trunk', BemInterface::GLOBAL | BemInterface::JS));
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

  private function assertSameClassStringAnyOrder(string $expected_classes, $result) {
    $expected_classes = explode(' ', $expected_classes);
    $actual_classes = explode(' ', $result);
    $this->assertCount(count($expected_classes), $actual_classes);
    foreach ($expected_classes as $expected_class) {
      $this->assertContains($expected_class, $actual_classes);
    }
  }

}
