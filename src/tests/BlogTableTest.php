<?php

use PHPUnit\Framework\TestCase;
use framework\Database;
use models\BlogTable;

/*
 * BlogTableTest
 *
 * Whitebox/integration tests for blog post database logic.
 * These tests support the admin blog management feature by checking
 * create, read, update, latest-post retrieval, and delete behaviour.
 */
final class BlogTableTest extends TestCase
{
    private PDO $pdo;
    private BlogTable $posts;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
        $this->posts = new BlogTable();

        $this->resetTestData();
    }

    protected function tearDown(): void
    {
        $this->resetTestData();
    }

    /*
     * Delete only PHPUnit blog posts.
     * The title prefix keeps cleanup separate from real blog content.
     */
    private function resetTestData(): void
    {
        $this->pdo->exec(
            "DELETE FROM blog_posts
             WHERE title LIKE 'PHPUnit Blog Test%'"
        );
    }

    /*
     * Create one blog post through the real BlogTable::save() method.
     */
    private function createTestPost(
        string $title = 'PHPUnit Blog Test Main Post',
        string $category = 'Testing',
        string $content = 'This post was created by PHPUnit.'
    ): int {
        return (int) $this->posts->save([
            'title' => $title,
            'category' => $category,
            'content' => $content
        ]);
    }

    /*
     * save() should insert a new blog post that can be found by ID.
     */
    public function testSaveCanCreateBlogPost(): void
    {
        $postid = $this->createTestPost();

        $post = $this->posts->findById($postid);

        $this->assertNotFalse($post);
        $this->assertSame('PHPUnit Blog Test Main Post', $post->title);
        $this->assertSame('Testing', $post->category);
        $this->assertSame('This post was created by PHPUnit.', $post->content);
    }

    /*
     * save() should update an existing blog post when postid is provided.
     */
    public function testSaveCanUpdateBlogPost(): void
    {
        $postid = $this->createTestPost();

        $this->posts->save([
            'postid' => $postid,
            'title' => 'PHPUnit Blog Test Updated Post',
            'category' => 'Updated Category',
            'content' => 'Updated content from PHPUnit.'
        ]);

        $updatedPost = $this->posts->findById($postid);

        $this->assertNotFalse($updatedPost);
        $this->assertSame('PHPUnit Blog Test Updated Post', $updatedPost->title);
        $this->assertSame('Updated Category', $updatedPost->category);
        $this->assertSame('Updated content from PHPUnit.', $updatedPost->content);
    }

    /*
     * findLatest() should return recently created posts.
     * The assertion checks that at least one PHPUnit post appears in the result.
     */
    public function testFindLatestReturnsRecentBlogPosts(): void
    {
        $this->createTestPost('PHPUnit Blog Test Latest One');
        $this->createTestPost('PHPUnit Blog Test Latest Two');

        $latestPosts = $this->posts->findLatest(5);

        $titles = array_map(fn ($post) => $post->title, $latestPosts);

        $this->assertContains('PHPUnit Blog Test Latest One', $titles);
        $this->assertContains('PHPUnit Blog Test Latest Two', $titles);
    }

    /*
     * delete() should remove a blog post from the database.
     */
    public function testDeleteRemovesBlogPost(): void
    {
        $postid = $this->createTestPost();

        $this->posts->delete($postid);

        $deletedPost = $this->posts->findById($postid);

        $this->assertFalse($deletedPost);
    }
}