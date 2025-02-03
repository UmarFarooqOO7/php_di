<?php

require __DIR__ . '/vendor/autoload.php';

use App\Container;
use App\Logger;
use App\FileLogger;
use App\DatabaseConnection;
use App\UserService;

try {
    $container = new Container();
    
    // Regular binding (new instance each time)
    $container->bind(Logger::class, FileLogger::class);
    
    // Singleton binding (same instance every time)
    $container->singleton(DatabaseConnection::class, DatabaseConnection::class);

    echo "<h3>Regular Binding Demo:</h3>";
    $logger1 = $container->resolve(Logger::class);
    echo "<br>";
    $logger2 = $container->resolve(Logger::class);

    echo "<br>";
    $logger1->log("First logger instance<br>");
    $logger2->log("Second logger instance<br>");

    echo "<h3>Singleton Binding Demo:</h3>";
    echo "1st resolve<br>";
    $db1 = $container->resolve(DatabaseConnection::class);
    echo "<br>2nd resolve<br>";
    $db2 = $container->resolve(DatabaseConnection::class);
    
    $db1->query("SELECT * FROM users");
    $db2->query("SELECT * FROM posts");
    
    echo "<h3>Proof of Singleton:</h3>";
    echo "Total DB connections created: " . DatabaseConnection::getInstanceCount() . "<br>";
    echo "Are variables sharing same instance? " . ($db1 === $db2 ? "Yes" : "No") . "<br>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
