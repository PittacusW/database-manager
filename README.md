# Database Manager for Laravel

## Installation

You can install the package via composer:

```bash
composer require pittacusw/database-manager
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="database-manager-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="database-manager-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="database-manager-views"
```

## Usage

```php
$databaseManager = new PittacusW\DatabaseManager();
echo $databaseManager->echoPhrase('Hello, PittacusW!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [PittacusW](https://github.com/PittacusW)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
