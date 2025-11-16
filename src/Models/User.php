<?php

namespace App\Models;

use App\Core\Database;

/**
 * User Model
 * 
 * Handles all database operations related to admins table
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
     * @return array|false
     */
    public static function verifyLogin(string $username, string $password)
    {
        $user = self::findByUsername($username);

        if (!$user) {
            return false;
        }

        // Check if password is hashed or plain text
        if (password_verify($password, $user['password'])) {
            return $user;
        } elseif ($user['password'] === $password) {
            // Plain text password (legacy)
            return $user;
        }

        return false;
    }

    /**
     * Get all admins
     * 
     * @return array
     */
    public static function all(): array
    {
        $sql = "SELECT * FROM admins ORDER BY id DESC";
        return Database::query($sql);
    }

    /**
     * Create a new admin
     * 
     * @param array $data
     * @return bool
     */
    public static function create(array $data): bool
    {
        $sql = "INSERT INTO admins (username, password, aname, datetime, added_by, aheadline, abio, aimage) 
                VALUES (:username, :password, :aname, :datetime, :added_by, :aheadline, :abio, :aimage)";

        return Database::execute($sql, [
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'aname' => $data['aname'] ?? $data['username'],
            'datetime' => date('F-d-Y H:i:s'),
            'added_by' => $data['added_by'] ?? 'System',
            'aheadline' => $data['aheadline'] ?? '',
            'abio' => $data['abio'] ?? '',
            'aimage' => $data['aimage'] ?? 'avatar.jpg',
        ]);
    }

    /**
     * Update admin
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
            if ($key === 'id') {
                continue;
            }
            if ($key === 'password' && !empty($value)) {
                $value = password_hash($value, PASSWORD_DEFAULT);
            }
            $fields[] = "{$key} = :{$key}";
            $params[$key] = $value;
        }

        if (empty($fields)) {
            return false;
        }

        $sql .= implode(', ', $fields) . " WHERE id = :id";

        return Database::execute($sql, $params);
    }

    /**
     * Delete admin
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
     * Count total admins
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
