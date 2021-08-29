<?php

namespace Mhmdomer\DatabaseBackup;

use Mhmdomer\DatabaseBackup\Exceptions\NoBackupFileFoundException;

class DatabaseBackup
{
    /**
     * Get all backup files
     *
     * @return array
     * @throws NoBackupFileFoundException if no backups found
     */

    public static function getBackupFiles()
    {
        $backupFolder = config('database-backup.backup_folder');
        if (!file_exists($backupFolder)) {
            mkdir($backupFolder, 0775, true);
            throw new NoBackupFileFoundException('No backups present, Please create backups first');
        }
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

    /**
     * Get the last backup file
     *
     * @return string
     * @throws NoBackupFileFoundException if no backups found
     */
    public static function getLatestBackupFile()
    {
        $backupFolder = config('database-backup.backup_folder');
        if (!file_exists($backupFolder)) {
            mkdir($backupFolder, 0775, true);
            throw new NoBackupFileFoundException('No backups present, Please create backups first');
        }
        $files = array_values(self::getBackupFiles());

        if (count($files) == 0) {
            throw new NoBackupFileFoundException('No backups present, Please create backups first');
        }

        return $files[0];
    }
}
