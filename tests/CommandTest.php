<?php

namespace Mhmdomer\DatabaseBackup\Tests;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Mockery;

class CommandTest extends TestCase
{
    /** @test */
    public function a_backup_file_is_created()
    {
        $this->artisan('database:backup')->expectsOutput('Backup complete');
        $files = Storage::allFiles('backup');
        $this->assertCount(1, $files);
    }

    /** @test */
    public function maximum_number_of_files_is_never_exceeded()
    {
        $maximumNumberOfFiles = config('database-backup.maximum_backup_files');
        for ($i = 0; $i < $maximumNumberOfFiles; $i++) {
            $this->artisan('database:backup');
        }
        $files = Storage::allFiles('backup');
        $this->assertCount($maximumNumberOfFiles, $files);

        $this->artisan('database:backup');
        $this->assertCount($maximumNumberOfFiles, $files);
    }

    /** @test */
    public function email_is_sent_upon_backup_completion_if_it_is_enabled()
    {
        $mailer = Mockery::spy(Mailer::class);
        Mail::swap($mailer);

        $this->artisan('database:backup');
        Mail::assertNothingSent();

        config()->set("database-backup.mail.send", true);
        $this->artisan('database:backup');
        $mailer->shouldHaveReceived('send');
    }
}