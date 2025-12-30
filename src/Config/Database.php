<?php

namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function connect(): PDO
    {
        if (self::$connection === null) {
            try {
                $dbPath = __DIR__ . '/../../database/budget.db';
                $dbDir = dirname($dbPath);

                if (!is_dir($dbDir)) {
                    mkdir($dbDir, 0755, true);
                }

                self::$connection = new PDO('sqlite:' . $dbPath);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

                // Enable foreign keys
                self::$connection->exec('PRAGMA foreign_keys = ON');

            } catch (PDOException $e) {
                die('Database connection failed: ' . $e->getMessage());
            }
        }

        return self::$connection;
    }

    public static function runMigrations(): void
    {
        $db = self::connect();

        // Create migrations tracking table if not exists
        $db->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            migration TEXT NOT NULL UNIQUE,
            executed_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        $migrationsDir = __DIR__ . '/../../database/migrations/';
        if (!is_dir($migrationsDir)) {
            return;
        }

        $files = glob($migrationsDir . '*.sql');
        sort($files); // Ensure they run in order (001, 002, etc.)

        foreach ($files as $file) {
            $migrationName = basename($file);

            // Check if already executed
            $stmt = $db->prepare("SELECT COUNT(*) FROM migrations WHERE migration = ?");
            $stmt->execute([$migrationName]);
            if ($stmt->fetchColumn() > 0) {
                continue;
            }

            // Execute migration
            try {
                $sql = file_get_contents($file);
                $db->exec($sql);

                // Record execution
                $stmt = $db->prepare("INSERT INTO migrations (migration) VALUES (?)");
                $stmt->execute([$migrationName]);
            } catch (PDOException $e) {
                // Log error or handle it as needed
                error_log("Migration failed ($migrationName): " . $e->getMessage());
            }
        }
    }
}
