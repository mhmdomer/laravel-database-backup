<?php

namespace Mhmdomer\DatabaseBackup\Events;

class DatabaseBackupComplete
{
    public string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }
}
