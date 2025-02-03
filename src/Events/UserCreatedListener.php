<?php

namespace App\Events;

use App\Logger;

class UserCreatedListener
{
    public function __construct(
        private Logger $logger
    ) {}

    public function handle(UserCreated $event): void
    {
        // Log the event with additional details
        $this->logger->log("🎉 Event Handler: New user registration detected!");
        $this->logger->log("👤 User: {$event->name}");
        $this->logger->log("⏰ Timestamp: {$event->timestamp}");
        $this->logger->log("✅ Registration process completed successfully");
    }
}
