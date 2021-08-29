<?php

namespace Mhmdomer\DatabaseBackup\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array getBackupFiles()
 * @method static string getLatestBackupFile()
 *
 * @see \Mhmdomer\DatabaseBackup\DatabaseBackup
 */
class DatabaseBackup extends Facade
{
    protected static function getFacadeAccessor()
    {
        return DatabaseBackup::class;
    }
}
