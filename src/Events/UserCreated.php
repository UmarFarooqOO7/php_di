<?php

namespace App\Events;

/**
 * Event that represents a user being created in the system
 */
class UserCreated
{
    public function __construct(
        public string $name,
        public string $timestamp
    ) {}
}