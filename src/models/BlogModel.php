<?php
namespace models;

/*
 * BlogModel
 *
 * Represents a single blog post record from the blog_posts table.
 */
class BlogModel
{
    /* Primary key */
    public ?int $postid = null;

    /* Blog post title */
    public string $title = '';

    /* Blog post category */
    public string $category = '';

    /* Main blog content */
    public string $content = '';

    /* Optional blog image */
    public ?string $image_path = null;

    /* Timestamp when the post was created */
    public ?string $created_at = null;

    /* Timestamp when the post was last updated */
    public ?string $updated_at = null;
}