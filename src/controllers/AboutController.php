<?php
namespace controllers;

/*
 * AboutController
 *
 * Handles the About page.
 * The controller returns the about view, page title,
 * and page-specific stylesheet.
 */
class AboutController
{
    /* Render the About page */
    public function index(): array
    {
        return [
            'title' => 'About',
            'template' => 'about.html.php',
            'styles' => ['about.css'],
            'variables' => []
        ];
    }
}