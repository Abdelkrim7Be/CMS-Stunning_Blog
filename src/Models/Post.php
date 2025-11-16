<?php

namespace App\Models;

use App\Core\Database;

/**
 * Post Model
 * 
 * Handles all database operations for blog posts
 */
class Post
{
    /**
     * Get all posts with category information
     * 
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function all(int $limit = 10, int $offset = 0): array
    {
        $sql = "SELECT posts.*, category.title as category_name, admins.username as author
                FROM posts
                LEFT JOIN category ON posts.category = category.id
                LEFT JOIN admins ON posts.author = admins.username
                ORDER BY posts.datetime DESC
                LIMIT :limit OFFSET :offset";

        return Database::query($sql, ['limit' => $limit, 'offset' => $offset]);
    }

    /**
     * Get all posts with pagination (for public blog)
     * 
     * @param int $page Current page number
     * @param int $perPage Posts per page
     * @return array
     */
    public static function getAllPosts(int $page = 1, int $perPage = 5): array
    {
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT * FROM posts 
                ORDER BY id DESC 
                LIMIT :limit OFFSET :offset";

        return Database::query($sql, ['limit' => $perPage, 'offset' => $offset]);
    }

    /**
     * Get posts by category name
     * 
     * @param string $categoryName
     * @return array
     */
    public static function getByCategoryName(string $categoryName): array
    {
        $sql = "SELECT * FROM posts 
                WHERE category = :category
                ORDER BY id DESC";

        return Database::query($sql, ['category' => $categoryName]);
    }

    /**
     * Get total count of posts
     * 
     * @return int
     */
    public static function getTotalCount(): int
    {
        $sql = "SELECT COUNT(*) as total FROM posts";
        $result = Database::queryOne($sql);
        return $result['total'] ?? 0;
    }

    /**
     * Get approved comments count for a post
     * 
     * @param int $postId
     * @return int
     */
    public static function getApprovedCommentsCount(int $postId): int
    {
        $sql = "SELECT COUNT(*) as total 
                FROM comments 
                WHERE post_id = :post_id AND status = 'ON'";

        $result = Database::queryOne($sql, ['post_id' => $postId]);
        return $result['total'] ?? 0;
    }

    /**
     * Find post by ID
     * 
     * @param int $id
     * @return array|false
     */
    public static function findById(int $id)
    {
        $sql = "SELECT posts.*, category.title as category_name, admins.username as author
                FROM posts
                LEFT JOIN category ON posts.category = category.id
                LEFT JOIN admins ON posts.author = admins.username
                WHERE posts.id = :id
                LIMIT 1";

        return Database::queryOne($sql, ['id' => $id]);
    }

    /**
     * Get posts by category
     * 
     * @param int $categoryId
     * @return array
     */
    public static function byCategory(int $categoryId): array
    {
        $sql = "SELECT posts.*, category.title as category_name
                FROM posts
                LEFT JOIN category ON posts.category = category.id
                WHERE posts.category = :category_id
                ORDER BY posts.datetime DESC";

        return Database::query($sql, ['category_id' => $categoryId]);
    }

    /**
     * Create a new post
     * 
     * @param array $data
     * @return bool
     */
    public static function create(array $data): bool
    {
        $sql = "INSERT INTO posts (datetime, title, category, author, image, post)
                VALUES (:datetime, :title, :category, :author, :image, :post)";

        return Database::execute($sql, [
            'datetime' => $data['datetime'] ?? date('Y-m-d H:i:s'),
            'title' => $data['title'],
            'category' => $data['category'],
            'author' => $data['author'],
            'image' => $data['image'] ?? null,
            'post' => $data['post'],
        ]);
    }

    /**
     * Update a post
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public static function update(int $id, array $data): bool
    {
        $sql = "UPDATE posts 
                SET title = :title, category = :category, image = :image, post = :post
                WHERE id = :id";

        return Database::execute($sql, [
            'id' => $id,
            'title' => $data['title'],
            'category' => $data['category'],
            'image' => $data['image'],
            'post' => $data['post'],
        ]);
    }

    /**
     * Delete a post
     * 
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        $sql = "DELETE FROM posts WHERE id = :id";
        return Database::execute($sql, ['id' => $id]);
    }

    /**
     * Count total posts
     * 
     * @return int
     */
    public static function count(): int
    {
        $sql = "SELECT COUNT(*) as count FROM posts";
        $result = Database::queryOne($sql);
        return (int)$result['count'];
    }

    /**
     * Search posts (for Blog.php search functionality)
     * 
     * @param string $query
     * @return array
     */
    public static function search(string $query): array
    {
        $searchTerm = "%{$query}%";
        $sql = "SELECT * FROM posts
                WHERE datetime LIKE :query1
                   OR category LIKE :query2
                   OR title LIKE :query3
                   OR post LIKE :query4
                ORDER BY id DESC";

        return Database::query($sql, [
            'query1' => $searchTerm,
            'query2' => $searchTerm,
            'query3' => $searchTerm,
            'query4' => $searchTerm
        ]);
    }

    /**
     * Get posts by author username
     * 
     * @param string $author
     * @return array
     */
    public static function getByAuthor(string $author): array
    {
        $sql = "SELECT posts.*, category.title as category_name
                FROM posts
                LEFT JOIN category ON posts.category = category.id
                WHERE posts.author = :author
                ORDER BY posts.datetime DESC";

        return Database::query($sql, ['author' => $author]);
    }
}
