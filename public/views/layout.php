<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plateforme de Gestion d'Événements</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 font-Poppins">

    <!-- Navbar -->
    <nav class="bg-white shadow-lg py-4">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <a href="/" class="text-3xl font-semibold text-gray-800 hover:text-indigo-600 transition-all duration-300">EventManager</a>
            <div class="flex space-x-6">
                <a href="/events" class="text-lg text-gray-700 hover:text-indigo-600 transition-all duration-300">Événements</a>
                <a href="/about" class="text-lg text-gray-700 hover:text-indigo-600 transition-all duration-300">À propos</a>
                <a href="/contact" class="text-lg text-gray-700 hover:text-indigo-600 transition-all duration-300">Contact</a>
            </div>

            <!-- User menu -->
            <div class="hidden md:flex items-center space-x-6">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <a href="/admin/dashboard" class="text-lg text-gray-700 hover:text-indigo-600 transition-all duration-300">Tableau de bord</a>
                        <a href="/logout" class="py-2 px-4 bg-red-500 text-white font-semibold rounded-md hover:bg-red-400 transition-all duration-300">Déconnexion</a>
                    <?php elseif ($_SESSION['user_role'] === 'participant'): ?>
                        <a href="/dashboard" class="text-lg text-gray-700 hover:text-indigo-600 transition-all duration-300">Mon tableau de bord</a>
                        <a href="/logout" class="py-2 px-4 bg-red-500 text-white font-semibold rounded-md hover:bg-red-400 transition-all duration-300">Déconnexion</a>
                    <?php elseif ($_SESSION['user_role'] === 'organizer'): ?>
                        <a href="/organizer/dashboard" class="text-lg text-gray-700 hover:text-indigo-600 transition-all duration-300">Tableau de bord</a>
                        <a href="/logout" class="py-2 px-4 bg-red-500 text-white font-semibold rounded-md hover:bg-red-400 transition-all duration-300">Déconnexion</a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="/register" class="py-2 px-4 bg-green-500 text-white font-semibold rounded-md hover:bg-green-400 transition-all duration-300">Inscription</a>
                    <a href="/login" class="py-2 px-4 bg-transparent border-2 border-gray-500 text-gray-700 font-semibold rounded-md hover:bg-gray-100 transition-all duration-300">Connexion</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    

    <!-- Main Content -->
    <div class="container mx-auto  " >
        <?php echo $content; ?>
    </div>



    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-10 mt-20">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <p>&copy; 2025 EventManager. Tous droits réservés.</p>
            <div class="space-x-6">
                <a href="/about" class="text-gray-400 hover:text-white transition-all duration-300">À propos</a>
                <a href="/contact" class="text-gray-400 hover:text-white transition-all duration-300">Contact</a>
            </div>
        </div>
    </footer>

    <script src="/js/app.js"></script>
</body>
</html>
