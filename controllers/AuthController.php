<?php
require_once 'vendor/autoload.php'; // Assure-toi que Twig est bien chargé

class AuthController {
    private $twig;

    public function __construct() {
        // Initialisation de Twig
        $loader = new \Twig\Loader\FilesystemLoader('templates');
        $this->twig = new \Twig\Environment($loader);
    }

    // Affiche la page de connexion
    public function login() {
        echo $this->twig->render('login.html.twig');
    }

    // Affiche la page d'inscription
    public function register() {
        echo $this->twig->render('register.html.twig');
    }
}
?>
