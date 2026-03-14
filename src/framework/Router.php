<?php
namespace framework;

/*
 * Router
 *
 * Responsible for resolving incoming routes and returning
 * the appropriate controller instance for the request.
 */
class Router
{
    /* Default route used when no path is provided */
    public function defaultRoute(): string
    {
        return 'home/index';
    }

    /*
     * Resolve controller name to a controller class
     * and return a new instance of that controller.
     */
    public function getController(string $name): object
    {
        $map = [
            'home' => \controllers\HomeController::class,
            'debug' => \controllers\DebugController::class,
            'account' => \controllers\AccountController::class,
            'events' => \controllers\EventController::class,
            'booking' => \controllers\BookingController::class,
            'admin' => \controllers\AdminController::class
        ];

        /* Return 404 if controller does not exist in the map */
        if (!array_key_exists($name, $map)) {
            http_response_code(404);
            exit('404 - Controller not found');
        }

        $class = $map[$name];

        /* Instantiate the requested controller */
        return new $class();
    }
}