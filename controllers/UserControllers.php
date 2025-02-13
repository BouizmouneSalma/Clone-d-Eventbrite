<?php

require_once '../models/User.php';
require_once '../models/Organizer.php';
require_once '../models/Admin.php';

class UserController {
    private $userModel;
    private $organizerModel;
    private $adminModel;

    public function __construct() {
        $this->userModel = new User();
        $this->organizerModel = new Organizer();
        $this->adminModel = new Admin();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'email' => $_POST['email'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'role' => $_POST['role']
            ];

            $userId = null;
            switch ($data['role']) {
                case 'organisateur':
                    $data['company_name'] = $_POST['company_name'] ?? null;
                    $data['website'] = $_POST['website'] ?? null;
                    $userId = $this->organizerModel->create($data);
                    break;
               
                default:
                    $userId = $this->userModel->create($data);
            }

            if ($userId) {
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_role'] = $data['role'];
                header('Location: /login');
                exit;
            } else {
                $error = "L'inscription a échoué. Veuillez réessayer.";
            }
        }

        require '../views/user/register.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $this->userModel->findByEmail($_POST['email']);

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];

        // Redirection en fonction du rôle de l'utilisateur
        switch ($user['role']) {
            case 'admin':
                header('Location: /admin/dashboard');
                break;
            case 'organizer': 
                header('Location: /organizer/dashboard');
                break;
            default:
                header('Location: /');
                break;
        }
        exit;
    } else {
        $error = "Email ou mot de passe invalide.";
    }
}

require '../views/user/login.php';
    }

    public function logout() {
        session_destroy();
        header('Location: /');
        exit;
    }

    public function dashboard() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        switch ($_SESSION['user_role']) {
            case 'admin':
                $controller = new AdminController();
                $controller->dashboard();
                break;
            case 'organizer':
                $controller = new OrganizerController();
                $controller->dashboard();
                break;
            default:
                require 'views/user/dashboard.php';
        }
    }
}

