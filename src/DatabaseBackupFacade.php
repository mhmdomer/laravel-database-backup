<?php

namespace Mhmdomer\DatabaseBackup;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mhmdomer\DatabaseBackup\DatabaseBackup
 */
class DatabaseBackupFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'database-backup';
    }
}
