<?php

namespace AKlump\Bem\Tests;

use AKlump\Bem\FluentBem;
use AKlump\Bem\Tests\TestTraits\AssertTrait;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AKlump\Bem\FluentBem
 */
class FluentBemTest extends TestCase {

  use AssertTrait;

  public function testElementToArrayThenBlockDoesNotThrow() {
    $bem = new FluentBem('voce');
    $this->assertSame(['voce'], $bem->block()->toArray());
    $this->assertSame(['voce__mio'], $bem->element('mio')->toArray());
  }

  public function testElementToStringThenBlockDoesNotThrow() {
    $bem = new FluentBem('voce');
    $this->assertSame('voce', (string) $bem->block());
    $this->assertSame('voce__mio', (string) $bem->element('mio'));
  }

  public function testElementChainedToBlockThrows() {
    $bem = new FluentBem('voce');
    $this->expectException(\RuntimeException::class);
    $bem->block()->element('mio');
  }

  public function testBlockChainedToElementThrows() {
    $bem = new FluentBem('voce');
    $this->expectException(\RuntimeException::class);
    $bem->element('mio')->block();
  }

  public function testToArray() {
    $bem = new FluentBem('kingdom');
    $result = $bem->element('power')->and()->modifier('glory')->toArray();
    $this->assertCount(2, $result);
    $this->assertContains('kingdom__power', $result);
    $this->assertContains('kingdom__power--glory', $result);
  }

  public function testElementGlobal() {
    $bem = new FluentBem('foo');
    $result = $bem->element('bar')->global();
    $this->assertSameClassStringAnyOrder('bem__bar', $result);
  }

  public function testBlockGlobal() {
    $bem = new FluentBem('foo');
    $result = $bem->block()->global();
    $this->assertSameClassStringAnyOrder('bem', $result);
  }

  public function testBlockAndGlobal() {
    $bem = new FluentBem('foo');
    $result = $bem->block()->and()->global();
    $this->assertSameClassStringAnyOrder('foo bem', $result);
  }

  public function testBlockAndJsAndGlobalAndJs() {
    $bem = new FluentBem('foo');
    $result = $bem->block()->and()->js()->and()->global()->and()->js();
    $this->assertSameClassStringAnyOrder('foo js-foo bem js-bem', $result);
  }

  public function testChainedModifiersWithAndSyntax() {
    $bem = new FluentBem('foo');
    $result = $bem->block()
      ->modifier('bar')
      ->and()
      ->modifier('baz')
      ->and()
      ->modifier('alpha');
    $this->assertSameClassStringAnyOrder('foo--bar foo--baz foo--alpha', $result);
  }

  public function testChainedModifiersWithAndSyntaxJs() {
    $bem = new FluentBem('foo');
    $result = $bem->block()
      ->modifier('bar')
      ->js()
      ->and()
      ->modifier('baz')
      ->js()
      ->and()
      ->modifier('alpha')
      ->js();
    $this->assertSameClassStringAnyOrder('js-foo--bar js-foo--baz js-foo--alpha', $result);
  }

  public function testChainedModifiersWithoutAndSyntax() {
    $bem = new FluentBem('foo');
    $result = $bem->block()
      ->modifier('bar')
      ->modifier('baz')
      ->modifier('alpha');
    $this->assertSameClassStringAnyOrder('foo--bar foo--baz foo--alpha', $result);
  }

  public function testChainedModifiersWithoutAndSyntaxJs() {
    $bem = new FluentBem('foo');
    $result = $bem->block()
      ->modifier('bar')
      ->modifier('baz')
      ->modifier('alpha')
      ->js();
    $this->assertSameClassStringAnyOrder('js-foo--bar js-foo--baz js-foo--alpha', $result);
  }

  public function testTwigExample() {
    $bem = new FluentBem('story-section');
    $bem->setGlobalBlock('component');
    $result = $bem->block()
      ->and()
      ->js()
      ->and()
      ->modifier('th-summary')
      ->and()
      ->modifier('lang-en');
    $this->assertSameClassStringAnyOrder('story-section js-story-section story-section--th-summary story-section--lang-en', $result);

    $result = $bem->element('width')->and()->global();
    $this->assertSameClassStringAnyOrder('story-section__width component__width', $result);

    $result = $bem->element('item')->and()->modifier('first');
    $this->assertSameClassStringAnyOrder('story-section__item story-section__item--first', $result);

    $result = $bem->element('item');
    $this->assertSameClassStringAnyOrder('story-section__item', $result);

    $result = $bem->element('item')->and()->modifier('last');
    $this->assertSameClassStringAnyOrder('story-section__item story-section__item--last', $result);
  }

  public function testBlockAndModifier() {
    $bem = new FluentBem('alpha');
    $result = $bem->block()->and()->modifier('apple');
    $this->assertSameClassStringAnyOrder('alpha alpha--apple', $result);
  }

