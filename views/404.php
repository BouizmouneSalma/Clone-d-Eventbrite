<?php

require '../views/layout/header.php';

// Définir la redirection en fonction du rôle
$redirectUrl = '/';
if (isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] === 'admin') {
        $redirectUrl = '/admin/dashboard';
    } elseif ($_SESSION['user_role'] === 'organizer') {
        $redirectUrl = '/organizer/dashboard';
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-1">404</h1>
            <h2 class="mb-4">Page non trouvée</h2>
            <p class="lead mb-5">Désolé, la page que vous recherchez n'existe pas ou a été déplacée.</p>
            <a href="<?= $redirectUrl; ?>" class="btn btn-primary btn-lg">Retour à l'accueil</a>
        </div>
    </div>
</div>

<?php require '../views/layout/footer.php'; ?>
