<?php

require __DIR__ . '/vendor/autoload.php';

use App\Container;
use App\Logger;
use App\FileLogger;
use App\Database\DatabaseConnection;
use App\Database\UserRepository;
use App\Database\MySqlUserRepository;
use App\UserService;
use App\Events\EventDispatcher;
use App\Events\UserCreated;
use App\Events\UserCreatedListener;

try {
    $container = new Container();
    
    // Bind core services
    $container->singleton(DatabaseConnection::class, function() {
        return DatabaseConnection::getInstance();
    });
    
    $container->bind(Logger::class, FileLogger::class);
    $container->bind(UserRepository::class, MySqlUserRepository::class);
    
    // Bind EventDispatcher as singleton
    $container->singleton(EventDispatcher::class, EventDispatcher::class);
    
    // Set up event listeners
    $eventDispatcher = $container->resolve(EventDispatcher::class);
    $userCreatedListener = $container->resolve(UserCreatedListener::class);
    
    $eventDispatcher->listen(
        UserCreated::class, 
        [$userCreatedListener, 'handle']
    );

    // Create and use UserService
    $userService = $container->resolve(UserService::class);
    $userService->createUser("John Doe");
    
    // Get single user
    $user = $userService->getUser(1);
    echo "<pre>Found user: " . print_r($user, true) . "</pre>";
    
    // Get all users
    $users = $userService->getAllUsers();
    echo "<pre>All users: " . print_r($users, true) . "</pre>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
