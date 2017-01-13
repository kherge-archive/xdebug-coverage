[![Packagist](https://img.shields.io/packagist/v/kherge/xdebug-coverage.svg)](https://packagist.org/packages/kherge/xdebug-coverage)
[![Packagist Pre Release](https://img.shields.io/packagist/vpre/kherge/xdebug-coverage.svg)](https://packagist.org/packages/kherge/xdebug-coverage)

Xdebug Coverage
===============

Simplifies managing Xdebug code coverage.

Usage
-----

```php
use KHerGe\Xdebug\Coverage;

Coverage::ignore(
    function () {
        // set up database using very expensive process
    }
);
```

Installing
----------

    composer require kherge/xdebug-coverage
