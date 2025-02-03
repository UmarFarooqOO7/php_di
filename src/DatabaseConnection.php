<?php

namespace App;

class DatabaseConnection
{
    private static int $instanceCount = 0;
    private string $connectionId;

    public function __construct()
    {
        self::$instanceCount++;
        $this->connectionId = uniqid('connection_');
        echo "Creating new database connection ({$this->connectionId})<br>";
    }

    public function query(string $sql)
    {
        echo "[{$this->connectionId}] Executing: {$sql}<br>";
    }

    public static function getInstanceCount(): int
    {
        return self::$instanceCount;
    }
}
