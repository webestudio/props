<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, array|callable $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, array|callable $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, array|callable $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $this->matchPath($route['path'], $requestUri)) {
                $this->callHandler($route['handler']);
                return;
            }
        }

        http_response_code(404);
        echo '404 - Not Found';
    }

    private function matchPath(string $routePath, string $requestUri): bool
    {
        return $routePath === $requestUri;
    }

    private function callHandler(array|callable $handler): void
    {
        if (is_array($handler)) {
            [$controller, $method] = $handler;
            $instance = new $controller();
            $instance->$method();
        } else {
            $handler();
        }
    }
}
