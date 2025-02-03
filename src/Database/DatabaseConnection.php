<?php

namespace App\Database;

class DatabaseConnection
{
    private string $connectionId;
    protected static ?self $instance = null;

    protected function __construct(
        private string $host,
        private string $username,
        private string $password,
        private string $database
    ) {
        $this->connectionId = uniqid('db_');
        echo "Creating new database connection ({$this->connectionId})<br>";
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self(
                'localhost',
                'root',
                '',
                'test'
            );
        }
        return self::$instance;
    }

    public function getConnectionId(): string
    {
        return $this->connectionId;
    }
}
