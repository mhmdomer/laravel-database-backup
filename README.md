# Backup your laravel database by a simple artisan command

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mhmdomer/database-backup.svg?style=flat-square)](https://packagist.org/packages/mhmdomer/database-backup)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/mhmdomer/database-backup/run-tests?label=tests)](https://github.com/mhmdomer/database-backup/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/mhmdomer/database-backup/Check%20&%20fix%20styling?label=code%20style)](https://github.com/mhmdomer/database-backup/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mhmdomer/database-backup.svg?style=flat-square)](https://packagist.org/packages/mhmdomer/database-backup)

This package will allow you to backup your laravel app database and you can also choose to send the backup file via email by simply running the command `php artisan database:backup`

## Installation

You can install the package via composer:

```bash
composer require mhmdomer/database-backup
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
