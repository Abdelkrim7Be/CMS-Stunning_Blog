<?php

namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * User Model
 * 
 * Handles all database operations related to users/admins.
 * 
 * WHY Model?
 * - Separation: Database logic separate from controllers
 * - Reusability: Can use same methods across different controllers
 * - Security: Centralized, secure database queries
 */
class User
{
    /**
     * Find user by username
     * 
     * @param string $username
     * @return array|false
     */
    public static function findByUsername(string $username)
    {
        $sql = "SELECT * FROM admins WHERE username = :username LIMIT 1";
        return Database::queryOne($sql, ['username' => $username]);
    }

    /**
     * Find user by ID
     * 
     * @param int $id
     * @return array|false
     */
    public static function findById(int $id)
    {
        $sql = "SELECT * FROM admins WHERE id = :id LIMIT 1";
        return Database::queryOne($sql, ['id' => $id]);
    }

    /**
     * Verify user login credentials
     * 
     * @param string $username
     * @param string $password
     * @return array|false Returns user data if valid, false otherwise
     */
    public static function verifyLogin(string $username, string $password)
    {
        $user = self::findByUsername($username);

        if (!$user) {
            return false;
        }

        // Check if password is hashed or plain text (legacy support)
        if (password_verify($password, $user['password'])) {
            // Modern hashed password
            return $user;
        } elseif ($user['password'] === $password) {
            // Legacy plain text password (should be migrated!)
            // TODO: Update to hashed password after successful login
            return $user;
        }

        return false;
    }

    /**
     * Get all users/admins
     * 
     * @return array
     */
    public static function all(): array
    {
        $sql = "SELECT * FROM admins ORDER BY id DESC";
        return Database::query($sql);
    }

    /**
     * Create a new user
     * 
     * @param array $data
     * @return bool
     */
    public static function create(array $data): bool
    {
        $sql = "INSERT INTO admins (username, password, aname, addedby) 
                VALUES (:username, :password, :aname, :addedby)";

        return Database::execute($sql, [
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'aname' => $data['aname'],
            'addedby' => $data['addedby'] ?? 'System',
        ]);
    }

    /**
     * Update user
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public static function update(int $id, array $data): bool
    {
        $sql = "UPDATE admins SET ";
        $fields = [];
        $params = ['id' => $id];

        foreach ($data as $key => $value) {
            if ($key === 'password') {
                $value = password_hash($value, PASSWORD_DEFAULT);
            }
            $fields[] = "{$key} = :{$key}";
            $params[$key] = $value;
        }

        $sql .= implode(', ', $fields) . " WHERE id = :id";

        return Database::execute($sql, $params);
    }

    /**
     * Delete user
     * 
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        $sql = "DELETE FROM admins WHERE id = :id";
        return Database::execute($sql, ['id' => $id]);
    }

    /**
     * Count total users
     * 
     * @return int
     */
    public static function count(): int
    {
        $sql = "SELECT COUNT(*) as count FROM admins";
        $result = Database::queryOne($sql);
        return (int)$result['count'];
    }
}
