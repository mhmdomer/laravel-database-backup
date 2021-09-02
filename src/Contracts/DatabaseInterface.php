<?php

namespace Mhmdomer\DatabaseBackup\Contracts;

interface DatabaseInterface
{
    public static function getDumpCommand(string $filePath): string;
}
