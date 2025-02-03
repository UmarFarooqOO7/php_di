<?php

namespace App;

class FileLogger implements Logger
{
    public function log(string $message)
    {
        echo "[FileLogger] {$message}<br>";
    }
}
