<?php

namespace Mhmdomer\DatabaseBackup\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class DatabaseBackupCommand extends Command
{
    public $signature = 'database:backup';

    public $description = 'Backup database';

    public function handle()
    {
        $this->comment('Running backup...');
        $filename = "database_backup_" . now()->format('Y_m_d_H_i_s_u') . '.sql';
        if (!file_exists(storage_path('app/backup'))) {
            $this->comment('Creating backup folder inside storage/app folder...');
            mkdir(storage_path('app/backup'), 0775, true);
        }

        $filePath = storage_path("app/backup/") . $filename;
        $command = "mysqldump --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  > " . $filePath;

        exec($command, $output, $returnVar);

        $files = Storage::allFiles('backup');
        if (count($files) > config('database-backup.maximum_backup_files')) {
            Storage::delete([$files[0]]);
        }

        if (config('database-backup.mail.send')) {
            Mail::send('database-backup::backup_mail', [], function ($message) use ($filePath) {
                $message->from(config('mail.from.address'));
                $message->to(config('database-backup.mail.to'));
                $message->subject(config('app.name') . ' Database Backup');
                $message->attach($filePath);
            });
        }
        $this->comment('Backup complete');
    }
}
