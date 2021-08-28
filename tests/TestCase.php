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

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Mhmdomer\\DatabaseBackup\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
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
        Storage::deleteDirectory('backup');
    }
}
