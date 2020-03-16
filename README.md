# Laravel Stock

[![Latest Version on Packagist](https://img.shields.io/packagist/v/appstract/laravel-stock.svg?style=flat-square)](https://packagist.org/packages/appstract/:package_name)
[![Total Downloads](https://img.shields.io/packagist/dt/appstract/laravel-stock.svg?style=flat-square)](https://packagist.org/packages/appstract/:package_name)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/appstract/laravel-stock/master.svg?style=flat-square)](https://travis-ci.org/appstract/:package_name)

Keep stock for Eloquent models. This package will track stock mutations for your models. You can increase, decrease, clear and set stock. It's also possible to check if a model is in stock (on a certain date/time).

## Installation

You can install the package via composer:

``` bash
composer require appstract/laravel-stock
```

Run `php artisan migrate` to migrate the table. There will now be a `stock_mutations` table in your database.

## Usage

Adding the `HasStock` trait will enable stock functionality on the Model.

``` php
use Appstract\Stock\HasStock;

class Book extends Model
{
    use HasStock;
}
```

Basic mutations on stock:

```php
$book->increaseStock(10);
$book->decreaseStock(10);
$book->mutateStock(10);
$book->mutateStock(-10);
```

Clearing stock. It's also possible to clear the stock and directly setting a new value.

```php
$book->clearStock();
$book->clearStock(10);
```

Setting stock. It is possible to set stock. This will create a new mutation with the difference between the old and new value.

```php
$book->setStock(10);
```

It's also possible to check if a product is in stock (with a minimal value).

```php
$book->inStock();
$book->inStock(10);
```

Get the current stock value (on a certain date).

```php
$book->stock;
$book->stock(Carbon::now()->subDays(10));
```

Add a description and/or reference model to de StockMutation.

```php
$book->increaseStock(10, [
    'description' => 'This is a description',
    'reference' => $otherModel,
]);
```

## Testing

``` bash
composer test
```

## Contributing

Contributions are welcome, [thanks to y'all](https://github.com/appstract/laravel-stock/graphs/contributors) :)

## About Appstract

Appstract is a small team from The Netherlands. We create (open source) tools for Web Developers and write about related subjects on [Medium](https://medium.com/appstract). You can [follow us on Twitter](https://twitter.com/appstractnl), [buy us a beer](https://www.paypal.me/appstract/10) or [support us on Patreon](https://www.patreon.com/appstract).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
