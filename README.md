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
