<?php

require __DIR__ . '/vendor/autoload.php';

use App\Container;
use App\Logger;
use App\FileLogger;
use App\Database\DatabaseConnection;
use App\Database\UserRepository;
use App\Database\MySqlUserRepository;
use App\UserService;

try {
    $container = new Container();
    
    // Bind dependencies
    $container->singleton(DatabaseConnection::class, function() {
        return DatabaseConnection::getInstance();
    });
    
    $container->bind(Logger::class, FileLogger::class);
    $container->bind(UserRepository::class, MySqlUserRepository::class);

    // Resolve and use UserService
    $userService = $container->resolve(UserService::class);
    
    // Create new user
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
