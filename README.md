# Laravel Webshop Product

This package provides a modular way to manage products for your Laravel webshop. It is designed to be simple, extendable, and easily integrated into existing Laravel projects.

---

## Features

- Product model with Eloquent support
- Easy CRUD operations for products
- Migration and configuration publishing
- Extendable for custom features

---

## Installation

Require the package via Composer:

```bash
composer require veiliglanceren/laravel-webshop-product
```

---

## Publish Assets

To publish configuration, migrations, and other assets:

```bash
php artisan vendor:publish --provider="VeiligLanceren\LaravelWebshopProduct\ProductServiceProvider"
```

---

## Database Migration

Run the migrations to create the necessary tables:

```bash
php artisan migrate
```

---

## Usage

### Product Model

Use the provided `Product` model directly or extend it:

```php
use VeiligLancerenNl\LaravelWebshopProduct\Models\Product;

$products = Product::all();
```

### CRUD Example

```php
// Create
$product = Product::create([
    'name' => 'Example Product',
    'price' => 99.99,
    'sky' => 'example-product'
]);

// Read
$product = Product::find(1);

// Update
$product->update([
    'price' => 89.99,
]);

// Delete
$product->delete();
```

---

## Extending Functionality

You can extend the `Product` model or override views, controllers, and routes to fit your webshop needs.

---

## Configuration

If you published the config file, you can customize package settings in:

```
config/product.php
```

---

## Testing

Run tests with PHPUnit:

```bash
php artisan test
```

---

## Contributing

Contributions, issues, and feature requests are welcome. Please follow the repository guidelines.

---

## License

This package is open-sourced software licensed under the MIT license.

---

## Links

- [Initial structure pull request](https://github.com/VeiligLanceren-nl/laravel-webshop-product/pull/1)
