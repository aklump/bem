# BEM

BEM — is a methodology that helps you to create reusable components and code sharing in front‑end development

<https://getbem.com/>

## Usage

Create a class instance to represent your BEM model. Pass the "block" as the constructor argument.

```php
$bem = new \AKlump\Bem\Fluent\Bem('foo');
```

All methods return an object instance that can be typecast to a string. Or, you can also call `toString()` or `toArray()` as appropriate; see `\AKlump\Bem\Fluent\Interfaces\OutputInterface` for details. All of the following produce the same output.

```
(string) $bem->block(); // foo
strval($bem->block()); // foo
$bem->block()->toString(); // foo
```

For simplicity any remaining examples will show only the first form.

### The Basic Four

```php
(string) $bem->block(); // "foo"
(string) $bem->element('content'); // "foo__content"
(string) $bem->block()->modifier('has-image'); // "foo--has-image"
(string) $bem->element()->modifier('content', 'has-image'); // "foo__content--has-image"
```

### For Javascript Purposes

```php
(string) $bem->block()->js(); // "js-foo"
(string) $bem->element('content')->js(); // "js-foo__content"
```

### Convenience Syntax

There are some conveniences you should take note of; pay special attention to the `plus*` methods.

```php
// In both cases "foo js-foo" === $classes.
$classes = $bem->block() . ' ' . $bem->block()-js();
$classes = $bem->block()->plusJs();

// In both cases "foo foo--bar" === $classes.
$classes = $bem->block() . ' ' . $bem->block()->modifier('bar);
$classes = $bem->block()->plusModifier('bar);

// In both cases "foo foo--bar js-foo js-foo--bar" === $classes.
$classes = implode(' ', [
  $bem->block(),
  $bem->block()->modifier('bar),
  $bem->block()->js(),
  $bem->block()->modifier('bar)->js(),
]);
  
$classes = $bem->block()->plusModifier('bar)->plusJs()
```

## "Global" Innovation

You'll find an innovation in this project called _global_. It can be used to target common parts across all blocks at once. Refer to the example below where `component` and `component__content` represent the _global block_ and _global element_, respectively. This innovation, in this case, allows you to target all three components' `content` in a single line of CSS. It can be thought of as a means of grouping. Use the the `plusGlobal()` method for this feature.

```html
<section>
  <div class="story component">
    <div class="story__content component__content"></div>
  </div>
  <div class="film component">
    <div class="film__content component__content"></div>
  </div>
  <div class="copy component">
    <div class="copy__content component__content"></div>
  </div>
</section>
```

```css
.component__content {
  width: 900px;
  margin: auto;
}
```

```php
$story = new \AKlump\Bem\Fluent\Bem('story', 'component');
$film = new \AKlump\Bem\Fluent\Bem('film', 'component');
$copy = new \AKlump\Bem\Fluent\Bem('copy', 'component');

$story->element('content')->plusGlobal(); // "story__content component__content"
$film->element('content')->plusGlobal(); // "film__content component__content"
$copy->element('content')->plusGlobal(); // "copy__content component__content"
```

### Casting to Array

Given a complex chain as shown next, you can see the helpfulness of the `plus*` methods and why you might want to use the `toArray()` method.

```php
$bem = new \AKlump\Bem\Fluent\Bem('foo', 'components');
$classes = $bem->element('content')
  ->plusModifier('first')
  ->plusGlobal()
  ->plusJs()
  ->toArray();

$classes === [
  'foo__content',
  'foo__content--first',
  'js-foo__content',
  'js-foo__content--first',
  'js-components__content',
  'js-components__content--first',
  'components__content',
  'components__content--first',
];
```

## Customizing Output Style

To alter the way the classes are formatted, create a new, custom class implementing `\AKlump\Bem\Styles\StyleInterface` for control of the processing and output of the classes, including the division characters. Look to `\AKlump\Bem\Styles\Official` for a model. Pass your custom style to `\AKlump\Bem\Fluent\Bem` when constructing.

## Usage With Twig

### Themers

```html
{{ bem_set_global('component') }}
{{ bem_set_block('story-section') }}
<body>
<h1>Twig Extension Example</h1>

<pre>
{% set classes = [
  bem_block().plus_js(),
  bem_block().modifier('th-summary'),
  bem_block().modifier('lang-en'),
] %}
&lt;section>
  &ltdiv class="{{ classes|join(' ') }}">
    &lt;div class="{{ bem_element('width').plus_global() }}">
      &lt;div class="{{ bem_element('item').plus_modifier('first') }}">&lt;/div>
      &lt;div class="{{ bem_element('item') }}">&lt;/div>
      &lt;div class="{{ bem_element('item').plus_modifier('last') }}">&lt;/div>
    &lt;/div>
  &lt;/div>
&lt;/section>
</pre>
</body>

<section>
  <div class="story-section js-story-section story-section--th-summary story-section--lang-en">
    <div class="story-section__width component__width">
      <div class="story-section__item story-section__item--first"></div>
      <div class="story-section__item"></div>
      <div class="story-section__item story-section__item--last"></div>
    </div>
  </div>
</section>
```

### Developers

See `\AKlump\Bem\Twig\BemExtension`

## Contributing

If you find this project useful... please consider [making a donation](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4E5KZHDQCEUV8&item_name=Gratitude%20for%20aklump%2Fbem).

## Similar Packages

* https://packagist.org/packages/widoz/bem
* https://packagist.org/packages/pixo/bem
