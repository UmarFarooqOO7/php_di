<?php

namespace App;

class UserService
{
    private Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function createUser(string $name)
    {
        echo "Creating user {$name}<br>";
        // Business logic...
        $this->logger->log("User '{$name}' created successfully.");
    }
}
