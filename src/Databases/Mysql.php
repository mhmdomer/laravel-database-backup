<?php

namespace Mhmdomer\DatabaseBackup\Databases;

use Mhmdomer\DatabaseBackup\Contracts\DatabaseInterface;

class Mysql implements DatabaseInterface
{
    public static function getDumpCommand(string $filePath): string
    {
        return "mysqldump --user="
                . config('database.connections.mysql.username')
                . " --password=" . config('database.connections.mysql.password')
                . " --host=" . config('database.connections.mysql.host') . " "
                . config('database.connections.mysql.database') . "  > " . $filePath
                . " 2> /dev/null";
    }
}
