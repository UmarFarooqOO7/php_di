<?php

namespace App;

use App\Database\UserRepository;
use App\Events\EventDispatcher;
use App\Events\UserCreated;

class UserService
{
    public function __construct(
        private UserRepository $repository,
        private Logger $logger,
        private EventDispatcher $events
    ) {}

    public function createUser(string $name)
    {
        $this->logger->log("Starting user creation process for {$name}");
        
        if ($this->repository->save($name)) {
            $this->logger->log("User '{$name}' created successfully");
            
            // Dispatch UserCreated event
            $this->events->dispatch(new UserCreated(
                name: $name,
                timestamp: date('Y-m-d H:i:s')
            ));
            
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
