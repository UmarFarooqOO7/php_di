<?php

require __DIR__ . '/vendor/autoload.php';

use App\Container;
use App\Logger;
use App\FileLogger;
use App\UserService;

try {
    $container = new Container();
    echo "Container created<br>";

    // Use fully qualified class name for FileLogger
    $container->bind(Logger::class, FileLogger::class);

    // Resolve UserService (auto-injects FileLogger)
    $userService = $container->resolve(UserService::class);
    $userService->createUser("John Doe");
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
