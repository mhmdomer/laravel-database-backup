<?php

namespace Mhmdomer\DatabaseBackup;

class DatabaseBackup
{
    /**
     * Get all backup files
     *
     * @return array
     */
    public static function getBackupFiles(): array
    {
        $backupFolder = config('database-backup.backup_folder');
        if (!file_exists($backupFolder)) {
            mkdir($backupFolder, 0775, true);

            return [];
        }
        $files = array_filter(
            scandir($backupFolder),
            function ($item) {
                return !is_dir($item);
            }
        );

        $files = array_values($files);

        return array_map(function ($file) use ($backupFolder) {
            return $backupFolder . '/' . $file;
        }, $files);
    }

    /**
     * Get the last backup file
     *
     * @return string|null
     */
    public static function getLatestBackupFile(): ?string
    {
        $backupFolder = config('database-backup.backup_folder');
        if (!file_exists($backupFolder)) {
            mkdir($backupFolder, 0775, true);

            return null;
        }
        $files = array_values(self::getBackupFiles());

        if (count($files) == 0) {
            return null;
        }

        return $files[count($files) - 1];
    }
}
