<?php
namespace controllers;

/*
 * ErrorController
 * Handles application error pages such as 404 not found.
 */
class ErrorController
{
    /* Render a friendly 404 page */
    public function notFound(): array
    {
        http_response_code(404);

        return [
            'title' => '404 - Page Not Found',
            'template' => '404.html.php',
            'styles' => ['404.css'],
            'variables' => []
        ];
    }
}