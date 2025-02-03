<?php

require __DIR__ . '/vendor/autoload.php';

use App\Container;
use App\Logger;
use App\FileLogger;
use App\DatabaseLogger;
use App\UserService;

try {
    $container = new Container();
    
    // Initial binding with FileLogger
    $container->bind(Logger::class, FileLogger::class);
    
    // First instance with FileLogger
    $userService1 = $container->resolve(UserService::class);
    $userService1->createUser("John Doe");

    echo "<hr>Creating new instance with DatabaseLogger...<hr>";
    
    // Rebind to DatabaseLogger
    $container->bind(Logger::class, DatabaseLogger::class);
    
    // Second instance with DatabaseLogger
    $userService2 = $container->resolve(UserService::class);
    $userService2->createUser("Jane Doe");

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
