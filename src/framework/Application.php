<?php
namespace framework;

class Application
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function run(): void
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $route = trim($path ?? '', '/');

        if ($route === '') {
            $route = $this->router->defaultRoute();
        }

        [$controllerName, $action] = array_pad(
            explode('/', $route, 2),
            2,
            'index'
        );

        $controller = $this->router->getController($controllerName);

        if (!method_exists($controller, $action)) {
            http_response_code(404);
            exit('404 - Action not found');
        }

        $page = $controller->$action();

        if (!is_array($page) || !isset($page['template'])) {
            throw new \RuntimeException(
                'Controller must return an array with at least a template.'
            );
        }

        $title = $page['title'] ?? 'Untitled';
        $variables = $page['variables'] ?? [];
        $styles = $page['styles'] ?? [];

        $content = $this->render(
            __DIR__ . '/../pages/' . $page['template'],
            $variables
        );

        require __DIR__ . '/../pages/layout.html.php';
    }

    private function render(string $file, array $variables = []): string
    {
        extract($variables);
        ob_start();
        require $file;
        return ob_get_clean();
    }
}