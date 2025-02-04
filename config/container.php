<?php

use App\Container;
use App\Logger;
use App\FileLogger;
use App\Database\DatabaseConnection;
use App\Database\UserRepository;
use App\Database\MySqlUserRepository;
use App\Events\EventDispatcher;
use App\Events\UserCreatedListener;
use App\Events\UserCreated;

function setupContainer(): Container {
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
    
    return $container;
}
