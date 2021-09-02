<?php

namespace Mhmdomer\DatabaseBackup\Databases;

use Mhmdomer\DatabaseBackup\Contracts\DatabaseInterface;

class Postgresql implements DatabaseInterface
{
    public static function getDumpCommand(string $filePath): string
    {
        return "pg_dump " . config('database.connections.pgsql.database') . " > " . $filePath;
    }
}
