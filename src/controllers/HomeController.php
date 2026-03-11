<?php
namespace controllers;

class HomeController
{
    public function index(): array
    {
        return [
            'title' => 'Home',
            'template' => 'home.html.php',
            'styles' => ['home.css'],
            'variables' => [
            ]
        ];
    }
}