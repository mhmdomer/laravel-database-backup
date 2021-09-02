<?php

namespace Mhmdomer\DatabaseBackup\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Mhmdomer\DatabaseBackup\DatabaseBackup;
use Mhmdomer\DatabaseBackup\Databases\Mysql;
use Mhmdomer\DatabaseBackup\Databases\Postgresql;
use Mhmdomer\DatabaseBackup\Databases\Sqlite;

class DatabaseBackupCommand extends Command
{
    public $signature = 'database:backup {--no-mail : Do not send an email}';

    public $description = 'Backup your entire database';

    public function handle()
    {
        $this->comment('Running backup...');
        $filename = "database_backup_" . now()->format('Y_m_d_H_i_s_u') . '.sql';

        $backupFolder = config('database-backup.backup_folder');
        if (!file_exists($backupFolder)) {
            mkdir($backupFolder, 0775, true);
        }
        $filePath = $backupFolder . '/' . $filename;

        $connection = config('database.default');

        try {
            $command = $this->getCommand($connection, $filePath);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return;
        }
        exec($command);

        $files = DatabaseBackup::getBackupFiles();
        $maximumFiles = config('database-backup.maximum_backup_files');

        if (count($files) > $maximumFiles) {
            $sliced = array_slice($files, 0, count($files) - $maximumFiles);
            collect($sliced)->each(function ($file) {
                if ($file != '.') {
                    unlink($file);
                }
            });
        }

        if (!$this->option('no-mail') && config('database-backup.mail.send')) {
            $this->sendMail($filePath);
        }

        $this->comment('Backup complete');
    }

    /**
     * sends backup email
     *
     * @param string $filePath
     * @return void
     */
    protected function sendMail(string $filePath)
    {
        Mail::send('database-backup::backup_mail', [], function ($message) use ($filePath) {
            $message->from(config('mail.from.address'));
            $message->to(config('database-backup.mail.to'));
            $message->subject(config('app.name') . ' Database Backup');
            $message->attach($filePath);
        });
    }

    /**
     * returns a string command based on the connection passed
     *
     * @param string $connection
     * @param string $filePath
     * @return string
     */
    protected function getCommand(string $connection, string $filePath) : string
    {
        if ($connection === 'mysql') {
            return Mysql::getDumpCommand($filePath);
        } elseif ($connection == 'pgsql') {
            return Postgresql::getDumpCommand($filePath);
        } elseif ($connection == 'sqlite') {
            return Sqlite::getDumpCommand($filePath);
        } else {
            throw new Exception("The connection " . $connection . " is not supported yet");
        }
    }
}
