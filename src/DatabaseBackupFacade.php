<?php

namespace Mhmdomer\DatabaseBackup;

use Illuminate\Support\Facades\Facade;

/**
 * @see \VendorName\Skeleton\Skeleton
 */
class DatabaseBackupFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return DatabaseBackup::class;
    }
}
