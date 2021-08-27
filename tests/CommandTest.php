<?php

namespace Mhmdomer\DatabaseBackup\Tests;

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class CommandTest extends TestCase
{
    /** @test */
    public function backup_command_executes_successfully()
    {
        Artisan::call("migrate");
        $filename = "backup-" . Carbon::now()->format('Y-m-d');

        $command = "mysqldump --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  > " . storage_path() . "app/backup/" . $filename;

        $returnVar = NULL;
        $output  = NULL;

        exec($command, $output, $returnVar);
    }
}
