<?php

namespace Mhmdomer\DatabaseBackup\Databases;

use Mhmdomer\DatabaseBackup\Contracts\DatabaseInterface;

class Sqlite implements DatabaseInterface
{
    public static function getDumpCommand(string $filePath): string
    {
        return "cp " . config('database.connections.sqlite.database') . " " . $filePath . 'ite';
    }
}
