<?php

namespace App;

class DatabaseLogger implements Logger {
    public function log(string $message) {
        echo "[DatabaseLogger] $message\n";
    }
}