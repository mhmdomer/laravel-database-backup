<?php

namespace Mhmdomer\DatabaseBackup\Tests;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Mhmdomer\DatabaseBackup\DatabaseBackup;
use Mhmdomer\DatabaseBackup\Events\DatabaseBackupComplete;
use Mhmdomer\DatabaseBackup\Events\DatabaseBackupFailed;
use Mockery;

class CommandTest extends TestCase
{
    /** @test */
    public function a_backup_file_is_created()
    {
        $this->artisan('database:backup')->expectsOutput('Backup complete');
        $files = DatabaseBackup::getBackupFiles();
        $this->assertCount(1, $files);
    }

    /** @test */
    public function maximum_number_of_files_is_never_exceeded()
    {
        $maximumNumberOfFiles = config('database-backup.maximum_backup_files');
        for ($i = 0; $i < $maximumNumberOfFiles; $i++) {
            $this->artisan('database:backup');
        }
        $files = DatabaseBackup::getBackupFiles();
        $this->assertCount($maximumNumberOfFiles, $files);

        $this->artisan('database:backup');
        $this->assertCount($maximumNumberOfFiles, $files);
    }

    /** @test */
    public function email_is_sent_upon_backup_completion_if_it_is_enabled()
    {
        $mailer = Mockery::spy(Mailer::class);
        Mail::swap($mailer);
        $mailer->shouldReceive('send')->once();

        $this->artisan('database:backup');

        config()->set("database-backup.mail.send", true);
        $this->artisan('database:backup')
            ->expectsOutput('Sending Email...')
            ->expectsOutput('Email sent successfully.');
    }

    /** @test */
    public function email_is_not_sent_if_no_email_option_is_provided()
    {
        config()->set("database-backup.mail.send", true);
        $mailer = Mockery::spy(Mailer::class);
        Mail::swap($mailer);

        $mailer->shouldReceive('send')->never();
        $this->artisan('database:backup --no-mail')
            ->doesntExpectOutput('Sending Email...')
            ->doesntExpectOutput('Email sent successfully.');
    }

    /** @test */
    public function it_can_get_the_latest_backup_if_exists()
    {
        $this->assertEquals(null, DatabaseBackup::getLatestBackupFile());
        $this->assertEquals([], DatabaseBackup::getBackupFiles());

        $this->artisan('database:backup');

        $this->assertEquals(
            DatabaseBackup::getBackupFiles()[0],
            DatabaseBackup::getLatestBackupFile()
        );
    }

    /** @test */
    public function it_fires_a_success_event_after_backup_completion()
    {
        Event::fake();
        $this->artisan('database:backup');

        Event::assertDispatched(DatabaseBackupComplete::class);
    }

    /** @test */
    public function it_fires_a_failure_event_after_backup_failure()
    {
        Event::fake();
        config()->set('database.default', 'mssql');

        $this->artisan('database:backup');

        Event::assertDispatched(DatabaseBackupFailed::class);
    }
}
