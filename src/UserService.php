<?php

namespace App;

use App\Database\UserRepository;

class UserService
{
    public function __construct(
        private UserRepository $repository,
        private Logger $logger
    ) {}

    public function createUser(string $name)
    {
        $this->logger->log("Starting user creation process for {$name}");
        
        if ($this->repository->save($name)) {
            $this->logger->log("User '{$name}' created successfully");
            return true;
        }
        
        $this->logger->log("Failed to create user '{$name}'");
        return false;
    }

    public function getUser(int $id): ?array
    {
        return $this->repository->find($id);
    }

    public function getAllUsers(): array
    {
        return $this->repository->all();
    }
}
