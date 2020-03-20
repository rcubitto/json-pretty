# JSON Pretty Print

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rcubitto/json-pretty.svg?style=flat-square)](https://packagist.org/packages/rcubitto/json-pretty)
[![Build Status](https://img.shields.io/travis/rcubitto/json-pretty/master.svg?style=flat-square)](https://travis-ci.org/rcubitto/json-pretty)
[![Quality Score](https://img.shields.io/scrutinizer/g/rcubitto/json-pretty.svg?style=flat-square)](https://scrutinizer-ci.com/g/rcubitto/json-pretty)
[![Total Downloads](https://img.shields.io/packagist/dt/rcubitto/json-pretty.svg?style=flat-square)](https://packagist.org/packages/rcubitto/json-pretty)

JSON Pretty is a very simple library that prints a JSON array in full color with proper indentation.

## Installation

You can install the package via composer:

```bash
composer require rcubitto/json-pretty
```

## Usage

You can print any array, both sequencial and associate.

``` php
\Rcubitto\JsonPretty\JsonPretty::print([
    'store' => 'Best Buy',
    'number' => 30305,
    'products' => [
        [
            'name' => 'TV',
            'cost' => 2000.00,
            'in_stock' => true
        ],
        [
            'name' => 'Phone',
            'cost' => 350.80,
            'in_stock' => false
        ],
        [
            'name' => 'Sample',
            'cost' => 0,
            'in_stock' => null
        ]
    ]
]);

```

The previous snippet will print the following:

![Print output](https://raw.githubusercontent.com/rcubitto/json-pretty/master/print-example-one.png?token=AARLMXW34PBRSGY4GRCWHGS6PWVZ2)

You can also print an object class:

```php
$obj = new \Stdclass;
$obj->prop = 1;
$obj->another = 2;

\Rcubitto\JsonPretty\JsonPretty::print($obj);
```

Output:

![Print output](https://raw.githubusercontent.com/rcubitto/json-pretty/master/print-example-two.png?token=AARLMXXFQXV6NZ3DO5XC2UC6PWWOA)


### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email rcubitto@gmail.com instead of using the issue tracker.

## Credits

- [Raúl Cubitto](https://github.com/rcubitto)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## PHP Package Boilerplate

This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com).
