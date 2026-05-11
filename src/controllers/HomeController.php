<?php
namespace controllers;

use models\EventTable;
use models\BlogTable;

/*
 * HomeController
 *
 * Handles the public homepage.
 * The controller retrieves popular events, latest events,
 * and recent blog posts for display on the landing page.
 */
class HomeController
{
    /* Model used to interact with the events database table */
    private EventTable $events;

    /* Model used to interact with the blog_posts database table */
    private BlogTable $blogPosts;

    /* Initialise required models when the controller is created */
    public function __construct()
    {
        $this->events = new EventTable();
        $this->blogPosts = new BlogTable();
    }

    /* Display the homepage with dynamic event and blog content */
    public function index(): array
    {
        /* Retrieve most booked events for the popular events section */
        $popularEvents = $this->events->findPopularEvents(3);

        /* Retrieve recently added events for the latest events section */
        $latestEvents = $this->events->findLatestEvents(2);

        /* Retrieve the newest blog post for the blog update section */
        $latestBlogPosts = $this->blogPosts->findLatest(1);

        /* Return homepage view with dynamic content */
        return [
            'title' => 'Home',
            'template' => 'home.html.php',
            'styles' => ['home.css'],
            'variables' => [
                'popularEvents' => $popularEvents,
                'latestEvents' => $latestEvents,
                'latestBlogPosts' => $latestBlogPosts
            ]
        ];
    }
}