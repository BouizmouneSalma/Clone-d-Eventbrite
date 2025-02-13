<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require_once 'vendor/autoload.php';
require_once'C:\Users\youco\Desktop\MyEvenT\controllers\AuthController.php';
require_once'C:\Users\youco\Desktop\MyEvenT\controllers\UserControllers.php';
require_once'C:\Users\youco\Desktop\MyEvenT\routes\router.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$userController= new UserControllerimpl();
$router=new Router();
$loader = new FilesystemLoader('templates');
$twig = new Environment($loader);

$template = 'login.html.twig'; 


$router->addRoute('/login', 'AuthController', 'login');
$router->addRoute('/register', 'AuthController', 'register');

$route = $_SERVER['REQUEST_URI'];

if (isset($route)) {
    
    // Explode route into an array based on slashes
    $routes = explode("/", $route);
    
    // Output the routes array for debugging
 

    // Handle the request with the router
    $router->handleRequest($route);

    exit(); // Prevent further execution
}




?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login or Register</title>
</head>
<body>
    <!-- <form method="POST">
        <button type="submit" name="login">Login</button>
        <button type="submit" name="register">Register</button>
        <button type="submit" name="fetch">fetch</button>
    </form> -->
</body>
</html>