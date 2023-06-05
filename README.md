## Stand-alone Usage

Create a class instance to represent your BEM model. Pass the "block" as the constructor argument.

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

## Usage as a Class Trait

If you want to add the `bem*` methods to an existing class, you should use `\AKlump\Bem\BemTrait`. The `\AKlump\Bem\BemInterface` uses a `bem` prefix for all methods to allow clean integration with existing classes, to make them "BEM enabled".

## Learn More

<https://getbem.com/>

## Customizing Output Style

To alter the way the classes are formatted, create a new, custom class implementing `\AKlump\Bem\Styles\StyleInterface` for control of the processing and output of the classes, including the division characters. Look to `\AKlump\Bem\Styles\Official` for a model.

