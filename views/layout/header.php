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
    <nav class="bg-white shadow-lg py-4">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <a href="/" class="text-4xl flex font-semibold text-gray-800 hover:text-indigo-600 transition-all duration-300"><p class="text-blue-400 font-bold text-4xl">You</p>Event</a>
           

            <!-- User menu -->
            <div class="hidden md:flex items-center space-x-6">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <a href="/admin/dashboard" class="text-lg text-gray-700 hover:text-indigo-600 transition-all duration-300">Dashboard</a>
                        <a href="/logout" class="py-2 px-4 bg-red-500 text-white font-semibold rounded-md hover:bg-red-400 transition-all duration-300">Déconnexion</a>
                    <?php elseif ($_SESSION['user_role'] === 'participant'): ?>
                    <a href="/" class="text-lg text-gray-700 hover:text-indigo-600 transition-all duration-300">Evenement</a>
                        <a href="/dashboard" class="text-lg text-gray-700 hover:text-indigo-600 transition-all duration-300">Dashboard</a>
                        <a href="/logout" class="py-2 px-4 bg-red-500 text-white font-semibold rounded-md hover:bg-red-400 transition-all duration-300">Déconnexion</a>
                    <?php elseif ($_SESSION['user_role'] === 'organizer'): ?>
                        <a href="/organizer/dashboard" class="text-lg text-gray-700 hover:text-indigo-600 transition-all duration-300">Dashboard</a>
                        <a href="/organizer/promo-codes" class="text-lg text-gray-700 hover:text-indigo-600 transition-all duration-300">Code prome</a>
                        <a href="/organizer/manage-sales" class="text-lg text-gray-700 hover:text-indigo-600 transition-all duration-300">Vente</a>
                        <a href="/logout" class="py-2 px-4 bg-red-500 text-white font-semibold rounded-md hover:bg-red-400 transition-all duration-300">Déconnexion</a>
                    <?php endif; ?>
                   
                <?php else: ?>
                    <a href="/register" class="py-2 px-4 bg-green-500 text-white font-semibold rounded-md hover:bg-green-400 transition-all duration-300">Inscription</a>
                    <a href="/login" class="py-2 px-4 bg-transparent border-2 border-gray-500 text-gray-700 font-semibold rounded-md hover:bg-gray-100 transition-all duration-300">Connexion</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    </header>
    <main class="container mt-4"></main>