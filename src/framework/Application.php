<?php
namespace framework;

/*
 * Application (Front Controller)
 *
 * Responsible for:
 * - Parsing the incoming request
 * - Resolving controller and action via Router
 * - Executing the controller method
 * - Handling redirects
 * - Rendering the requested template inside the layout
 *
 * This class represents the core request lifecycle of the MVC framework.
 */
class Application
{
    /*
     * Router instance used to resolve controllers.
     */
    private Router $router;

    /*
     * Constructor
     * Injects the Router dependency.
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /*
     * Main execution method.
     * Handles the complete request lifecycle:
     * Request -> Route parsing -> Controller resolution
     * -> Action execution -> Template rendering -> Layout injection
     */
    public function run(): void
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $route = trim($path ?? '', '/');

        if ($route === '') {
            $route = $this->router->defaultRoute();
        }

        $parts = explode('/', $route);

        $controllerName = $parts[0] ?? 'home';
        $action = $parts[1] ?? 'index';
        $params = array_slice($parts, 2);

        $controller = $this->router->getController($controllerName);

        if (!method_exists($controller, $action)) {
            http_response_code(404);
            exit('404 - Action not found');
        }

        $page = $controller->$action(...$params);

        if (isset($page['redirect'])) {
            header('Location: ' . $page['redirect']);
            exit;
        }

        if (!is_array($page) || !isset($page['template'])) {
            throw new \RuntimeException(
                'Controller must return an array with at least a template.'
            );
        }

        $title = $page['title'] ?? 'Untitled';
        $variables = $page['variables'] ?? [];
        $styles = $page['styles'] ?? [];
        $scripts = $page['scripts'] ?? [];

        $content = $this->render(
            __DIR__ . '/../pages/' . $page['template'],
            $variables
        );

        require __DIR__ . '/../pages/layout.html.php';
    }

    /*
     * Renders a view file and returns its output as a string.
     *
     * Uses output buffering to capture rendered HTML.
     *
     * @param string $file      Path to view file
     * @param array  $variables Variables passed from controller
     * @return string           Rendered HTML content
     */
    private function render(string $file, array $variables = []): string
    {
        // Make array keys available as variables in the view
        extract($variables);

        // Start output buffering
        ob_start();

        // Include the view file
        require $file;

        // Return captured output
        return ob_get_clean();
    }
}