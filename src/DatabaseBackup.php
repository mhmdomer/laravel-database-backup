<?php

namespace Mhmdomer\DatabaseBackup;

use Mhmdomer\DatabaseBackup\Exceptions\NoBackupFileFoundException;

class DatabaseBackup
{
    public static function getBackupFiles()
    {
        $backupFolder = config('database-backup.backup_folder');
        $files = array_filter(
            scandir($backupFolder),
            function ($item) {
                return !is_dir($item);
            }
        );
        return array_map(function ($file) use ($backupFolder) {
            return $backupFolder . '/' . $file;
        }, $files);
    }

    public static function getLatestBackupFile()
    {
        $backupFolder = config('database-backup.backup_folder');
        if (!file_exists($backupFolder)) {
            mkdir($backupFolder, 0775, true);
            throw new NoBackupFileFoundException('No backups present');
        }
        $files = array_values(self::getBackupFiles());
        return $files[0];
    }
}
