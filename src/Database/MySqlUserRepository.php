<?php

namespace App\Database;

use App\Logger;

class MySqlUserRepository implements UserRepository
{
    public function __construct(
        private DatabaseConnection $connection,
        private Logger $logger
    ) {}

    public function save(string $name): bool
    {
        $this->logger->log("Saving user {$name} to MySQL (Connection: {$this->connection->getConnectionId()})");
        // Simulate database operation
        return true;
    }

    public function find(int $id): ?array
    {
        $this->logger->log("Finding user {$id} in MySQL (Connection: {$this->connection->getConnectionId()})");
        return ['id' => $id, 'name' => 'Test User'];
    }

    public function all(): array
    {
        $this->logger->log("Fetching all users from MySQL (Connection: {$this->connection->getConnectionId()})");
        return [
            ['id' => 1, 'name' => 'User 1'],
            ['id' => 2, 'name' => 'User 2']
        ];
    }
}
