<?php

namespace AKlump\Bem\Tests\Styles;

use AKlump\Bem\Styles\OfficialPassThrough;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AKlump\Bem\Styles\OfficialPassThrough()
 */
class OfficialPassThroughTest extends TestCase {

  /**
   * Provides data for testNormalizeElement.
   */
  public function commonDataProvider() {
    $tests = [];
    $tests[] = ['apple', '   apple   '];
    $tests[] = ['___---apple_-_-_', '___---apple_-_-_'];
    $tests[] = ['_apple_', '_apple_'];
    $tests[] = ['foo@#$(*&bar', 'foo@#$(*&bar'];
    $tests[] = ['section-2', 'section-2'];
    $tests[] = ['section2', 'section2'];
    $tests[] = ['foo-bar', 'foo-bar'];
    $tests[] = ['foo--bar', 'foo--bar'];
    $tests[] = ['foo_bar', 'foo_bar'];
    $tests[] = ['foo__bar', 'foo__bar'];
    $tests[] = ['foo', ' foo'];
    $tests[] = ['fooBar', 'fooBar '];
    $tests[] = ['FOO', 'FOO'];

    return $tests;
  }

  /**
   * @dataProvider commonDataProvider
   */
  public function testNormalizeBlock(string $control, string $subject) {
    $style = new OfficialPassThrough();
    $this->assertSame($control, $style->normalizeBlock($subject));
  }

  /**
   * @dataProvider commonDataProvider
   */
  public function testNormalizeElement(string $control, string $subject) {
    $style = new OfficialPassThrough();
    $this->assertSame($control, $style->normalizeElementStub($subject));
  }

  /**
   * @dataProvider commonDataProvider
   */
  public function testNormalizeModifier(string $control, string $subject) {
    $style = new OfficialPassThrough();
    $this->assertSame($control, $style->normalizeModifierStub($subject));
  }

}
