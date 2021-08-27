<?php

namespace Mhmdomer\DatabaseBackup;

use Illuminate\Support\ServiceProvider;
use Mhmdomer\DatabaseBackup\Commands\DatabaseBackupCommand;

class DatabaseBackupServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            return $this;
        }

        $this->commands([DatabaseBackupCommand::class]);
    }
}
