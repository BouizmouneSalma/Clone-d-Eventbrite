<?php

require_once "../UserControllers.php";
require_once "../../entities/User.php";
session_start();
$userController = new UserControllerimpl();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
 
    if (isset($_POST["register"])) {
        $name = $_POST["name"] ?? "";
        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  
        if ( empty($name) || empty($email) || empty($password)) {
            echo "Tous les champs sont requis.";
            exit();
        } 
            $person = new User($email, $hashed_password, $name);
           

        $person->setName($name);
        $person->setEmail($email);
        $person->setPassword($hashed_password);

       
        try {
            $userController->save($person);
            echo "Utilisateur enregistré avec succès.";
        } catch (Exception $e) {
            echo "Erreur lors de l'enregistrement : " . $e->getMessage();
        }
    }

    if (isset($_POST['login'])) {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $person = new User($email, $password, $name ='');
        var_dump($person);
        try {
          
            $userData = $userController->verifyUser($person);
             var_dump( $userData) ;
            if ($userData) {
               
             echo "is here ";
           
            } else {

                echo "Email ou motde passe incorrect.";
            }
        } catch (Exception $e) {
            echo "Erreur lors de la vérification : " . $e->getMessage();
        }
    }  
   
}


?>