<?php

namespace Mhmdomer\DatabaseBackup\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Mhmdomer\DatabaseBackup\DatabaseBackupServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
        $this->clearBackups();
    }

    protected function getPackageProviders($app)
    {
        return [
            DatabaseBackupServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        Schema::dropAllTables();
    }

    protected function clearBackups()
    {
        $backupFolder = config('database-backup.backup_folder');
        if (is_dir($backupFolder)) {
            array_map('unlink', glob("$backupFolder/*.*"));
            rmdir($backupFolder);
        }
    }
}
