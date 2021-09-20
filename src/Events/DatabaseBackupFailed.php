<?php

namespace Mhmdomer\DatabaseBackup\Events;

use Exception;

class DatabaseBackupFailed
{
    public Exception $exception;

    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
    }
}