  public function testBlockJsAndModifier() {
    $bem = new FluentBem('alpha');
    $result = $bem->block()->js()->and()->modifier('apple');
    $this->assertSameClassStringAnyOrder('js-alpha alpha--apple', $result);
  }

  public function testBlockJsAndModifierJs() {
    $bem = new FluentBem('alpha');
    $result = $bem->block()->js()->and()->modifier('apple')->js();
    $this->assertSameClassStringAnyOrder('js-alpha js-alpha--apple', $result);
  }

  public function testBlockAndJsAndModifierAndJs() {
    $bem = new FluentBem('alpha');
    $result = $bem->block()->and()->js()->and()->modifier('apple')->and()->js();
    $this->assertSameClassStringAnyOrder('alpha js-alpha alpha--apple js-alpha--apple', $result);
  }

  public function testBlockAndModifierJs() {
    $bem = new FluentBem('alpha');
    $result = $bem->block()->and()->modifier('apple')->js();
    $this->assertSameClassStringAnyOrder('alpha alpha--apple js-alpha--apple', $result);
  }

  public function testBlockModifierJs() {
    $bem = new FluentBem('alpha');
    $result = $bem->block()->modifier('apple')->js();
    $this->assertSameClassStringAnyOrder('js-alpha--apple', $result);
  }

  public function testBlockModifier() {
    $bem = new FluentBem('alpha');
    $result = $bem->block()->modifier('apple');
    $this->assertSameClassStringAnyOrder('alpha--apple', $result);
  }

  public function testElementAndJs() {
    $bem = new FluentBem('foo');
    $this->assertSameClassStringAnyOrder('foo__bar js-foo__bar', $bem->element('bar')
      ->and()
      ->js());
  }

  public function testElementAndJsAndModifierAndJs() {
    $bem = new FluentBem('foo');
    $result = $bem->element('bar')
      ->and()
      ->js()
      ->and()
      ->modifier('apple')
      ->and()
      ->js();
    $this->assertSameClassStringAnyOrder('foo__bar js-foo__bar foo__bar--apple js-foo__bar--apple', $result);
  }

  public function testElementAndModifier() {
    $bem = new FluentBem('alpha');
    $result = $bem->element('foo')->and()->modifier('apple');
    $this->assertSameClassStringAnyOrder('alpha__foo alpha__foo--apple', $result);
  }

  public function testElementModifier() {
    $bem = new FluentBem('alpha');
    $result = $bem->element('foo')->modifier('apple');
    $this->assertSameClassStringAnyOrder('alpha__foo--apple', $result);
  }

  public function testElementModifierJs() {
    $bem = new FluentBem('alpha');
    $result = $bem->element('foo')->modifier('apple')->js();
    $this->assertSameClassStringAnyOrder('js-alpha__foo--apple', $result);
  }

  public function testElementAndModifierJs() {
    $bem = new FluentBem('alpha');
    $result = $bem->element('foo')->and()->modifier('apple')->js();
    $this->assertSameClassStringAnyOrder('alpha__foo js-alpha__foo--apple', $result);
  }

  public function testElementJsAndModifier() {
    $bem = new FluentBem('alpha');
    $result = $bem->element('foo')->js()->and()->modifier('apple');
    $this->assertSameClassStringAnyOrder('js-alpha__foo alpha__foo--apple', $result);
  }

  public function testElementJsAndModifierJs() {
    $bem = new FluentBem('alpha');
    $result = $bem->element('foo')->js()->and()->modifier('apple')->js();
    $this->assertSameClassStringAnyOrder('js-alpha__foo js-alpha__foo--apple', $result);
  }

  public function testElementJs() {
    $bem = new FluentBem('foo');
    $this->assertSameClassStringAnyOrder('js-foo__bar', $bem->element('bar')
      ->js());
  }

  public function testElement() {
    $bem = new FluentBem('foo');
    $this->assertSameClassStringAnyOrder('foo__bar', $bem->element('bar'));
  }

  public function testBlockAndJs() {
    $bem = new FluentBem('foo');
    $result = $bem->block()->and()->js();
    $this->assertSameClassStringAnyOrder('foo js-foo', $result);
  }

  public function testBlockJs() {
    $bem = new FluentBem('foo');
    $result = $bem->block()->js();
    $this->assertSameClassStringAnyOrder('js-foo', $result);
  }

  public function testBlock() {
    $bem = new FluentBem('foo');
    $this->assertSameClassStringAnyOrder('foo', $bem->block());
  }

  public function testToStringReturnsEmpty() {
    $bem = new FluentBem();
    $this->assertSameClassStringAnyOrder('', $bem);
    $bem->setBlock('foo');
    $this->assertSameClassStringAnyOrder('', $bem);
  }

}
