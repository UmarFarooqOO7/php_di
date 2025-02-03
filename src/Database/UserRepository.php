<?php

namespace App\Database;

interface UserRepository
{
    public function save(string $name): bool;
    public function find(int $id): ?array;
    public function all(): array;
}
