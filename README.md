# Backup your laravel database by a simple artisan command

[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/mhmdomer/laravel-database-backup/run-tests?label=tests)](https://github.com/mhmdomer/laravel-database-backup/actions/workflows/run-tests.yml/badge.svg)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/mhmdomer/laravel-database-backup/Check%20&%20fix%20styling?label=code%20style)](https://github.com/mhmdomer/laravel-database-backup/actions/workflows/php-cs-fixer.yml/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/mhmdomer/laravel-database-backup.svg?style=flat-square)](https://packagist.org/packages/mhmdomer/laravel-database-backup)
[![Latest Stable Version](http://poser.pugx.org/mhmdomer/laravel-database-backup/v)](https://packagist.org/packages/mhmdomer/laravel-database-backup)
[![License](http://poser.pugx.org/mhmdomer/laravel-database-backup/license)](https://packagist.org/packages/mhmdomer/laravel-database-backup)

This package will allow you to backup your laravel app database and you can also choose to send the backup file via email by simply running the command `php artisan database:backup`

## Supported Databases

-   [x] Mysql
-   [x] Postgresql
-   [x] sqlite

## Installation

You can install the package via composer:

```bash
composer require mhmdomer/laravel-database-backup
```

You can publish the config file file with:

```bash
php artisan vendor:publish --tag=database-backup
```

You can configure the `maximum_backup_files` and whether to send an email when a backup occurs as well as specifying the email to send the backup file to

This is the contents of the published config file:

```php
return [

    /*
    |-------------------------------------------------------------------------
    | Backup Folder
    |-------------------------------------------------------------------------
    |
    | The path of the folder to save backups on and retrieve backups from.
    */

    'backup_folder' => storage_path('app/databases/hello'),

    /*
    |-------------------------------------------------------------------------
    | Maximum Backup Files
    |-------------------------------------------------------------------------
    |
    | The maximum number of files that should be present inside the backup folder,
    | each new backup after this limit will result in removing the oldest backup file
    */

    'maximum_backup_files' => 10,

    /*
    |-------------------------------------------------------------------------
    | Mail Settings
    |-------------------------------------------------------------------------
    | Email configuration for backups.
    */

    "mail" => [

        /*
        |-------------------------------------------------------------------------
        | Send Mail
        |-------------------------------------------------------------------------
        | Specify if an email with the backup file attached should
        | be sent when creating a backup.
        */

        'send' => env('DB_BACKUP_SEND_MAIL', false),

        /*
        |-------------------------------------------------------------------------
        | Backup Mail
        |-------------------------------------------------------------------------
        | Specify the email that should receive the backup file.
        */

        'to' => env('DB_BACKUP_EMAIL', 'example@example.com')
    ]
];

```

## Usage

To create a backup of your database you can run:

```bash
php artisan database:backup
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
