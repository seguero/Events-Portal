<?php
namespace models;

use framework\Database;
use framework\DatabaseHelper;
use PDO;

/*
 * BlogTable
 *
 * Data-access layer for blog posts.
 */
class BlogTable
{
    /* Database helper configured for the blog_posts table */
    private DatabaseHelper $table;

    /* Initialise helper with connection, table name and model mapping */
    public function __construct()
    {
        $this->table = new DatabaseHelper(
            Database::getConnection(),
            'blog_posts',
            'postid',
            BlogModel::class
        );
    }

    /* Retrieve all blog posts, newest first */
    public function findAll(): array
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare(
            'SELECT * FROM blog_posts ORDER BY created_at DESC, postid DESC'
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, BlogModel::class);
    }

    /* Retrieve latest blog posts for homepage or blog preview sections */
    public function findLatest(int $limit = 3): array
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare(
            'SELECT * FROM blog_posts
             ORDER BY created_at DESC, postid DESC
             LIMIT :limit'
        );

        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, BlogModel::class);
    }

    /* Retrieve a single blog post by ID */
    public function findById(int $postid): object|false
    {
        return $this->table->find('postid', $postid);
    }

    /* Insert or update blog post */
    public function save(array $postData): string|int
    {
        return $this->table->save($postData);
    }

    /* Delete blog post */
    public function delete(int $postid): void
    {
        $this->table->delete($postid);
    }
}