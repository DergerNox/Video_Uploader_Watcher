<?php
// Database configuration - Using SQLite for persistence
$dbPath = __DIR__ . '/database.sqlite';

// For production, set environment variables
return [
    'driver' => 'pdo_sqlite',
    'path' => $dbPath,
];
