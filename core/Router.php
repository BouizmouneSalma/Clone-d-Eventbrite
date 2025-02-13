<?php

class Router
{
    private $routes = [];

    public function addRoute($method, $path, $controller, $action)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch($method, $uri)
    {
        foreach ($this->routes as $route) {
            $pattern = $this->convertPath($route['path']);
            if (preg_match($pattern, $uri, $params) && $route['method'] === $method) {
                $controller = new $route['controller']();
                $action = $route['action'];
                array_shift($params);
                return call_user_func_array([$controller, $action], $params);
            }
        }

       
        http_response_code(404);
        require '../views/404.php';
    }

    private function convertPath($path)
    {
        return '#^' . preg_replace('#\{([a-zA-Z0-9_]+)\}#', '([a-zA-Z0-9_]+)', $path) . '$#';
    }
}