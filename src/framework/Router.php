<?php
namespace framework;

class Router
{
    public function defaultRoute(): string
    {
        return 'home/index';
    }

    public function getController(string $name): object
    {
        $map = [
            'home' => \controllers\HomeController::class
        ];

        if (!array_key_exists($name, $map)) {
            http_response_code(404);
            exit('404 - Controller not found');
        }

        $class = $map[$name];

        return new $class();
    }
}