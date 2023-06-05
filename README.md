## Usage

Create a class instance using the BEM "block".

```php
$bem = new \AKlump\Bem\Bem('foo');
```

### Generate BEM Classes

```php
$bem->bemBlock(); // "foo"
$bem->bemElement('content'); // "foo__content"
$bem->bemModifier('has-image'); // "foo--has-image"
```

### w/Javascript Classes

```php
$bem->bemBlock(BemInterface::JS); // "foo js-foo"
$bem->bemElement('content', BemInterface::JS); // "foo__content js-foo__content"
$bem->bemModifier('has-image', BemInterface::JS); // "foo--has-image js-foo--has-image"
```

<https://getbem.com/>

## Styles

To alter the way the classes are formatted, create a new, custom class implementing `\AKlump\Bem\Styles\StyleInterface` for control of the processing and output of the classes, includign the division characters.

