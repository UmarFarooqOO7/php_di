<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/container.php';

use App\UserService;

try {
    $container = setupContainer();

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
