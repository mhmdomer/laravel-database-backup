<?php

namespace Mhmdomer\DatabaseBackup;

class DatabaseBackup
{
    public static function getBackupFiles()
    {
        return
            array_filter(
                scandir(config('database-backup.backup_folder')),
                function ($item) {
                    return ! is_dir($item);
                }
            );
    }
}
