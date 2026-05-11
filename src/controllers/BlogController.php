<?php
namespace controllers;

use models\BlogTable;

/*
 * BlogController
 *
 * Handles public blog pages.
 * The controller retrieves blog posts from the BlogTable model
 * and returns the correct blog views.
 */
class BlogController
{
    /* Model used to interact with the blog_posts database table */
    private BlogTable $blogPosts;

    /* Initialise the BlogTable model when the controller is created */
    public function __construct()
    {
        $this->blogPosts = new BlogTable();
    }

    /* Display the public blog listing page */
    public function index(): array
    {
        return [
            'title' => 'Blog',
            'template' => 'blog.html.php',
            'styles' => ['blog.css'],
            'variables' => [
                'posts' => $this->blogPosts->findAll()
            ]
        ];
    }

    /* Display a single blog post */
    public function show(): array
    {
        /* Get blog post ID from the URL */
        $id = $_GET['id'] ?? null;

        /* Redirect if no ID was provided */
        if (!$id) {
            return ['redirect' => '/blog'];
        }

        /* Retrieve the selected blog post from the database */
        $post = $this->blogPosts->findById((int) $id);

        /* Redirect if the blog post does not exist */
        if (!$post) {
            return ['redirect' => '/blog'];
        }

        /* Return single blog post view with post data */
        return [
            'title' => $post->title,
            'template' => 'blogPost.html.php',
            'styles' => ['blog.css'],
            'variables' => [
                'post' => $post
            ]
        ];
    }
}