<?php

namespace Mhmdomer\DatabaseBackup\Exceptions;

use Exception;

class NoBackupFileFoundException extends Exception
{
    public function toString()
    {
        return $this->message;
    }
}
