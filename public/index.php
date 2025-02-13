<?php
session_start();

require_once '../config/database.php';
require_once '../core/Router.php';
require_once '../controllers/UserController.php';
require_once '../controllers/EventController.php';
require_once '../controllers/TicketController.php';
require_once '../controllers/AdminController.php';
require_once '../controllers/OrganizerController.php';

$router = new Router();

// User routes
$router->addRoute('GET', '/', 'EventController', 'index');
$router->addRoute('GET', '/login', 'UserController', 'login');
$router->addRoute('POST', '/login', 'UserController', 'login');
$router->addRoute('GET', '/register', 'UserController', 'register');
$router->addRoute('POST', '/register', 'UserController', 'register');
$router->addRoute('GET', '/logout', 'UserController', 'logout');

// Event routes
$router->addRoute('GET', '/events', 'EventController', 'index');
$router->addRoute('GET', '/events/create', 'EventController', 'create');
$router->addRoute('POST', '/events/create', 'EventController', 'create');
$router->addRoute('GET', '/events/{id}', 'EventController', 'detail');
$router->addRoute('GET', '/events/del/{id}', 'EventController', 'delete');
//$router->addRoute('GET', '/ticket/pdf/{id}', 'TicketController', 'generateTicketPDF');


// Ticket routes
$router->addRoute('POST', '/reserve', 'TicketController', 'reserve');
$router->addRoute('POST', '/cancel-reservation', 'TicketController', 'cancel');

// Admin routes
$router->addRoute('GET', '/admin/dashboard', 'AdminController', 'dashboard');
$router->addRoute('GET', '/admin/users', 'AdminController', 'manageUsers');
$router->addRoute('POST', '/admin/users', 'AdminController', 'manageUsers');
$router->addRoute('GET', '/admin/events', 'AdminController', 'manageEvents');
$router->addRoute('POST', '/admin/events', 'AdminController', 'manageEvents');

// Organizer routes
$router->addRoute('GET', '/organizer/dashboard', 'OrganizerController', 'dashboard');
$router->addRoute('GET', '/organizer/promo-codes/create', 'OrganizerController', 'createPromoCode');
$router->addRoute('POST', '/organizer/promo-codes/create', 'OrganizerController', 'createPromoCode');
//$router->addRoute('GET', '/organizer/export-participants/{id}', 'OrganizerController', 'exportParticipants');

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->dispatch($method, $uri);

