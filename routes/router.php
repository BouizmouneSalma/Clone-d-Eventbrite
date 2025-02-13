<?php
class Router {
    private $routes = [];

    public function addRoute($path, $controller, $method) {
        $this->routes[$path] = ['controller' => $controller, 'method' => $method];
    }
    
    public function handleRequest($path) {
        if (array_key_exists($path, $this->routes)) {
            $controller = new $this->routes[$path]['controller']();
            $method = $this->routes[$path]['method'];
            if (method_exists($controller, $method)) {
                $controller->$method();
            } else {
                $this->error404();
            }
        } else {
            $this->error404();
        }
    }

    private function error404() {
        http_response_code(404);
        echo "Erreur 404 - Page non trouvée";
    }
}
?>
