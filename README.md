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

You can publish the config file with:

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

    'backup_folder' => storage_path('app/backup'),

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

The above command is typically run as a schedule command,
for example, you can add the following line in the `schedule` function
inside `app\Console\Kernel.php`

```php
$schedule->command('database:backup')->daily();
```

To disable sending a backup email you can add `--no-mail` option:

```bash
php artisan database:backup --no-mail
```

To get the latest backup file:

```php
DatabaseBackup::getLatestBackupFile();
```

To get all backup files:

```php
DatabaseBackup::getBackupFiles();
```

To download the latest backup file:

```php
$backupFile = DatabaseBackup::getLatestBackupFile();
return response()->download($backupFile);
```

### Listening to Events

`Mhmdomer\DatabaseBackup\Events\DatabaseBackupComplete` Event will be fired after each backup success, this event has a `string` public property called `$path` containing the path of the backup file so you can use it to download the file

Similarly,`Mhmdomer\DatabaseBackup\Events\DatabaseBackupFailed` Event will be fired after each backup failure, this event has an `Exception` public property called `$exception` containing the exception that caused the database backup failure. For example, you can add listeners to listen for these events by editing your `EventServiceProvider` like this:

```php
protected $listen = [
    Mhmdomer\DatabaseBackup\Events\DatabaseBackupComplete::class => [
        SendSuccessMessage::class,
    ],
    Mhmdomer\DatabaseBackup\Events\DatabaseBackupFailed::class => [
        LogException::class,
    ],
];
```

change `SendSuccessMessage::class` and `LogException::class` to match your own listeners

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
