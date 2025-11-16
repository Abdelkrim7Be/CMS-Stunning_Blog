<?php

namespace App\Core;

use PDO;
use PDOException;

/**
 * Database Class - Singleton Pattern
 * 
 * Provides a centralized database connection using PDO.
 * Implements Singleton pattern to ensure only one connection exists.
 * 
 * WHY Singleton?
 * - One database connection throughout the application
 * - Better resource management
 * - Prevents multiple connections
 */
class Database
{
    private static ?PDO $connection = null;
    private static array $config = [];

    /**
     * Initialize database configuration
     * 
     * @param array $config Database configuration array
     */
    public static function init(array $config): void
    {
        self::$config = $config;
    }

    /**
     * Get database connection (creates if doesn't exist)
     * 
     * @return PDO
     * @throws PDOException
     */
    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            self::connect();
        }

        return self::$connection;
    }

    /**
     * Create database connection
     * 
     * @throws PDOException
     */
    private static function connect(): void
    {
        try {
            $driver = self::$config['driver'] ?? 'mysql';
            $host = self::$config['host'] ?? 'localhost';
            $port = self::$config['port'] ?? '3306';
            $database = self::$config['database'];
            $charset = self::$config['charset'] ?? 'utf8mb4';

            $dsn = "{$driver}:host={$host};port={$port};dbname={$database};charset={$charset}";

            self::$connection = new PDO(
                $dsn,
                self::$config['username'],
                self::$config['password'],
                self::$config['options'] ?? []
            );
        } catch (PDOException $e) {
            // Log error and throw exception
            error_log("Database connection failed: " . $e->getMessage());
            throw new PDOException("Could not connect to database. Please check your configuration.");
        }
    }

    /**
     * Execute a query and return results
     * 
     * @param string $sql SQL query
     * @param array $params Parameters to bind
     * @return array
     */
    public static function query(string $sql, array $params = []): array
    {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Execute a query and return single row
     * 
     * @param string $sql SQL query
     * @param array $params Parameters to bind
     * @return array|false
     */
    public static function queryOne(string $sql, array $params = [])
    {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    /**
     * Execute an INSERT, UPDATE, or DELETE query
     * 
     * @param string $sql SQL query
     * @param array $params Parameters to bind
     * @return bool
     */
    public static function execute(string $sql, array $params = []): bool
    {
        $stmt = self::getConnection()->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Get the last inserted ID
     * 
     * @return string
     */
    public static function lastInsertId(): string
    {
        return self::getConnection()->lastInsertId();
    }

    /**
     * Begin a transaction
     */
    public static function beginTransaction(): bool
    {
        return self::getConnection()->beginTransaction();
    }

    /**
     * Commit a transaction
     */
    public static function commit(): bool
    {
        return self::getConnection()->commit();
    }

    /**
     * Rollback a transaction
     */
    public static function rollback(): bool
    {
        return self::getConnection()->rollBack();
    }
}
