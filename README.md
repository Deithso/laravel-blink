# Cache that expires in the blink of an eye

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-blink.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-blink)
[![Build Status](https://img.shields.io/travis/spatie/laravel-blink/master.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-blink)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-blink.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-blink)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-blink.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-blink)

This package contains a helper function (and a Facade should you prefer that) called `blink` that can cache values. The cache only spans the length of a single request.

```php
blink()->put('key', 'value');

blink()->get('key'); // Returns 'value'
blink()->get('prefix*'); // Returns an array of values whose keys start with 'prefix'

// once will only execute the given callable if the given key didn't exist yet
// once will only execute the given callable if the given key didn't exist yet
$expensiveFunction = function() {
   return rand();
});
blink()->once('random', $expensiveFunction); // returns random number
blink()->once('random', $expensiveFunction); // returns the same number

blink()->has('key'); // Returns true
blink()->has('prefix*'); // Returns true if the blink contains contains a key that starts with 'prefix'

// Specify a default value for when the specified key does not exist
blink()->get('non existing key', 'default') // Returns 'default'

blink()->put('anotherKey', 'anotherValue');

// Put multiple items in one go
blink()->put(['ringo' => 'drums', 'paul' => 'bass']);

blink()->all(); // Returns an array with all items

blink()->forget('key'); // Removes the item
blink()->forget('prefix*'); // Forget all items of which the key starts with 'prefix'

blink()->flush(); // Empty the entire blink

blink()->flushStartingWith('somekey'); // Remove all items whose keys start with "somekey"

blink()->increment('number'); // blink()->get('key') will return 1 
blink()->increment('number'); // blink()->get('key') will return 2
blink()->increment('number', 3); // blink()->get('key') will return 5

// Blink implements ArrayAccess
blink()['key'] = 'value';
blink()['key']; // Returns 'value'
isset(blink()['key']); // Return true
unset(blink()['key']); // Equivalent to removing the value

// Blink implements Countable
count(blink()); // Returns 0
blink()->put('key', 'value');
count(blink()); // Returns 1
```

## Postcardware

You're free to use this package (it's [MIT-licensed](LICENSE.md)), but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-blink
```

To enable the package, register the serviceprovider, and optionally register the facade:

```php
// config/app.php

'providers' => [
    // ...
    Spatie\LaravelBlink\BlinkServiceProvider::class,
],

'aliases' => [
    ...
    'Blink' => Spatie\LaravelBlink\Blink\BlinkFacade::class,
],
```



## Usage

A `Blink` instance can just be newed up.

```php
$blink = new \Spatie\Blink\Blink()
```

You can call the following methods on it:

### put
```php
/**
 * Put a value in the blink cache.
 *
 * @param string|array $name
 * @param string|int|null $value
 * 
 * @return $this
 */
public function put($name, $value = null)
```

### get

```php
/**
 * Get a value from the blink cache.
 *
 * This function has support for the '*' wildcard.
 *
 * @param string $name
 *
 * @return null|string
 */
public function get(string $name)
```

### has

```php
/*
 * Determine if the blink cache has a value for the given name.
 *
 * This function has support for the '*' wildcard.
 */
public function has(string $name) : bool
```

### once

```php
/**
 * Only if the given key is not present in the blink cache the callable will be executed.
 * 
 * The result of the callable will be stored in the given key and returned.
 * 
 * @param $key
 * @param callable $callable
 *
 * @return mixed
 */
```

You can use this to avoid using static variables to cache stuff.

This piece of code

```php
function foo()
{
    static $result = null;
    
    if (is_null($result) {
        $result = ...// do some expensive stuff here
    }
    
    return $result;
}
```

can be rewritten to

```php
function foo()
{
    return blink()->once('fooCache', function() {
       return ... // do some expensive stuff here
    });
}
```

### all
```php
/*
* Get all values in the blink cache.
*/
public function all() : array
```

### forget
```php
/**
 * Forget a value from the blink cache.
 *
 * This function has support for the '*' wildcard.
 *
 * @param string $key
 *
 * @return $this
 */
public function forget(string $key)
```

### flush
```php
/**
 * Flush all values from the blink cache.
 *
 * @return $this
 */
 public function flush()
```

### pull
```php
/**
 * Get and forget a value from the blink cache.
 *
 * This function has support for the '*' wildcard.
 *
 * @param string $name 
 *
 * @return null|string
 */
public function pull(string $name)
```

### increment
```php
/**
 * Increment a value from the blink cache.
 *
 * @param string $name
 * @param int $by
 *
 * @return int|null|string
 */
 public function increment(string $name, int $by = 1)
```

### decrement
```php
/**
 * Decrement a value from the blink cache.
 *
 * @param string $name
 * @param int $by
 *
 * @return int|null|string
 */
 public function decrement(string $name, int $by = 1)
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## About Spatie

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
