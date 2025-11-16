<?php

namespace App\Models;

use App\Core\Database;

/**
 * Comment Model
 */
class Comment
{
    /**
     * Get all comments
     * 
     * @return array
     */
    public static function all(): array
    {
        $sql = "SELECT comments.*, posts.title as post_title
                FROM comments
                LEFT JOIN posts ON comments.post_id = posts.id
                ORDER BY comments.datetime DESC";

        return Database::query($sql);
    }

    /**
     * Get paginated comments
     * 
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function paginate(int $limit = 10, int $offset = 0): array
    {
        $sql = "SELECT comments.*, posts.title as post_title
                FROM comments
                LEFT JOIN posts ON comments.post_id = posts.id
                ORDER BY comments.datetime DESC
                LIMIT :limit OFFSET :offset";

        return Database::query($sql, ['limit' => $limit, 'offset' => $offset]);
    }

    /**
     * Get comments by post ID
     * 
     * @param int $postId
     * @return array
     */
    public static function byPost(int $postId): array
    {
        $sql = "SELECT * FROM comments 
                WHERE post_id = :post_id AND status = 'ON'
                ORDER BY datetime DESC";

        return Database::query($sql, ['post_id' => $postId]);
    }

    /**
     * Get pending comments (unapproved)
     * 
     * @return array
     */
    public static function pending(): array
    {
        $sql = "SELECT comments.*, posts.title as post_title
                FROM comments
                LEFT JOIN posts ON comments.post_id = posts.id
                WHERE comments.status = 'OFF'
                ORDER BY comments.datetime DESC";

        return Database::query($sql);
    }

    /**
     * Approve comment
     * 
     * @param int $id
     * @param string $approvedBy
     * @return bool
     */
    public static function approve(int $id, string $approvedBy = 'Admin'): bool
    {
        $sql = "UPDATE comments SET status = 'ON', approvedby = :approvedby WHERE id = :id";
        return Database::execute($sql, ['id' => $id, 'approvedby' => $approvedBy]);
    }

    /**
     * Disapprove comment
     * 
     * @param int $id
     * @return bool
     */
    public static function disapprove(int $id): bool
    {
        $sql = "UPDATE comments SET status = 'OFF' WHERE id = :id";
        return Database::execute($sql, ['id' => $id]);
    }

    /**
     * Delete comment
     * 
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        $sql = "DELETE FROM comments WHERE id = :id";
        return Database::execute($sql, ['id' => $id]);
    }

    /**
     * Count total comments
     * 
     * @return int
     */
    public static function count(): int
    {
        $sql = "SELECT COUNT(*) as count FROM comments";
        $result = Database::queryOne($sql);
        return (int)$result['count'];
    }

    /**
     * Count pending comments
     * 
     * @return int
     */
    public static function countPending(): int
    {
        $sql = "SELECT COUNT(*) as count FROM comments WHERE status = 'OFF'";
        $result = Database::queryOne($sql);
        return (int)$result['count'];
    }
}
