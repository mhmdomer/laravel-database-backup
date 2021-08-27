<?php

namespace Mhmdomer\DatabaseBackup\Tests;

class CommandTest extends TestCase
{
    /** @test */
    public function backup_command_executes_successfully()
    {
        $this->artisan('database:backup')->assertExitCode(0);
        // $this->assertTrue(false);
    }
}
