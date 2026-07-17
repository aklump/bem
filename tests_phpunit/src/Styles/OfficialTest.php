<?php

namespace AKlump\Bem\Tests\Styles;

use AKlump\Bem\Styles\Official;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AKlump\Bem\Styles\Official
 */
class OfficialTest extends TestCase {

  /**
   * Provides data for testNormalizeElement.
   */
  public function commonDataProvider() {
    $tests = [];
    $tests[] = ['apple', '   apple   '];
    $tests[] = ['-apple-', '___---apple_-_-_'];
    $tests[] = ['-apple-', '_apple_'];
    $tests[] = ['foo-bar', 'foo@#$(*&bar'];
    $tests[] = ['section-2', 'section-2'];
    $tests[] = ['section2', 'section2'];
    $tests[] = ['foo-bar', 'foo-bar'];
    $tests[] = ['foo-bar', 'foo--bar'];
    $tests[] = ['foo-bar', 'foo_bar'];
    $tests[] = ['foo-bar', 'foo__bar'];
    $tests[] = ['foo', 'foo'];
    $tests[] = ['foo', 'FOO'];

    return $tests;
  }

  /**
   * @dataProvider commonDataProvider
   */
  public function testNormalizeBlock(string $control, string $subject) {
    $style = new Official();
    $this->assertSame($control, $style->normalizeBlock($subject));
  }

  /**
   * @dataProvider commonDataProvider
   */
  public function testNormalizeElement(string $control, string $subject) {
    $style = new Official();
    $this->assertSame($control, $style->normalizeElementStub($subject));
  }

  /**
   * @dataProvider commonDataProvider
   */
  public function testNormalizeModifier(string $control, string $subject) {
    $style = new Official();
    $this->assertSame($control, $style->normalizeModifierStub($subject));
  }

}
