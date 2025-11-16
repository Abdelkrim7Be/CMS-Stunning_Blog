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
        $sql = "SELECT * FROM admins ORDER BY 
                CASE role
                    WHEN 'super_admin' THEN 1
                    WHEN 'admin' THEN 2
                    WHEN 'editor' THEN 3
                    WHEN 'author' THEN 4
                END, id DESC";
        return Database::query($sql);
    }

    /**
     * Get paginated users
     * 
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function paginate(int $limit, int $offset): array
    {
        $sql = "SELECT * FROM admins ORDER BY 
                CASE role
                    WHEN 'super_admin' THEN 1
                    WHEN 'admin' THEN 2
                    WHEN 'editor' THEN 3
                    WHEN 'author' THEN 4
                END, id DESC
                LIMIT :limit OFFSET :offset";
        return Database::query($sql, ['limit' => $limit, 'offset' => $offset]);
    }

    /**
     * Create a new admin
     * 
     * @param array $data
     * @return bool
     */
    public static function create(array $data): bool
    {
        $sql = "INSERT INTO admins (username, password, role, aname, datetime, added_by, aheadline, abio, aimage) 
                VALUES (:username, :password, :role, :aname, :datetime, :added_by, :aheadline, :abio, :aimage)";

        return Database::execute($sql, [
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => $data['role'] ?? 'author',
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

    /**
     * Find users by role
     * 
     * @param string $role
     * @return array
     */
    public static function findByRole(string $role): array
    {
        $sql = "SELECT * FROM admins WHERE role = :role ORDER BY id DESC";
        return Database::query($sql, ['role' => $role]);
    }

    /**
     * Update user role
     * 
     * @param int $id
     * @param string $role
     * @return bool
     */
    public static function updateRole(int $id, string $role): bool
    {
        $sql = "UPDATE admins SET role = :role WHERE id = :id";
        return Database::execute($sql, [
            'id' => $id,
            'role' => $role,
        ]);
    }

    /**
     * Count users by role
     * 
     * @param string $role
     * @return int
     */
    public static function countByRole(string $role): int
    {
        $sql = "SELECT COUNT(*) as count FROM admins WHERE role = :role";
        $result = Database::queryOne($sql, ['role' => $role]);
        return (int)$result['count'];
    }

    /**
     * Get role statistics
     * 
     * @return array
     */
    public static function getRoleStats(): array
    {
        $sql = "SELECT role, COUNT(*) as count FROM admins GROUP BY role";
        $results = Database::query($sql);

        $stats = [];
        foreach ($results as $row) {
            $stats[$row['role']] = (int)$row['count'];
        }

        return $stats;
    }
}
