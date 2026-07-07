<?php
// Simple SQLite database wrapper and initializer
function solara_db(): PDO {
    static $db;
    if ($db) return $db;
    $dir = __DIR__ . '/../database';
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    $path = $dir . '/solara.sqlite';
    $db = new PDO('sqlite:' . $path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create tables if they do not exist
    $db->exec("CREATE TABLE IF NOT EXISTS status (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        payload TEXT NOT NULL,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS applications (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        discord TEXT,
        message TEXT,
        job_pref TEXT,
        status TEXT DEFAULT 'pending',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS staff (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        role TEXT,
        responsibilities TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    return $db;
}
