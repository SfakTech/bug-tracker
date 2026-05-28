<?php

class Router
{
    private array $routes = [];

    public function get($uri, $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $base = '/bug-tracker/public';
        if (strpos($uri, $base) === 0) {
            $uri = substr($uri, strlen($base));
        }
        if ($uri === '') $uri = '/';

        // Exact match
        if (isset($this->routes[$method][$uri])) {
            $this->call($this->routes[$method][$uri], []);
            return;
        }

        // Dynamic match {id}
        foreach ($this->routes[$method] ?? [] as $route => $action) {
            $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route);
            if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                array_shift($matches);
                $this->call($action, $matches);
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    private function call($action, array $params)
    {
        if (is_callable($action)) {
            call_user_func_array($action, $params);
            return;
        }

        [$controller, $method] = explode('@', $action);
        require_once __DIR__ . '/../Controllers/' . $controller . '.php';
        (new $controller)->$method(...$params);
    }
}
