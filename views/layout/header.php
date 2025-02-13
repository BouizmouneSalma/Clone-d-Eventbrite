<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>Plateforme de Gestion d'Événements</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/custom.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="/">Gestion d'Événements</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/events">Événements</a>
                        </li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="/admin/dashboard">Dashboard Admin</a>
                                </li>
                            <?php elseif ($_SESSION['user_role'] === 'organizer'): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="/organizer/dashboard">Dashboard Organisateur</a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/user/profile">Mon Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/logout">Déconnexion</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/login">Connexion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/register">Inscription</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="container mt-4"></main>