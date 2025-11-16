<?php

namespace App\Models;

use App\Core\Database;

/**
 * Category Model
 */
class Category
{
    /**
     * Get all categories
     * 
     * @return array
     */
    public static function all(): array
    {
        $sql = "SELECT * FROM category ORDER BY title ASC";
        return Database::query($sql);
    }

    /**
     * Find category by ID
     * 
     * @param int $id
     * @return array|false
     */
    public static function findById(int $id)
    {
        $sql = "SELECT * FROM category WHERE id = :id LIMIT 1";
        return Database::queryOne($sql, ['id' => $id]);
    }

    /**
     * Create a new category
     * 
     * @param array $data
     * @return bool
     */
    public static function create(array $data): bool
    {
        $sql = "INSERT INTO category (title, author, datetime)
                VALUES (:title, :author, :datetime)";

        return Database::execute($sql, [
            'title' => $data['title'],
            'author' => $data['author'],
            'datetime' => $data['datetime'] ?? date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Delete a category
     * 
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        $sql = "DELETE FROM category WHERE id = :id";
        return Database::execute($sql, ['id' => $id]);
    }

    /**
     * Count total categories
     * 
     * @return int
     */
    public static function count(): int
    {
        $sql = "SELECT COUNT(*) as count FROM category";
        $result = Database::queryOne($sql);
        return (int)$result['count'];
    }
}
