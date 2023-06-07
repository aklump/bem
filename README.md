# BEM

BEM — is a methodology that helps you to create reusable components and code sharing in front‑end development

<https://getbem.com/>

## Stand-alone Usage

Create a class instance to represent your BEM model. Pass the "block" as the constructor argument.

```php
$bem = new \AKlump\Bem\Bem('foo');
```

### BEM Classes

```php
$bem->bemBlock(); // "foo"
$bem->bemElement('content'); // "foo__content"
$bem->bemModifier('has-image'); // "foo--has-image"
```

### + Javascript Classes

Use the `\AKlump\Bem\BemInterface::JS` option to any method to include `js-` classes. E.g.,

```php
$bem->bemBlock(\AKlump\Bem\BemInterface::JS); // "foo js-foo"
$bem->bemElement('content', \AKlump\Bem\BemInterface::JS); // "foo__content js-foo__content"
```

See `\AKlump\Bem\BemInterface` for all available options.

### Only Javascript Classes

```php
$bem->bemBlock(\AKlump\Bem\BemInterface::JS | \AKlump\Bem\BemInterface::NO_BASE); // "js-foo"
$bem->bemElement('content', \AKlump\Bem\BemInterface::JS | \AKlump\Bem\BemInterface::NO_BASE); // "js-foo__content"
```

### Modified Elements

```php
$bem->bemElementWithModifier('content', 'has-image'); // "foo__content foo__content--has-image"
$bem->bemElementWithModifier('content', 'has-image', \AKlump\Bem\BemInterface::NO_BASE); // "foo__content--has-image"
```

## Usage as a Class Trait

If you want to add the `bem*` methods to an existing class, you should use `\AKlump\Bem\BemTrait`. The `\AKlump\Bem\BemInterface` uses a `bem` prefix for all methods to allow clean integration with existing classes, to make them "BEM enabled".

## "Global" Innovation

This project provides a singular, global BEM instance that can be used to target common _elements_ for all blocks, at once. Refer to the example below. The `bem` and `bem__content` represent the _global block_ and _global element_, respectively. This innovation, in this case, allows you to target all three components' `content` in a single line of CSS. It can be thought of as a means of grouping.

```html
<section>
  <div class="story bem">
    <div class="story__content bem__content"></div>
  </div>
  <div class="film bem">
    <div class="film__content bem__content"></div>
  </div>
  <div class="copy bem">
    <div class="copy__content bem__content"></div>
  </div>
</section>
```

```css
.bem__content {
  width: 900px;
  margin: auto;
}
```

```php
$story = new \AKlump\Bem\Bem('story');
$film = new \AKlump\Bem\Bem('film');
$copy = new \AKlump\Bem\Bem('copy');

$story->bemElement('content', \AKlump\Bem\BemInterface::GLOBAL); // "story__content bem__content"
$film->bemElement('content', \AKlump\Bem\BemInterface::GLOBAL); // "film__content bem__content"
$copy->bemElement('content', \AKlump\Bem\BemInterface::GLOBAL); // "copy__content bem__content"
```

**The default global block is `bem`, however you can override that by using `Bem::bemGlobalSetBlock('foo')`.**

## Fluent Interface

The examples above have been rewritten using the `\AKlump\Bem\FluentBem` class, which is also included in this package.

```php
$bem = new \AKlump\Bem\FluentBem('foo');
(string) $bem->block(); // "foo"
(string) $bem->element('content'); // "foo__content"
(string) $bem->block()->modifier('has-image'); // "foo--has-image"

(string) $bem->block()->and()->js(); // "foo js-foo"
(string) $bem->element('content')->and()->js(); // "foo__content js-foo__content"

(string) $bem->block()->js(); // "js-foo"
(string) $bem->element('content')->js(); // "js-foo__content"

(string) $bem->element('content')->and()->modifier('has-image'); // "foo__content foo__content--has-image"
(string) $bem->element('content')->modifier('has-image'); // "foo__content--has-image"
```

## Customizing Output Style

To alter the way the classes are formatted, create a new, custom class implementing `\AKlump\Bem\Styles\StyleInterface` for control of the processing and output of the classes, including the division characters. Look to `\AKlump\Bem\Styles\Official` for a model.

## Usage With Twig

```html
{{ bem_set_global_block('component') }}
{{ bem_set_block('story-section') }}
<section>
  <div class="{{ bem_block().and().js().and().modifier('th-summary').and().modifier('lang-en') }}">
      <div class="{{ bem_element('width').and().global() }}">
      <div class="{{ bem_element('item').and().modifier('first') }}"></div>
      <div class="{{ bem_element('item') }}"></div>
      <div class="{{ bem_element('item').and().modifier('last') }}"></div>
    </div>
  </div>
</section>

<section>
  <div class="story-section js-story-section story-section--th-summary story-section--lang-en">
    <div class="story-section__width bem__width">
      <div class="story-section__item story-section__item--first"></div>
      <div class="story-section__item"></div>
      <div class="story-section__item story-section__item--last"></div>
    </div>
  </div>
</section>
```

## Contributing

If you find this project useful... please consider [making a donation](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4E5KZHDQCEUV8&item_name=Gratitude%20for%20aklump%2Fbem).


