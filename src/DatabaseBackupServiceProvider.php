<?php

namespace Mhmdomer\DatabaseBackup;

use Illuminate\Support\ServiceProvider;
use Mhmdomer\DatabaseBackup\Commands\DatabaseBackupCommand;

class DatabaseBackupServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(DatabaseBackup::class, function () {
            return new DatabaseBackup();
        });

        if (!$this->app->runningInConsole()) {
            return $this;
        }

        $this->publishes([
            __DIR__ . "/../config/database-backup.php" => config_path('database-backup.php'),
            __DIR__ . '/../resources/views' => resource_path('views/vendor/database-backup'),
        ], 'database-backup');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'database-backup');

        $this->commands([DatabaseBackupCommand::class]);

        $this->mergeConfigFrom(__DIR__ . '/../config/database-backup.php', 'database-backup');
    }
}
