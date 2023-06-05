<?php


namespace AKlump\Bem\Tests;

use AKlump\Bem\Bem;
use AKlump\Bem\BemInterface;
use PHPUnit\Framework\TestCase;
use AKlump\Bem\BemLegacy;

/**
 * @group extensions
 * @covers \AKlump\Bem\Bem
 */
final class BemLegacyTest extends TestCase {

  /**
   * Provides data for testTwoDashStyle.
   */
  public function dataForTestTwoDashStyleProvider() {
    $tests = [];
    $tests[] = ['lower', 'LoWEr'];
    $tests[] = ['foo-bar', 'foo_bar'];
    $tests[] = ['foo-bar', 'foo bar'];
    $tests[] = ['foo-bar', 'foo.bar'];
    $tests[] = ['foo-bar', 'foo-bar'];
    $tests[] = ['foo-bar', 'foo/bar'];
    $tests[] = ['foo-bar', 'foo__bar'];
    $tests[] = ['foo-bar', 'foo--bar'];

    return $tests;
  }

  /**
   * @dataProvider dataForTestTwoDashStyleProvider
   */
  public function testTwoDashStyle(string $control, string $subject) {
    $bem = new BemLegacy('chien');
    $this->assertSame($control, $bem->twoDashStyle($subject));
  }

  public function testBemElementWithGlobal() {
    $bem_legacy = new BemLegacy('chat');
    $bem = new Bem('chat');

    $result = explode(' ', $bem_legacy->bemElementWithGlobal('noir'));
    $this->assertContains('chat__noir', $result);
    $this->assertContains('bem__noir', $result);

    $result = explode(' ', $bem->bemElement('noir', BemInterface::GLOBAL));
    $this->assertContains('chat__noir', $result);
    $this->assertContains('bem__noir', $result);

    // JS option.
    $result = explode(' ', $bem_legacy->bemElementWithGlobal('noir', FALSE));
    $this->assertContains('chat__noir', $result);
    $this->assertContains('bem__noir', $result);

    $result = explode(' ', $bem_legacy->bemElementWithGlobal('noir', TRUE));
    $this->assertContains('js-chat__noir', $result);
    $this->assertContains('js-' . 'bem__noir', $result);
    $this->assertContains('chat__noir', $result);
    $this->assertContains('bem__noir', $result);

    $result = explode(' ', $bem->bemElement('noir', BemInterface::JS | BemInterface::GLOBAL));
    $this->assertContains('js-chat__noir', $result);
    $this->assertContains('js-' . 'bem__noir', $result);
    $this->assertContains('chat__noir', $result);
    $this->assertContains('bem__noir', $result);
  }

  public function testBemElementWithModifier() {
    $bem = new BemLegacy('vache');
    $this->assertSame('vache__noir vache__noir--grand', $bem->bemElementWithModifier('noir', 'grand'));
    $this->assertSame('vache__noir vache__noir--grand', $bem->bemElementWithModifier('noir', 'grand'), FALSE);
    $this->assertSame('vache__noir js-vache__noir vache__noir--grand js-vache__noir--grand', $bem->bemElementWithModifier('noir', 'grand', TRUE));
  }

  public function testBemModifier() {
    $bem = new BemLegacy('bravo');
    $this->assertSame('bravo--lorem', $bem->bemModifier('lorem'));

    // JS option.
    $this->assertSame('bravo--lorem', $bem->bemModifier('lorem', FALSE));
    $this->assertSame('bravo--lorem js-bravo--lorem', $bem->bemModifier('lorem', TRUE));

    // Clean option.
    $this->assertSame('bravo--lorem--ipsum__dolar', $bem->bemModifier('lorem--ipsum__dolar', FALSE, FALSE));
    $string = 'lorem--ipsum__dolar';
    $clean = $bem->cleanBem($string);
    $this->assertSame("bravo--$clean", $bem->bemModifier($string, FALSE, TRUE));
  }

  public function testBemJsElement() {
    $bem = new BemLegacy('alpha');
    $this->assertSame('js-alpha__bar', $bem->bemJsElement('bar'));
  }

  public function testBemElement() {
    $bem = new BemLegacy('foo');
    $this->assertSame('foo__bar', $bem->bemElement('bar'));

    // JS option.
    $this->assertSame('foo__bar', $bem->bemElement('bar', FALSE));
    $this->assertSame('foo__bar js-foo__bar', $bem->bemElement('bar', TRUE));

    // Clean option.
    $this->assertSame('foo__bar--baz__beef', $bem->bemElement('bar--baz__beef', FALSE, FALSE));
    $string = 'bar--baz__beef';
    $clean = $bem->cleanBem($string);
    $this->assertSame("foo__$clean", $bem->bemElement($string, FALSE, TRUE));
  }

  public function testBemJsBlock() {
    $bem = new BemLegacy('foo');
    $this->assertSame('js-foo', $bem->bemJsBlock());
  }

  public function testBemBlock() {
    $bem = new BemLegacy('foo');
    $this->assertSame('foo', $bem->bemBlock());
  }

  public function testCleanBem() {
    $bem = new BemLegacy('poulet');
    $this->assertSame('_foo-bar-is_lorem', $bem->cleanBem('__foo--bar-is_lorem'));
    $this->assertSame('_foo-bar-is_lorem', $bem->cleanBem('__foo bar.is_lorem'));
  }
}
