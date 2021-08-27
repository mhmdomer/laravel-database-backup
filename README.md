# Backup your laravel database by a simple artisan command

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mhmdomer/database-backup.svg?style=flat-square)](https://packagist.org/packages/mhmdomer/database-backup)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/mhmdomer/database-backup/run-tests?label=tests)](https://github.com/mhmdomer/database-backup/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/mhmdomer/database-backup/Check%20&%20fix%20styling?label=code%20style)](https://github.com/mhmdomer/database-backup/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mhmdomer/database-backup.svg?style=flat-square)](https://packagist.org/packages/mhmdomer/database-backup)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require mhmdomer/database-backup
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Mhmdomer\DatabaseBackup\DatabaseBackupServiceProvider" --tag="database-backup-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Mhmdomer\DatabaseBackup\DatabaseBackupServiceProvider" --tag="database-backup-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$database-backup = new Mhmdomer\DatabaseBackup();
echo $database-backup->echoPhrase();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [mhmdomer](https://github.com/mhmdomer)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
