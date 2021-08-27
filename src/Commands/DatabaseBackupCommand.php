<?php

namespace Mhmdomer\DatabaseBackup\Commands;

use Illuminate\Console\Command;

class DatabaseBackupCommand extends Command
{
    public $signature = 'database:backup';

    public $description = 'Backup database';

    public function handle()
    {
        $this->comment('All done');
    }
}
