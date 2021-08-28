<?php

namespace Mhmdomer\DatabaseBackup\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class DatabaseBackupCommand extends Command
{
    public $signature = 'database:backup';

    public $description = 'Backup your entire database';

    public function handle()
    {
        $this->comment('Running backup...');
        $filename = "database_backup_" . now()->format('Y_m_d_H_i_s_u') . '.sql';

        if (! file_exists(storage_path('app/backup'))) {
            $this->comment('Creating backup folder inside storage/app folder...');
            mkdir(storage_path('app/backup'), 0775, true);
        }

        $filePath = storage_path("app/backup/") . $filename;
        $connection = config('database.default');

        try {
            $command = $this->getCommand($connection, $filePath);
        } catch (\Exception $e) {
            $this->error($e->getMessage());

            return;
        }
        exec($command);

        $files = Storage::allFiles('backup');
        $maximumFiles = config('database-backup.maximum_backup_files');

        if (count($files) > $maximumFiles) {
            Storage::delete(array_slice($files, 0, count($files) - $maximumFiles));
        }

        if (config('database-backup.mail.send')) {
            $this->sendMail($filePath);
        }

        $this->comment('Backup complete');
    }

    protected function sendMail($filePath)
    {
        Mail::send('database-backup::backup_mail', [], function ($message) use ($filePath) {
            $message->from(config('mail.from.address'));
            $message->to(config('database-backup.mail.to'));
            $message->subject(config('app.name') . ' Database Backup');
            $message->attach($filePath);
        });
    }

    protected function getCommand($connection, $filePath)
    {
        if ($connection === 'mysql') {
            return
                "mysqldump --user="
                . config('database.connections.mysql.username')
                . " --password=" . config('database.connections.mysql.password')
                . " --host=" . config('database.connections.mysql.host') . " "
                . config('database.connections.mysql.database') . "  > " . $filePath
                . " 2> /dev/null";
        } elseif ($connection == 'pgsql') {
            return "pg_dump " . config('database.connections.pgsql.database') . " > " . $filePath;
        } elseif ($connection == 'sqlite') {
            return "cp " . config('database.connections.sqlite.database') . " " . $filePath . 'ite';
        } else {
            throw new Exception("The connection " . $connection . " is not supported yet");
        }
    }
}
